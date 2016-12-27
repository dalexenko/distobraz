<?PHP
require("../includes/gl_vars.php");
require("../includes/gl_fns.php");
Auth();
print_html_header('teach');;

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
  $query = "SELECT * FROM course_questions where theme_id=".$theme_id;
  if ($find != ''){
    $query = $query . " and (question_id LIKE '%$find%' OR course_id LIKE '%$find%' OR question LIKE '%$find%' OR answer1_id LIKE '%$find%' OR answer2_id LIKE '%$find%' OR answer3_id LIKE '%$find%' OR answer4_id LIKE '%$find%' OR answer5_id LIKE '%$find%' OR answer1 LIKE '%$find%' OR answer2 LIKE '%$find%' OR answer3 LIKE '%$find%' OR answer4 LIKE '%$find%' OR answer5 LIKE '%$find%' OR answer1_count LIKE '%$find%' OR answer2_count LIKE '%$find%' OR answer3_count LIKE '%$find%' OR answer4_count LIKE '%$find%' OR answer5_count LIKE '%$find%')";
  }
  if ($orderby != ''){
    $query = $query . " ORDER BY $orderby";
  }
  print "<h1>Список вопросов по курсу</h1>\n";

  // Find Form
  print "<form action=\"$PHP_SELF\" method=\"GET\">\n";
  print "<input type=\"hidden\" name=\"theme_id\" value=\"$theme_id\">\n";
  print "<input type=\"text\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Найти\">\n";
  if ($find != ''){
    print "<br><a href=\"$PHP_SELF?theme_id=$theme_id\">Показать все записи</a>\n";
  }
  print "</form>\n";

  print "<table border=\"1\">\n";
  print "<tr>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=question_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field question_id\" border=\"0\"><br><b>question_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=course_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field course_id\" border=\"0\"><br><b>course_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=theme_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field theme_id\" border=\"0\"><br><b>theme_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=question\"><img src=\"../pics/arrow.gif\" alt=\"Order by field question\" border=\"0\"><br><b>question</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer1_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer1_id\" border=\"0\"><br><b>answer1_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer2_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer2_id\" border=\"0\"><br><b>answer2_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer3_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer3_id\" border=\"0\"><br><b>answer3_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer4_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer4_id\" border=\"0\"><br><b>answer4_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer5_id\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer5_id\" border=\"0\"><br><b>answer5_id</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer1\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer1\" border=\"0\"><br><b>answer1</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer2\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer2\" border=\"0\"><br><b>answer2</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer3\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer3\" border=\"0\"><br><b>answer3</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=answer4\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer4\" border=\"0\"><br><b>answer4</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer5\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer5\" border=\"0\"><br><b>answer5</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer1_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer1_count\" border=\"0\"><br><b>answer1_count</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=answer2_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer2_count\" border=\"0\"><br><b>answer2_count</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer3_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer3_count\" border=\"0\"><br><b>answer3_count</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?theme_id=$theme_id&stpage=$stpage&find=$find&orderby=answer4_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer4_count\" border=\"0\"><br><b>answer4_count</b></a></td>\n";
  print "<td><a href=\"$PHP_SELF?stpage=$stpage&find=$find&orderby=answer5_count\"><img src=\"../pics/arrow.gif\" alt=\"Order by field answer5_count\" border=\"0\"><br><b>answer5_count</b></a></td>\n";

  print "<td>&nbsp;</td>\n";
  print "<td>&nbsp;</td>\n";
  print "</tr>\n\n";

  $db = new pdb;
  $db->dbh = $dbh;
  $db->sql = $query;
  $db->template = 'course_questions.inc';
  $db->recperpage = 20;
  $db->execute();

  print "</table>\n\n";

  print "<p>Страницы: ". $db->paginal_links_compact(10) ."</p>\n\n";
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"submit\" value=\"Добавить новый вопрос\"></form>\n";
}

// Edit Record Form
if ($action == 'edit'){
  if (!isset($id)){$id = 0;}
  $query = "SELECT * FROM course_questions WHERE (question_id=$id)";
  print "<h1>Редактировать запись</h1>\n";
  $result = mysql_query ($query) or die ("Query failed");
  $row = mysql_fetch_object($result);
  print "<form action=\"$PHP_SELF\" method=\"POST\">\n";
  print "<input type=\"hidden\" name=\"action\" value=\"update\">\n";
  print "<input type=\"hidden\" name=\"stpage\" value=\"$stpage\">\n";
  print "<input type=\"hidden\" name=\"orderby\" value=\"$orderby\">\n";
  print "<input type=\"hidden\" name=\"find\" value=\"$find\">\n";
  print "<input type=\"hidden\" name=\"id\" value=\"$row->question_id\">\n";
  print "<table border=\"1\">\n";
  print_form($row);
  print "</table>\n";
  print "</form>\n";
  mysql_free_result($result);
}

