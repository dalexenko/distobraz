<?
require("../../includes/gl_vars.php");
require("testing_fns.php");
print_header ();
error_reporting(E_ERROR);
session_start();
if (session_is_registered("user"))
{
$user_id=$user["login"];
$check_over_testing = testing_over($theme_id);
if ($check_over_testing ==1)
{
echo "тест успешно завершен<br>";
echo "<a href='view_testing_result.php?theme_id=$theme_id'>просмотр результата</a>";
}
else
{
echo "ОШИБКА!";
}
}
print_footer ();