<head>
        <link rel="stylesheet" href="style.css">
</head> 
<form action="" class="forma" method="POST">
    <label>
        Имя:<br>
        <input id="data" name="name" placeholder="Введите Ваше имя">
    </label><br>
    <label>
        Email:<br>
        <input id="data" name="email" type="email" placeholder="Введите вашу почту">
    </label><br>
    <label>
        Дата рождения:<br>
         <select id="data" name="birth_date">
         <?php 
          for ($i = 1922; $i <= 2022; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
          }
         ?>
        </select>  
    </label><br>
    Пол:<br>
      <label><input id="data" type="radio" name="sex" value="ж">Ж</label>
      <label><input id="data" type="radio" name="sex" value="м">М</label><br />
    Количество конечностей:<br />
      <label><input id="data" type="radio" name="amount_of_limbs" value="2"> 2 </label>
      <label><input id="data" type="radio" name="amount_of_limbs" value="3"> 3 </label>
      <label><input id="data" type="radio" name="amount_of_limbs" value="4"> 4 </label><br>
    <label>
        Сверхспособности:<br>
        <select id="data" name="abilities[]" multiple="multiple">
          <option value="Бессмертие">Бессмертие</option>
          <option value="Прохождение сквозь стены">Прохождение сквозь стены</option>
          <option value="Левитация">Левитация</option>
        </select>
    </label><br>
    <label>
        Биография:<br />
        <textarea id="data" name="biography" placeholder="Введите текст"></textarea>
    </label><br>
    <label><input id="data" type="checkbox" name="informed">С контрактом ознакомлен(а)</label><br>
    <input id="sub" type="submit" value="Отправить">
  </form>
    
