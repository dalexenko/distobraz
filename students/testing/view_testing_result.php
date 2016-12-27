<?
require("../../includes/gl_vars.php");
require("testing_fns.php");
print_header ();
error_reporting(E_ERROR);
session_start();
if (session_is_registered("user"))
{
$user_id=$user["login"];
echo "максимально возможное количесво баллов: ".select_theme_success_count($theme_id);
echo "<br>";
echo "набранное количество баллов: ".select_theme_count($theme_id);
echo "<br>";
echo "процент отвеченных вопросов: ".round(select_theme_count($theme_id)/select_theme_success_count($theme_id)*100)."%";
}
print_footer ();