<html lang="ru">
<head>
    <title>Task3</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    
</head>
<body>
    <?php 
      $stmt = $db->prepare("SELECT * FROM ability");
      $stmt->execute();
      $result = $stmt->fetchAll();
    ?>
    <div class="content">
    <h1><a id="forma"></a>Форма:</h1>
      <form action="index.php" method="POST">
        <label>Ваше имя:<input type="text" name="name"placeholder="Введите имя"/></label><br/>
        <label>Почта <input type="email" name="email" placeholder="Введите почту"/></label><br/>
        <label>Дата рождения:<input type="date" name="date" value="2003-03-03"/></label><br/>
        <p>
          <label> Пол:
            <input type="radio" checked="checked" name="gender" value="Female"/>Женский</label>
          <label><input type="radio" name="gender" value="Male" />Мужской</label><br />
        </p>
        <p>
          Kоличество конечностей:<br/>
          <label><input type="radio" checked="checked" name="limbs" value="2"/>2</label>
          <label><input type="radio" name="limbs" value="4"/>4</label>
          <label><input type="radio" name="limbs" value="6"/>6</label>
          <label><input type="radio" name="limbs" value="8"/>8</label><br/>
        </p>
        <p>
        <label>
          Cверхспособности:<br />
          <select name="abilities[]" multiple="multiple">
            <?php foreach($result as $res) { ?>
              <option value="<?php echo $res['AbId']; ?>"><?php echo $res['AbName']; ?></option>
            <?php } ?>
          </select>
        </label><br />
        </p>
        <p>
        <label>Биография:<br/>
          <textarea name="biog"></textarea>
        </label><br />
        </p>
        <a id="bottom"></a><br/>
        <label><input type="checkbox" name="check" />С контрактом ознакомлен(а)</label><br/>
        <p><input type="submit" name="send" value="Отправить"/></p>
      </form>
    </div>
    <ol>
		<li>
			<h4>Вход в MariaBD</h4>
			<img src="SignIn.PNG">
		</li>
        <li>
			<h4>Описание таблиц</h4>
			<img src="DescribeTable.PNG">
		</li>
        <li>
			<h4>Содержание таблиц</h4>
			<img src="SelectTable.PNG">
		</li>
    </ol>
</body>
</html>