// Update Record
if ($action == 'update'){
  $query = "UPDATE course_questions SET question_id='$question_id', course_id='$course_id', theme_id='$theme_id', question='$question', answer1_id='$answer1_id', answer2_id='$answer2_id', answer3_id='$answer3_id', answer4_id='$answer4_id', answer5_id='$answer5_id', answer1='$answer1', answer2='$answer2', answer3='$answer3', answer4='$answer4', answer5='$answer5', answer1_count='$answer1_count', answer2_count='$answer2_count', answer3_count='$answer3_count', answer4_count='$answer4_count', answer5_count='$answer5_count' WHERE(question_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?theme_id=$theme_id&stpage=$stpage&orderby=$orderby&find=$find\">";
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

  $theme_query = "SELECT theme_id FROM course_questions WHERE (question_id=$id)";
  $theme_result = mysql_query ($theme_query);
  $theme_row = mysql_fetch_array ($theme_result);

  $query = "DELETE FROM course_questions WHERE (question_id=$id)";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?theme_id=$theme_row[0]&stpage=$stpage&orderby=$orderby&find=$find\">";
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
  $query = "INSERT INTO course_questions (question_id,course_id,theme_id,question,answer1_id,answer2_id,answer3_id,answer4_id,answer5_id,answer1,answer2,answer3,answer4,answer5,answer1_count,answer2_count,answer3_count,answer4_count,answer5_count) VALUES ('$question_id','$course_id','$theme_id','$question','$answer1_id','$answer2_id','$answer3_id','$answer4_id','$answer5_id','$answer1','$answer2','$answer3','$answer4','$answer5','$answer1_count','$answer2_count','$answer3_count','$answer4_count','$answer5_count')";
  $result = mysql_query ($query);
  if (mysql_errno() == 0){
    print "<meta http-equiv='refresh' content=\"0;URL=$PHP_SELF?theme_id=$theme_id&stpage=$stpage&orderby=$orderby&find=$find\">";
  }
  else {
    print mysql_error();
  }
}

function print_form($row) {
  if (isset($row)){
    $question_id = $row->question_id;
    $course_id = $row->course_id;
    $theme_id = $row->theme_id;
    $question = $row->question;
    $answer1_id = $row->answer1_id;
    $answer2_id = $row->answer2_id;
    $answer3_id = $row->answer3_id;
    $answer4_id = $row->answer4_id;
    $answer5_id = $row->answer5_id;
    $answer1 = $row->answer1;
    $answer2 = $row->answer2;
    $answer3 = $row->answer3;
    $answer4 = $row->answer4;
    $answer5 = $row->answer5;
    $answer1_count = $row->answer1_count;
    $answer2_count = $row->answer2_count;
    $answer3_count = $row->answer3_count;
    $answer4_count = $row->answer4_count;
    $answer5_count = $row->answer5_count;
  }
  else {
    $question_id = '';
    $course_id = '';
    $theme_id = '';
    $question = '';
    $answer1_id = '';
    $answer2_id = '';
    $answer3_id = '';
    $answer4_id = '';
    $answer5_id = '';
    $answer1 = '';
    $answer2 = '';
    $answer3 = '';
    $answer4 = '';
    $answer5 = '';
    $answer1_count = '';
    $answer2_count = '';
    $answer3_count = '';
    $answer4_count = '';
    $answer5_count = '';
  }
  print "<tr><td>question_id: </td><td><input type=\"text\" name=\"question_id\" value=\"$question_id\"></td></tr>\n";
  print "<tr><td>course_id: </td><td><input type=\"text\" name=\"course_id\" value=\"$course_id\"></td></tr>\n";
  print "<tr><td>theme_id: </td><td><input type=\"text\" name=\"theme_id\" value=\"$theme_id\"></td></tr>\n";
  print "<tr><td>question: </td><td><input type=\"text\" name=\"question\" value=\"$question\"></td></tr>\n";
  print "<tr><td>answer1_id: </td><td><input type=\"text\" name=\"answer1_id\" value=\"$answer1_id\"></td></tr>\n";
  print "<tr><td>answer2_id: </td><td><input type=\"text\" name=\"answer2_id\" value=\"$answer2_id\"></td></tr>\n";
  print "<tr><td>answer3_id: </td><td><input type=\"text\" name=\"answer3_id\" value=\"$answer3_id\"></td></tr>\n";
  print "<tr><td>answer4_id: </td><td><input type=\"text\" name=\"answer4_id\" value=\"$answer4_id\"></td></tr>\n";
  print "<tr><td>answer5_id: </td><td><input type=\"text\" name=\"answer5_id\" value=\"$answer5_id\"></td></tr>\n";
  print "<tr><td>answer1: </td><td><input type=\"text\" name=\"answer1\" value=\"$answer1\"></td></tr>\n";
  print "<tr><td>answer2: </td><td><input type=\"text\" name=\"answer2\" value=\"$answer2\"></td></tr>\n";
  print "<tr><td>answer3: </td><td><input type=\"text\" name=\"answer3\" value=\"$answer3\"></td></tr>\n";
  print "<tr><td>answer4: </td><td><input type=\"text\" name=\"answer4\" value=\"$answer4\"></td></tr>\n";
  print "<tr><td>answer5: </td><td><input type=\"text\" name=\"answer5\" value=\"$answer5\"></td></tr>\n";
  print "<tr><td>answer1_count: </td><td><input type=\"text\" name=\"answer1_count\" value=\"$answer1_count\"></td></tr>\n";
  print "<tr><td>answer2_count: </td><td><input type=\"text\" name=\"answer2_count\" value=\"$answer2_count\"></td></tr>\n";
  print "<tr><td>answer3_count: </td><td><input type=\"text\" name=\"answer3_count\" value=\"$answer3_count\"></td></tr>\n";
  print "<tr><td>answer4_count: </td><td><input type=\"text\" name=\"answer4_count\" value=\"$answer4_count\"></td></tr>\n";
  print "<tr><td>answer5_count: </td><td><input type=\"text\" name=\"answer5_count\" value=\"$answer5_count\"></td></tr>\n";

  print "<tr><td></td><td><input type=\"submit\" value=\"Сохранить запись\"></td></tr>\n";
}


print_html_footer();
?>