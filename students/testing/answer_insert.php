<?
require("../../includes/gl_vars.php");
require("testing_fns.php");
print_header ();
error_reporting(E_ERROR);
session_start();
if (session_is_registered("user"))
{
$user_id=$user["login"];       
answer_insert();
print "<meta http-equiv='refresh' content=\"0;URL=theme_testing.php?theme_id=$theme_id&user_id=$user_id&nextn=$nextn\">";
}
print_footer ();