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
  $query = "SELECT * FROM course_control";
  if ($find != ''){
    $query = $query . " WHERE (control_id LIKE '%$find%' OR control_name LIKE '%$find%')";
  }
  if ($orderby != ''){
    $query = $query . " ORDER BY $orderby";
  }
  print "<h1>Список контролей курсов</h1>\n";

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
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=control_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field control_id\" border=\"0\"><br><b>control_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=control_name\"><img src=\"../pics/arrow.gif\" alt=\"Order by field control_name\" border=\"0\"><br><b>control_name</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'course_control.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Страница: ". $db->paginal_links_compact(10) ."</p>\n\n";
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Добавить новый контроль\"></form>\n";
}

// Edit Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM course_control WHERE (control_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->control_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// Update Record
if ($action == 'update'){
  $query = "UPDATE course_control SET control_id='$control_id', control_name='$control_name' WHERE(control_id=$id)";
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
  print "  <input type=\"submit\" value=\"Да\">\n";
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
  $query = "DELETE FROM course_control WHERE (control_id=$id)";
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
  $query = "INSERT INTO course_control (control_id,control_name) VALUES ('$control_id','$control_name')";
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
    $control_id = $row->control_id;
    $control_name = $row->control_name;
  }
  else {
    $control_id = '';
    $control_name = '';
  }
  print "<input type=\"hidden\" name=\"control_id\" value=\"$control_id\">\n";
  print "<tr><td>control_name: </td><td><input type=\"text\" name=\"control_name\" value=\"$control_name\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Сохранить запись\"></td></tr>\n";
}

print_html_footer();
?>