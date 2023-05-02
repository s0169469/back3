<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
$user = 'u53298'; 
$pass = '8737048'; 
$db = new PDO('mysql:host=localhost;dbname=u53298', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
 
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Проверяем ошибки.
$errors = FALSE;
if (!preg_match( '/^([а-яё\s]+|[a-z\s]+)$/iu', $_POST['name'])){
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (!preg_match('/^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/', $_POST['email'])){
  print('Заполните email.<br/>');
  $errors = TRUE;
}
if (empty($_POST['abilities'])) {
  print('Выберите способность.<br/>');
  $errors = TRUE;
}
if (empty($_POST['biog'])) {
  print('Заполните поле текста.<br/>');
  $errors = TRUE;
}
if (empty($_POST['check'])) {
  print('Заполните чекбокс.<br/>');
  $errors = TRUE;
}
if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}
// Сохранение в базу данных.
// Подготовленный запрос. Не именованные метки.
try {
    $stmt = $db->prepare("INSERT INTO application (name, email, data, gender, limbs, biog)
     VALUES('{$_POST['name']}', '{$_POST['email']}', '{$_POST['date']}', '{$_POST['gender']}', '{$_POST['limbs']}','{$_POST['biog']}')");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['gender'], $_POST['limbs'], $_POST['biog']]);
    $stmt = $db->prepare("SELECT LAST_INSERT_ID()  as AppId");
    $stmt->execute();
    $result = $stmt->fetch();
    $sql = 'INSERT INTO ap_ab(AppID, AbId) VALUES(:AppID, :AbId)';
    $stmt = $db->prepare($sql);
    foreach($_POST['abilities'] as $ability)
    {
        $row = [
              'AppID' => $result["AppId"],
              'AbId' =>  $ability
        ];
        $stmt->execute($row); 
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
header('Location: ?save=1');
