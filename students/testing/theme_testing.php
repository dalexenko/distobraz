<?
require("../../includes/gl_vars.php");
require("testing_fns.php");
print_header ();
error_reporting(E_ERROR);
session_start();
if (session_is_registered("user"))
{
$user_id=$user["login"];
}
if ($i =='')
// если есть переменная, сигнализирующая о конце теста
{
if (!isset($theme_id)==1)
{
echo "Переменная не найдена";
}
else
// если нет переменной, сигнализирующей о конце теста
{
$result = select_testing_questions($theme_id);
if (mysql_numrows($result) > 0)
{
$y=0;
while ($row = mysql_fetch_array($result))
{
$questions_ids[$y]=$row[0];
$y++;
}
if (!isset($nextn)==1 || $nextn=='' || $nextn>(count($questions_ids)-1))
{
$nextn=0;
print_question($questions_ids[$nextn]);
$nextn=$nextn+1;
}
else
{
print_question($questions_ids[$nextn]);
$nextn=$nextn+1;
}
echo "<form action=\"theme_testing.php\" method=\"get\">";
echo "<input name=\"theme_id\" type=\"hidden\" value=\"$theme_id\">";
echo "<input name=\"nextn\" type=\"hidden\" value=\"$nextn\">";
echo "<input type=\"submit\" value=\"next\">";
echo "</form>";
echo "<form action=\"testing_over.php\" method=\"get\">";
echo "<input name=\"theme_id\" type=\"hidden\" value=\"$theme_id\">";
echo "<input type=\"submit\" value=\"Конец теста\">";
echo "</form>";
}
}
}
else
{
echo "test is over!";
echo "<form action=\"testing_over.php\" method=\"get\">";
echo "<input name=\"theme_id\" type=\"hidden\" value=\"$theme_id\">";
echo "<input type=\"submit\" value=\"Конец теста\">";
echo "</form>";
}
print_footer ();