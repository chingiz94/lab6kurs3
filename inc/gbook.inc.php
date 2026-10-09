<?php
/* Основные настройки */
mysqli_report(MYSQLI_REPORT_OFF); // чтобы ошибки ловились через or die(...)
date_default_timezone_set('Asia/Almaty');

define('DB_HOST', 'MySQL-8.4');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gbook');


$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME)
  or die('Ошибка подключения к БД: ' . mysqli_connect_error());
mysqli_set_charset($link, 'utf8');
/* Основные настройки */

/* Сохранение записи в БД */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name  = mysqli_real_escape_string($link, trim(strip_tags($_POST['name'])));
  $email = mysqli_real_escape_string($link, trim(strip_tags($_POST['email'])));
  $msg   = mysqli_real_escape_string($link, trim(strip_tags($_POST['msg'])));

  $sql = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";
  mysqli_query($link, $sql)
    or die('Ошибка добавления записи: ' . mysqli_error($link));
}
/* Сохранение записи в БД */

/* Удаление записи из БД */
if (isset($_GET['del'])) {
  $del = (int)$_GET['del'];
  if ($del > 0) {
    $sql = "DELETE FROM msgs WHERE id = $del";
    mysqli_query($link, $sql)
      or die('Ошибка удаления записи: ' . mysqli_error($link));
  }
}
/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>
<?php
/* Вывод записей из БД */
$sql = "SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) as dt
        FROM msgs
        ORDER BY id DESC";
$res = mysqli_query($link, $sql)
  or die('Ошибка выборки: ' . mysqli_error($link));

$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_close($link);

echo '<p>Всего записей в гостевой книге: ' . count($rows) . '</p>';

foreach ($rows as $row) {
  $name  = htmlspecialchars($row['name']);
  $email = htmlspecialchars($row['email']);
  $msg   = nl2br(htmlspecialchars($row['msg']));
  $date  = date('d-m-Y в H:i', $row['dt']);
  $id    = (int)$row['id'];

  echo "<p>
<a href=\"mailto:$email\">$name</a> $date
написал<br />$msg
</p>
<p align=\"right\">
<a href=\"index.php?id=gbook&del=$id\">Удалить</a>
</p>";
}
/* Вывод записей из БД */
?>
