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
  $query = "SELECT * FROM courses";
  if ($find != ''){
    $query = $query . " WHERE (course_id LIKE '%$find%' OR course_name LIKE '%$find%' OR user_id LIKE '%$find%' OR control_id LIKE '%$find%' OR success_count LIKE '%$find%')";
  }
  if ($orderby != ''){
    $query = $query . " ORDER BY $orderby";
  }
  print "<h1>Список курсов</h1>\n";

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
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=course_id\"><img src=\"../pics/../pics/arrow.gif\" alt=\"Order by field course_id\" border=\"0\"><br><b>course_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=course_name\"><img src=\"../pics/../pics/arrow.gif\" alt=\"Order by field course_name\" border=\"0\"><br><b>course_name</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=user_id\"><img src=\"../pics/../pics/arrow.gif\" alt=\"Order by field user_id\" border=\"0\"><br><b>user_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=control_id\"><img src=\"../pics/../pics/arrow.gif\" alt=\"Order by field control_id\" border=\"0\"><br><b>control_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=success_count\"><img src=\"../pics/../pics/arrow.gif\" alt=\"Order by field success_count\" border=\"0\"><br><b>success_count</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'courses.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Страница: ". $db->paginal_links_compact(10) ."</p>\n\n";
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Добавить новый курс\"></form>\n";
}

// Edit Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM courses WHERE (course_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->course_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// View Record Form
if ($action == 'view'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM courses WHERE (course_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
    if (isset($row)){
    $course_id = $row->course_id;
    $course_name = $row->course_name;
    $user_id = $row->user_id;
    $control_id = $row->control_id;
    $success_count = $row->success_count;
  }
  else {
    $course_id = '';
    $course_name = '';
    $user_id = '';
    $control_id = '';
    $success_count = '';
  }
  print "<table border=\"1\">\n";
  print "<tr><td>course_id:</td><td>$course_id</td></tr>\n";
  print "<tr><td>course_name:</td><td>$course_name</td></tr>\n";
  print "<tr><td>user_id: </td><td>";
  print_view_list('users', $user_id);
  print "</td></tr>\n";
  print "<tr><td>control_id: </td><td>";
  print_view_list('course_control', $control_id);
  print "</td></tr>\n";
  print "<tr><td>success_count:</td><td>$success_count</td></tr>\n";
  print "</table>\n";
  mysql_free_result($result);
}

// View Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM courses WHERE (course_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->course_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// Update Record
if ($action == 'update'){
  $query = "UPDATE courses SET course_id='$course_id', course_name='$course_name', user_id='$user_id', control_id='$control_id', success_count='$success_count' WHERE(course_id=$id)";
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
  print "  <input type=\"submit\" value=\" Нет\">\n";
  print "  </form>\n";
  print "</td></tr>\n";
  print "</table>\n\n";
}

// Delete Record
if ($action == 'delete'){

  $deldirquery ="select course_id from courses WHERE (course_id=$id)";
  $deldirresult = mysql_query ($deldirquery);
  $delrow = mysql_fetch_array($deldirresult);

  $query = "DELETE FROM courses WHERE (course_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){

  rmdir("../courses/$delrow[0]/$delrow[1]");

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
  $query = "INSERT INTO courses (course_id,course_name,user_id,control_id,success_count) VALUES ('$course_id','$course_name','$user_id','$control_id','$success_count')";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){

  $addirquery ="select max(course_id) from courses";
  $addirresult = mysql_query ($addirquery);
  $adrow = mysql_fetch_array($addirresult);
  mkdir("../courses/$adrow[0]");

    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?stpage=$stpage&orderby=$orderby&find=$find\">";
  }
  else {
    print mysql_error();
  }
}

function print_form($row) {
  if (isset($row)){
    $course_id = $row->course_id;
    $course_name = $row->course_name;
    $user_id = $row->user_id;
    $control_id = $row->control_id;
    $success_count = $row->success_count;
  }
  else {
    $course_id = '';
    $course_name = '';
    $user_id = '';
    $control_id = '';
    $success_count = '';
  }
  print "<input type=\"hidden\" name=\"course_id\" value=\"$course_id\"></td></tr>\n";
  print "<tr><td>course_name: </td><td><input type=\"text\" name=\"course_name\" value=\"$course_name\"></td></tr>\n";
  print "<tr><td>user_id: </td><td>";
  print_form_list('users', 'n', '3');
  print "</td></tr>\n";
  print "<tr><td>control_id: </td><td>";
  print_form_list('course_control', 'n', 'n');
  print "</td></tr>\n";
  print "<tr><td>success_count: </td><td><input type=\"text\" name=\"success_count\" value=\"$success_count\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Сохранить запись\"></td></tr>\n";
}

print_html_footer();
?>