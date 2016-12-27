<?

// вывод текущей даты и времени

function gettime()
{
?>
        <script type="text/javascript" language="JavaScript">
                var seconds = "yes";
                var font = "Arial, Verdana, Sans";
                var size = "3";
                var d = new Date();
                var h = d.getHours();
                var m = d.getMinutes();
                var s = d.getSeconds();
                if (m < 10) m = "0" + m;
                if (s < 10) s = "0" + s;
                var time = h + ':' + m;
                if (seconds == 'yes')
                        {
                        var time = time + ':' + s;
                        }
                document.getElementById("clock").innerHTML = "<font face=\"" + font + "\" size=\"" + size + "\">" + time + "</font>";
                setTimeout("time()", 1000);
                }
        </script>
<?
}

// функция для случайного генерирования пороля

function getRandomPassword () {
  $maxcount = 20;
  $rand78 = "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-=_+abcdefghijklmnopqrstuvwxyz";
  srand((double)microtime()*1000000);
  $pass = "";
  for($count = 0; $count < $maxcount; $count++)
  $pass .= substr($rand78, rand(0, 77), 1);
  return $pass;
}

// функция проверки вводимых имени и пароля

function validateDBLoginInfo ($v_login, $v_passw) {
  global $table, $login, $passw, $url, $database, $dbhost,$dblogin, $dbpassw;
  $link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connectНе могу подключиться к серверу $dbhost");
  mysql_select_db ($database) or die ("Не могу выбрать базу $database");
 $r_main = mysql_query("SELECT $passw FROM $table WHERE $login = '$v_login' and $passw = '$v_passw'");
  if (mysql_numrows($r_main) > 0) {
  $data = mysql_fetch_array($r_main);
  return $data[$passw];
  }
  mysql_close($link);
  return "";
}

// вывод сообщения в случае неудачной аутентификации

function print_NoAuthHTML() {
global $url;
?>
<html>
<head>
<title>Неверные данные авторизации!</title>
</head>
<body>
<SCRIPT language="JavaScript">
window.alert('Извините, но вы не прошли авторизацию.\nДоступ закрыт!');
window.location.href='<?=$url?>';
</SCRIPT>
<?

?>
</body>
</html>
<?
exit;
}

// вывод формы для аутентификации в системе

function print_AuthFormHTML() {
  global $flogin;
  global $fpasswd;
  global $fauth;
  global $PHP_SELF;
?>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <title>Аутентификация</title>
  <link rel="stylesheet" type="text/css" href="../includes/style.css">
  </head>
  <body>
  <form action="<?=$PHP_SELF?>" method="post">
  <table cellspacing=2 cellpadding=2 border=0 width=300 align=center>
  <tr><td align=right>Имя пользователя:</td><td><input type="text" name="flogin" value="<?=( isset($flogin))?$flogin:""?>"></td></tr>
  <tr><td align=right>Пароль:</td><td><input type="password" name="fpasswd" value="<?=(isset($fpasswd))?$fpasswd:""?>"></td></tr>
  <tr><td colspan=2><div align="center"><input type="submit" value="войти"></div></td></tr>
  </table>
  <input type="hidden" name="fauth" value="1">
  </form>
  </body>
  </html>
<?PHP
exit;
}

// функция аутентификации. Возвращает True, если аутентификация прошла успешно или false в противном случае.

function Auth () {
  //
  global $flogin;
  global $fpasswd;
  global $fauth;
  global $user;

  session_start();
  if (session_is_registered("user")) {
    $tmp_passwd = validateDBLoginInfo ($user["login"], $user["passw"]);
    if ($tmp_passwd != $user["passw"])
      print_NoAuthHTML();
  } else {
      if (!isset($fauth) || !isset($flogin) || !isset($fpasswd))
        print_AuthFormHTML();
      elseif(isset($fauth) && isset($flogin) && isset($fpasswd)) {
        if ($flogin != "" && $fpasswd != "") {
                $tmp_passwd = validateDBLoginInfo ($flogin, $fpasswd);
                if ($tmp_passwd != "") {
                $user = array ("login" => $flogin, "passw" => $tmp_passwd);
                session_register("user");
              } else
                print_NoAuthHTML();
        } else
            print_NoAuthHTML();
      }
    }
}

// вывод меню информационного модуля

function display_main_menu()
{
?>
<a href="../teachers/index.php">преподавательский модуль</a><br>
<a href="../students/index.php">студенческий модуль</a><br>
<?
}

// вывод меню студенческого модуля

function display_student_menu()
{
?>
<a href="index.php">перейти на сайт</a><br>
<a href="course_sub.php">курсы</a><br>
<?
}

// вывод меню преподавательского модуля

function display_teacher_menu()
{
?>
<a href="index.php">перейти на сайт</a><br>
<a href="courses.php">курсы</a><br>
<?
}

// вывод меню администраторского модуля

