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

print "<p><br><p><center><font size=2 face=Tahoma><b>Закачка должна начаться через несколько секунд.</b></font></center>";
Print "<center>Если закачка не начнется автоматически, нажмите <a href=\"$path\">здесь.</a></center>";


$filename = "./uploads/$file.0";
$newfile = fopen($filename,"r");
$content = fread($newfile, filesize($filename));
fclose($newfile);


$fileinfo = explode ("|",$content);
#print "Fileinfo 0 is $fileinfo[0]<br>";
$fileinfo[0] ++;



$content = implode("|", $fileinfo);



$newfile = fopen($filename,"w");
fwrite($newfile, $content);
fclose($newfile);


?>
<META HTTP-EQUIV=REFRESH CONTENT="0; URL=<? echo $path; ?>">
<?
print_html_footer();
?>