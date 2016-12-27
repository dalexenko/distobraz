<?PHP
require("../includes/gl_vars.php");
require("../includes/gl_fns.php");
Auth();
print_html_header('student');

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
  $query = "SELECT * FROM course_themes where course_id=".$course_id;
  if ($find != ''){
  $query = $query." and (theme_id LIKE '%$find%' OR theme_name LIKE '%$find%' OR theme_query LIKE '%$find%' OR success_count LIKE '%$find%')";
  }
  if ($orderby != ''){
    $query = $query." ORDER BY $orderby";
  }
  print "<h1>Список тем курса</h1>\n";

  // Find Form
  print "<form action=\"$PHP_SELF\" method=\"GET\">\n";
  print "<input type=\"hidden\" name=\"course_id\" value=\"$course_id\">\n";
  print "<input type=\"text\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Найти\">\n";
  if ($find != ''){
    print "<br><a href=\"$PHP_SELF?course_id=$course_id\">Показать все записи</a>\n";
  }
  print "</form>\n";

  print "<table border=\"1\">\n";
  print "<tr>\n";
  print "<td><a href=\"$PHP_SELF?course_id=$course_id&stpage=$stpage&find=$find&orderby=theme_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field theme_id\" border=\"0\"><br><b>theme_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=course_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field course_id\" border=\"0\"><br><b>course_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?course_id=$course_id&stpage=$stpage&find=$find&orderby=theme_name\"><img src=\"../pics/arrow.gif\" alt=\"Order by field theme_name\" border=\"0\"><br><b>theme_name</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?course_id=$course_id&stpage=$stpage&find=$find&orderby=theme_query\"><img src=\"../pics/arrow.gif\" alt=\"Order by field theme_query\" border=\"0\"><br><b>theme_query</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?course_id=$course_id&stpage=$stpage&find=$find&orderby=success_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field success_count\" border=\"0\"><br><b>success_count</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'course_themes.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Страница: ". $db->paginal_links_compact(10) ."</p>\n\n";
 /* 
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Add Record\"></form>\n";
  */
}

// Edit Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM course_themes WHERE (theme_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->theme_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// Update Record
if ($action == 'update'){
  $query = "UPDATE course_themes SET theme_id='$theme_id', course_id='$course_id', theme_name='$theme_name', theme_query='$theme_query', success_count='$success_count' WHERE(theme_id=$id)";
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
  print "  <input type=\"submit\" value=\"Yes\">\n";
  print "  </form>\n";
  print "</td>\n";
  print "<td align=\"center\"><br>\n";
  print "  <form action=\"$PHP_SELF\" method=\"GET\">\n";
  print "  <input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "  <input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "  <input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "  <input type=\"submit\" value=\" No \">\n";
  print "  </form>\n";
  print "</td></tr>\n";
  print "</table>\n\n";
}

// Delete Record
if ($action == 'delete'){
  $query = "DELETE FROM course_themes WHERE (theme_id=$id)";
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
  $query = "INSERT INTO course_themes (theme_id,course_id,theme_name,theme_query,success_count) VALUES ('$theme_id','$course_id','$theme_name','$theme_query','$success_count')";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){

  $addirquery ="select max(theme_id) from course_themes";
  $addirresult = mysql_query ($addirquery);
  $adrow = mysql_fetch_array($addirresult);
  mkdir("../courses/$course_id/$adrow[0]");

    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?course_id=course_id&stpage=$stpage&orderby=$orderby&find=$find\">";
  }
  else {
    print mysql_error();
  }
}

function print_form($row) {
  if (isset($row)){
    $theme_id = $row->theme_id;
    $course_id = $row->course_id;
    $theme_name = $row->theme_name;
    $theme_query = $row->theme_query;
    $success_count = $row->success_count;
  }
  else {
    $theme_id = '';
    $course_id = '';
    $theme_name = '';
    $theme_query = '';
    $success_count = '';
  }
  print "<tr><td>theme_id: </td><td><input type=\"text\" name=\"theme_id\" value=\"$theme_id\"></td></tr>\n";
  print "<tr><td>course_id: </td><td><input type=\"text\" name=\"course_id\" value=\"$course_id\"></td></tr>\n";
  print "<tr><td>theme_name: </td><td><input type=\"text\" name=\"theme_name\" value=\"$theme_name\"></td></tr>\n";
  print "<tr><td>theme_query: </td><td><input type=\"text\" name=\"theme_query\" value=\"$theme_query\"></td></tr>\n";
  print "<tr><td>success_count: </td><td><input type=\"text\" name=\"success_count\" value=\"$success_count\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Сохранить запись\"></td></tr>\n";
}

print_html_footer();
?>