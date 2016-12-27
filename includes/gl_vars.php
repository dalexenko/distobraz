<?PHP
$version = "1.0.0 beta 1";
$table = "users"; //таблица с паролем и логином
$login = "user_id"; //поле в таблице $table с логином
$passw = "passwd"; //поле в таблице $table с паролем
$url = $PHP_SELF; //страница переадрессации
$database = "distobraz"; //имя базы данных
$dbhost = "localhost"; //хост базы данных
$dblogin = "root"; //логин для базы данных
$dbpassw = ""; //пароль для базы данных

echo "<p align=right>version: <font color=red><b> ".$version."</b></font></p>";
?>