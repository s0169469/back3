<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['name']) || !preg_match('/^([a-zA-Z\'\-]+\s*|[а-яА-ЯёЁ\'\-]+\s*)$/u', $_POST['name'])) {
  print('Введите имя корректно.<br/>');
  $errors = TRUE;
}

if (empty($_POST['birth_date']) || !is_numeric($_POST['birth_date']) || !preg_match('/^\d+$/', $_POST['birth_date'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email'])) {
  print('Введите почту корректно.<br/>');
  $errors = TRUE;
}

if (empty($_POST['sex']) || !($_POST['sex']=='ж' || $_POST['sex']=='м')) {
  print('Выберите пол.<br/>');
  $errors = TRUE;
}

if (empty($_POST['amount_of_limbs']) || !is_numeric($_POST['amount_of_limbs']) || ($_POST['amount_of_limbs']<2) || ($_POST['amount_of_limbs']>4)) {
  print('Выберите количество конечностей.<br/>');
  $errors = TRUE;
}

//if (empty($_POST['abilities'])) {
  //print('Выберите сверхспособности.<br/>');
  //$errors = TRUE;
//}
 $abilities = [10 => 'Бессмертие', 20 => 'Прохождение сквозь стены', 30 => 'Левитация'];
  if (empty($_POST['abilities']) || !is_array($_POST['abilities'])) {
    print('Выберите сверхспособности.<br/>');
    $errors = TRUE;
  }
  else {
    foreach ($_POST['abilities'] as $ability) {
      if (!in_array($ability, $abilities)) {
        print('Выберите сверхспособности.<br/>');
        $errors = TRUE;
        break;
      }
    }
  }

if (empty($_POST['biography'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}

if (empty($_POST['informed']) || !($_POST['informed'] == 'on' || $_POST['informed'] == 1)) {
  print('Поставьте галочку "С контрактом ознакомлен(а)".<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

// Сохранение в базу данных.
$user = 'u52811';
$pass = '8150350';
$db = new PDO('mysql:host=localhost;dbname=u52811', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, birth_date = ?, sex = ?, amount_of_limbs = ?, biography = ?, informed = ?");
  $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['birth_date'], $_POST['sex'], $_POST['amount_of_limbs'], $_POST['biography'], 1]);
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

$app_id = $db->lastInsertId();

try{
  $stmt = $db->prepare("REPLACE INTO abilities (id,name_of_ability) VALUES (10, 'Бессмертие'), (20, 'Прохождение сквозь стены'), (30, 'Левитация')");
  $stmt-> execute();
}
catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
}

//try {
  //$stmt = $db->prepare("INSERT INTO link SET app_id = ?, ab_id = ?");
  //foreach ($_POST['abilities'] as $ability) {
  //$stmt -> execute([$app_id, $ability]);
  //}
//}
try {
  $stmt = $db->prepare("INSERT INTO link SET app_id = ?, ab_id = ?");
  foreach ($_POST['abilities'] as $ability) {
    if ($ability=='Бессмертие')
    {$stmt -> execute([$app_id, 10]);}
    else if ($ability=='Прохождение сквозь стены')
    {$stmt -> execute([$app_id, 20]);}
    else if ($ability=='Левитация')
    {$stmt -> execute([$app_id, 30]);}
  }
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');
//header('Location: http://u52811.kubsu-dev.ru/backend3/files/file1.html');
