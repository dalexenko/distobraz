<?PHP
require("../includes/gl_vars.php");
require("../includes/gl_fns.php");
Auth();
print_html_header('student');

error_reporting(E_ERROR);
if (!isset($course_id)==1 || !isset($theme_id)== 1)
{
print "<meta http-equiv='refresh' content=\"0;URL=index.php\">"; 
}

$file = $_GET["file"];
$path = "../courses/".$course_id."/".$theme_id."/$file";

// make sure the file exists 
if(!$fdl=@fopen($path,'r'))
{
   die("Не могу открыть файл!");
} 
else 
{
include ("$path");  
}

?>