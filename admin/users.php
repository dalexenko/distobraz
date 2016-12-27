<?PHP
require("../includes/gl_vars.php");
require("../includes/gl_fns.php");
Auth();
print_html_header('admin');

include_once('../includes/db_fns.php');

error_reporting(E_ERROR);
import_request_variables("GPC", '');
$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];

if (! isset($action)) {$action = 'list';}
if (! isset($stpage)) {$stpage = 1;}
if (! isset($orderby)) {$orderby = '';}
if (! isset($find)) {$find = '';}

// Records List
if ($action == 'list'){
  $query = "SELECT * FROM users";
  if ($find != ''){
    $query = $query . " WHERE (user_id LIKE '%$find%' OR usercat_id LIKE '%$find%' OR username LIKE '%$find%' OR usermediumname LIKE '%$find%' OR userlastname LIKE '%$find%' OR user_email LIKE '%$find%' OR passwd LIKE '%$find%')";
  }
  if ($orderby != ''){
    $query = $query . " ORDER BY $orderby";
  }
  print "<h1>Список пользователей</h1>\n";

  // Find Form
  print "<form action=\"$PHP_SELF\" method=\"GET\">\n";
  print "<input type=\"text\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Найти\">\n";
  if ($find != ''){
    print "<br><a href=\"$PHP_SELF\">Показать все записи</a>\n";
  }
  print "</form>\n";

  print "<table border=\"1\">\n";
  print "<tr>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=user_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field user_id\" border=\"0\"><br><b>user_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=usercat_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field usercat_id\" border=\"0\"><br><b>usercat_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=username\"><img src=\"../pics/arrow.gif\" alt=\"Order by field username\" border=\"0\"><br><b>username</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=usermediumname\"><img src=\"../pics/arrow.gif\" alt=\"Order by field usermediumname\" border=\"0\"><br><b>usermediumname</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=userlastname\"><img src=\"../pics/arrow.gif\" alt=\"Order by field userlastname\" border=\"0\"><br><b>userlastname</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=user_email\"><img src=\"../pics/arrow.gif\" alt=\"Order by field user_email\" border=\"0\"><br><b>user_email</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=passwd\"><img src=\"../pics/arrow.gif\" alt=\"Order by field passwd\" border=\"0\"><br><b>passwd</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'users.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Страница: ". $db->paginal_links_compact(10) ."</p>\n\n";
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Добавить нового пользователя\"></form>\n";
}

// Edit Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM users WHERE (user_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->user_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// View Record
if ($action == 'view'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM users WHERE (user_id=$id)";
  print "<h1>Просмотр записи</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);

  if (isset($row)){
    $user_id = $row->user_id;
    $usercat_id = $row->usercat_id;
    $username = $row->username." ".$row->usermediumname." ".$row->userlastname;
    $user_email = $row->user_email;
    $passwd = $row->passwd;
  }
  else {
    $user_id = '';
    $usercat_id = '';
    $username = '';
    $user_email = '';
    $passwd = '';
  }
  print "<table border=\"1\">\n";
  print "<tr><td>user_id:</td><td>$user_id</td></tr>\n";
  print "<tr><td>usercat_name:</td><td>";
  print_view_list ('user_categories', $usercat_id);
  print "</td></tr>\n";
  print "<tr><td>username:</td><td>$username</td></tr>\n";
  print "<tr><td>user_email:</td><td>$user_email</td></tr>\n";
  print "<tr><td>passwd:</td><td>$passwd</td></tr>\n";
  print "</table>\n";
  mysql_free_result($result);
}

// Update Record
if ($action == 'update'){
  $query = "UPDATE users SET user_id='$user_id', usercat_id='$usercat_id', username='$username', usermediumname='$usermediumname', userlastname='$userlastname', user_email='$user_email', passwd='$passwd' WHERE(user_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?stpage=$stpage&orderby=$orderby&find=$find\">";
  }
}

// Confirm (Delete)
if ($action == 'confirm'){
  print "<h1>Удалить запись</h1>\n";
  print "<table border=\"1\">\n";
  print "<tr><td colspan=\"2\"><br>Вы действительно хотите удалить запись?</td></tr>\n";
  print "<tr><td align=\"center\"><br>\n";
  print "  <form action=\"$PHP_SELF\" method=\"post\">\n";
  print "  <input type=\"hidden\" name=\"action\" value=\"delete\">\n";
  print "  <input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "  <input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "  <input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "  <input type=\"hidden\" name=\"id\" value=\"$id\">\n";
  print "  <input type=\"submit\" value=\" Да \">\n";
  print "  </form>\n";
  print "</td>\n";
  print "<td align=\"center\"><br>\n";
  print "  <form action=\"$PHP_SELF\" method=\"GET\">\n";
  print "  <input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "  <input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "  <input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "  <input type=\"submit\" value=\" Нет \">\n";
  print "  </form>\n";
  print "</td></tr>\n";
  print "</table>\n\n";
}

// Delete Record
if ($action == 'delete'){
  $query = "DELETE FROM users WHERE (user_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?stpage=$stpage&orderby=$orderby&find=$find\">";
  }
}

// Add Record Form
if ($action == 'add'){
  print "<h1>Добавить запись</h1>\n";
  print "<form action=\"$PHP_SELF\" method=\"post\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"insert\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<table border=\"1\">\n";
  print_form(0);
  print "</table>\n";
  print "</form>\n";
}

// Insert Record
if ($action == 'insert'){
  $query = "INSERT INTO users (user_id,usercat_id,username,usermediumname,userlastname,user_email,passwd) VALUES ('$user_id','$usercat_id','$username','$usermediumname','$userlastname','$user_email','$passwd')";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?stpage=$stpage&orderby=$orderby&find=$find\">";
  }
  else {
    print mysql_error();
  }
}

function print_form($row) {
  if (isset($row)){
    $user_id = $row->user_id;
    $usercat_id = $row->usercat_id;
    $username = $row->username;
    $usermediumname = $row->usermediumname;
    $userlastname = $row->userlastname;
    $user_email = $row->user_email;
    $passwd = $row->passwd;
  }
  else {
    $user_id = '';
    $usercat_id = '';
    $username = '';
    $usermediumname = '';
    $userlastname = '';
    $user_email = '';
    $passwd = '';
  }
  print "<input type=\"hidden\" name=\"user_id\" value=\"$user_id\">\n";
  print "<tr><td>usercat_name: </td><td>";
  print_form_list('user_categories', 'n', 'n');
  print "</td></tr>\n";
  print "<tr><td>username: </td><td><input type=\"text\" name=\"username\" value=\"$username\"></td></tr>\n";
  print "<tr><td>usermediumname: </td><td><input type=\"text\" name=\"usermediumname\" value=\"$usermediumname\"></td></tr>\n";
  print "<tr><td>userlastname: </td><td><input type=\"text\" name=\"userlastname\" value=\"$userlastname\"></td></tr>\n";
  print "<tr><td>user_email: </td><td><input type=\"text\" name=\"user_email\" value=\"$user_email\"></td></tr>\n";
  print "<tr><td>passwd: </td><td><input type=\"text\" name=\"passwd\" value=\"$passwd\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Сохранить запись\"></td></tr>\n";
}

print_html_footer();
?>