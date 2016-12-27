<?

function print_header ()
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Студенческий модуль</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<body>
<?
}

function print_footer ()
{
?>
</body>
</html>
<?
}

function prepair_test_questions($theme_id)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database;
$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$result = mysql_query("SELECT * FROM course_questions WHERE theme_id=".$theme_id);
if (mysql_numrows($result) > 0)
{
$query_create_tmp_tbl="
CREATE TABLE ".$user_id."_".$theme_id."_questions (
                    question_id bigint(10) NOT NULL auto_increment,
                    theme_id bigint(10) default NULL,
                    course_id bigint(10) default NULL,
                    question text,
                    answer1_id bigint(10) default NULL,
                    answer2_id bigint(10) default NULL,
                    answer3_id bigint(10) default NULL,
                    answer4_id bigint(10) default NULL,
                    answer5_id bigint(10) default NULL,
                    answer1 text,
                    answer2 text,
                    answer3 text,
                    answer4 text,
                    answer5 text,
                    answer1_count bigint(3) default NULL,
                    answer2_count bigint(3) default NULL,
                    answer3_count bigint(3) default NULL,
                    answer4_count bigint(3) default NULL,
                    answer5_count bigint(3) default NULL,
                    rand_num int (3) default NULL,
                    PRIMARY KEY  (question_id)
                  ) TYPE=MyISAM ";
$result_tmp_tbl = mysql_query($query_create_tmp_tbl);

while ($row = mysql_fetch_array($result))
{
$s=rand(0, 100);
$query_insert="
insert into ".$user_id."_".$theme_id."_questions (question_id, theme_id, course_id, question, answer1_id, answer2_id, answer3_id, answer4_id, answer5_id, answer1, answer2, answer3, answer4, answer5,answer1_count, answer2_count, answer3_count, answer4_count, answer5_count, rand_num) values ('$row[0]','$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]', '$row[7]', '$row[8]', '$row[9]', '$row[10]', '$row[11]', '$row[12]', '$row[13]', '$row[14]', '$row[15]', '$row[16]', '$row[17]', '$row[18]', '$s')";
$result_insert = mysql_query($query_insert);
}
} else {
echo "<br>not find values<br>";
}
}

function select_testing_questions($theme_id)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database, $theme_id;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$result = mysql_query("SELECT question_id, rand_num FROM ".$user_id."_".$theme_id."_questions order by rand_num");
return $result;
}

function print_question($ques_num)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database, $theme_id, $nextn;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$query="SELECT * FROM ".$user_id."_".$theme_id."_questions where question_id=".$ques_num;
$result = mysql_query($query);
if (mysql_numrows($result) > 0)
{
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo "<b>ВОПРОС:  </b>".$row['question']."<br>";
echo "Варианты ответов:<br>";
echo "<b>".$row["answer1_id"].":</b> ".$row["answer1"]."<br>";
echo "<b>".$row["answer2_id"].":</b> ".$row["answer2"]."<br>";
echo "<b>".$row["answer3_id"].":</b> ".$row["answer3"]."<br>";
echo "<b>".$row["answer4_id"].":</b> ".$row["answer4"]."<br>";
echo "<b>".$row["answer5_id"].":</b> ".$row["answer5"]."<br>";
echo "<form action=\"answer_insert.php\" method=\"post\">";
echo "<input name=\"theme_id\" type=\"hidden\" value=\"$theme_id\">";
echo "<input name=\"user_id\" type=\"hidden\" value=\"$user_id\">";
echo "<input name=\"nextn\" type=\"hidden\" value=\"$nextn\">";
echo "<input name=\"question_id\" type=\"hidden\" value=".$row['question_id'].">";
echo "<select size=\"1\" name=\"answer_id_count\">";
echo "<option value=\"".$row["answer1_id"]."|".$row["answer1_count"]."\">".$row["answer1_id"]."</option>";
echo "<option value=\"".$row["answer2_id"]."|".$row["answer2_count"]."\">".$row["answer2_id"]."</option>";
echo "<option value=\"".$row["answer3_id"]."|".$row["answer3_count"]."\">".$row["answer3_id"]."</option>";
echo "<option value=\"".$row["answer4_id"]."|".$row["answer4_count"]."\">".$row["answer4_id"]."</option>";
echo "<option value=\"".$row["answer5_id"]."|".$row["answer5_count"]."\">".$row["answer5_id"]."</option>";
echo "</select>";
echo "<br><input type=\"submit\" value=\"Ответить\">";
echo "</form>";
echo "<hr>";
}
}
else
{
echo "<br>not find values<br>";
}
}

function select_course_id ($theme_id)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database, $theme_id;
$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$query="select course_id from course_themes where theme_id=".$theme_id;
$result = mysql_query($query);
$row = mysql_fetch_array($result);
return $row["course_id"];
}

function answer_insert()
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database, $theme_id, $question_id, $answer_id_count;
$pieces = explode("|", $answer_id_count);
$answer_id = $pieces[0];
$answer_count = $pieces[1];
$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$course_id = select_course_id ($theme_id);
$query="insert into course_testing (user_id, course_id, theme_id, question_id , answer_id, answer_count) values ('$user_id', '$course_id', '$theme_id', '$question_id', '$answer_id', '$answer_count')";
$result = mysql_query($query);

$query_del="delete from ".$user_id."_".$theme_id."_questions where question_id=".$question_id;
$result_del = mysql_query($query_del);
}

function select_answer_count($question_id)
{
global $dbhost, $dblogin, $dbpassw, $database;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$query="select * from course_questions where question_id=".$question_id;
$result = mysql_query($query);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
$answer_count=0;
for ($y=1; $y<=5; $y++)
{
if ($answer_count<$row["answer".$y."_count"])
{
$answer_count=$row["answer".$y."_count"];
}
}
}
return $answer_count;
}

function select_theme_success_count($theme_id)
{
global $dbhost, $dblogin, $dbpassw, $database;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$query="select * from course_questions where theme_id=".$theme_id;
$result = mysql_query($query);
$a_count=0;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
$q_count=select_answer_count($row["question_id"]);
$a_count=$a_count+$q_count;
}

return $a_count;
}

function select_theme_count ($theme_id)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database;

$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$course_id = select_course_id ($theme_id);
$query="select answer_count from course_testing where user_id=".$user_id." and course_id=".$course_id."  and theme_id=".$theme_id;
$result = mysql_query($query);
$a_count=0;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
$a_count=$a_count+$row["answer_count"];
}

return $a_count;
}

function view_testing_result()
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database, $theme_id, $question_id, $answer_id;
$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$course_id = select_course_id ($theme_id);
$query="insert into course_testing (user_id, course_id, theme_id, question_id , answer_id) values ('$user_id', '$course_id', '$theme_id', '$question_id', '$answer_id')";
$result = mysql_query($query);
}

function testing_over($theme_id)
{
global $user_id, $dbhost, $dblogin, $dbpassw, $database; 
$link = mysql_connect($dbhost, $dblogin, $dbpassw) or die ("Could not connect $dbhost");
mysql_select_db ($database) or die ("Could not select database $database");
$query="DROP TABLE ".$user_id."_".$theme_id."_questions";
return $result = mysql_query($query);
}
?>