function display_admin_menu()
{
?>
<a href="index.php">перейти на сайт</a><br>
<a href="user_categories.php">категории пользователей</a><br>
<a href="users.php">пользователи</a><br>
<a href="course_control.php">типы контроля</a><br>
<a href="courses.php">курсы</a><br>
<a href="course_subscribes.php">подписчики на курсы</a><br>
<?
}

// вывод заголовка страницы

function print_html_header($mod)
{
if ($mod=='admin')
{
$title='Административный модуль';
$style_link='../includes/style.css';
$headColor='red';
}
elseif ($mod=='teach')
{
$title='Преподавательский модуль';
$style_link='../includes/style.css';
$headColor='navy';
}
elseif ($mod=='student')
{
$title='Студенческий модуль';
$style_link='../includes/style.css';
$headColor='navy';
}
else
{
$title='Информационный модуль';
$style_link='../includes/style.css';
$headColor='black';
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$title ?></title>
<link rel="stylesheet" type="text/css" href="<?=$style_link ?>">
</head>
<body>
<h1><font color=<?=$headColor?>><?=$title ?></font></h1>
<table border=0 width=100% align=center>
<tr>
<td width=300 valign=top>
<?
if ($mod=='admin')
{
display_admin_menu();
}
elseif ($mod=='teach')
{
display_teacher_menu();
}
elseif ($mod=='student')
{
display_student_menu();
}
else
{
display_main_menu();
}


?>
</td>
<td>
<?
}

// вывод завершающего блока страницы

function print_html_footer()
{
?>
</td>
</tr>
</table>
<hr color=navy>
<div align="center">
<font class='small'  color="black" size="1"> &copy; 2004 Украинский государственный химико-технологический университет. <br>Кафедра информационных технологий и кибернетики. Все права защищены.<br>
<br>
Дизайн и программирование: by <a href="mailto:webmaster@ua.fm">webmaster</a></font></center>
</div>
</body>
</html>
<?
}

function print_form_list($tbl, $ident, $cident)
{
global $dbhost,$dblogin, $dbpassw, $database;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Не могу подключиться к серверу $dbhost");
mysql_select_db ($database) or die ("Не могу выбрать базу $database");
if ($tbl=='user_categories')
{
$ID='usercat_id';
$IDname='usercat_name';
}
if ($tbl=='users')
{
$ID='user_id';
$IDname1='username';
$IDname2='usermediumname';
$IDname3='userlastname';
$CID='usercat_id';
}
if ($tbl=='courses')
{
$ID='course_id';
$IDname='course_name';
}
if ($tbl=='course_control')
{
$ID='control_id';
$IDname='control_name';
}
if ($tbl=='course_themes')
{
$ID='theme_id';
$IDname='theme_name';
}
if ($tbl=='course_questions')
{
$ID='question_id';
$IDname='question';
}
if ($ident=='n')
{
if ($cident=='n')
{
$query='SELECT * FROM '.$tbl;
}
else
{
$query='SELECT * FROM '.$tbl.' where '.$CID.'='.$cident;
}
}
else
{
$query='SELECT * FROM '.$tbl.' where '.$ID.'='.$ident;
}
$result = mysql_query($query);

echo "<select name=".$ID.">";

while ($row = mysql_fetch_object($result))
{
if (isset($IDname)==true)
{
echo "<option value='".$row->$ID."'>".$row->$IDname."</option>";
}
else
{
echo "<option value='".$row->$ID."'>".$row->$IDname1." ".$row->$IDname2." ".$row->$IDname3."</option>";
}
}
echo "</select>";
mysql_close($link);

}

function print_view_list($tbl, $ident)
{
global $dbhost,$dblogin, $dbpassw, $database;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Не могу подключиться к серверу $dbhost");
mysql_select_db ($database) or die ("Не могу выбрать базу $database");
if ($tbl=='user_categories')
{
$ID='usercat_id';
$IDname='usercat_name';
}
if ($tbl=='users')
{
$ID='user_id';
$IDname1='username';
$IDname2='usermediumname';
$IDname3='userlastname';
}
if ($tbl=='courses')
{
$ID='course_id';
$IDname='course_name';
}
if ($tbl=='course_control')
{
$ID='control_id';
$IDname='control_name';
}
if ($tbl=='course_themes')
{
$ID='theme_id';
$IDname='theme_name';
}
if ($tbl=='course_questions')
{
$ID='question_id';
$IDname='question';
}
if ($ident=='n')
{
$query='SELECT * FROM '.$tbl;
}
else
{
$query='SELECT * FROM '.$tbl.' where '.$ID.'='.$ident;
}
$result = mysql_query($query);

while ($row = mysql_fetch_object($result))
{
if (isset($IDname)==true)
{
echo $row->$IDname;
}
else
{
echo $row->$IDname1." ".$row->$IDname2." ".$row->$IDname3;
}
}
mysql_close($link);
}
?>