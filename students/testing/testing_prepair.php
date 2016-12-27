<?
require("../../includes/gl_vars.php");
require("testing_fns.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Студенческий модуль</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<body>
<?
error_reporting(E_ERROR);
session_start();
if (session_is_registered("user"))
{
$user_id=$user["login"];
prepair_test_questions($theme_id);

print "<meta http-equiv='refresh' content=\"0;URL=theme_testing.php?theme_id=$theme_id&user_id=$user_id\">";
}
?>
</body>
</html>