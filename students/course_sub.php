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
  $query = "SELECT * FROM course_subscribes where user_id=".$user["login"];
  if ($find != ''){
  $query = $query . " and course_id LIKE '%$find%'";
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
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=user_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field user_id\" border=\"0\"><br><b>user_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=course_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field course_id\" border=\"0\"><br><b>course_id</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'course_sub.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Page: ". $db->paginal_links_compact(10) ."</p>\n\n";
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
  $query = "SELECT * FROM course_subscribes WHERE (user_id=$id)";
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

// Update Record
if ($action == 'update'){
  $query = "UPDATE course_subscribes SET user_id='$user_id', course_id='$course_id' WHERE(user_id=$id)";
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
  $query = "DELETE FROM course_subscribes WHERE (user_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?stpage=$stpage&orderby=$orderby&find=$find\">";
  }
}

// Add Record Form
if ($action == 'add'){
  print "<h1>Add Record</h1>\n";
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
  $query = "INSERT INTO course_subscribes (user_id,course_id) VALUES ('$user_id','$course_id')";
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
    $course_id = $row->course_id;
  }
  else {
    $user_id = '';
    $course_id = '';
  }
  print "<tr><td>user_id: </td><td><input type=\"text\" name=\"user_id\" value=\"$user_id\"></td></tr>\n";
  print "<tr><td>course_id: </td><td><input type=\"text\" name=\"course_id\" value=\"$course_id\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Save Record\"></td></tr>\n";
}

print_html_footer();
?>