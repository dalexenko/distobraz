<?PHP
require("../includes/gl_vars.php");
require("../includes/gl_fns.php");
Auth();
print_html_header('teach');

error_reporting(E_ERROR);
if (!isset($course_id)==1 || !isset($theme_id)== 1)
{
print "<meta http-equiv='refresh' content=\"0;URL=index.php\">"; 
}
$site_name = $_SERVER['HTTP_HOST'];
$url_dir = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$url_this =  "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$upload_dir = "../courses/".$course_id."/".$theme_id."/";
$upload_url = "http://localhost/distobraz/courses/".$course_id."/".$theme_id."/";
$message ="";

//create upload_files directory if not exist
//If it does not work, create on your own and change permission.
if (!is_dir($upload_dir)) {
	die ("upload_files directory doesn't exist");
}

if ($_FILES['userfile']) {
	$message = do_upload($upload_dir, $upload_url);
}
else {
$message = "Выберите файл для закачки";
}

print $message;

function do_upload($upload_dir, $upload_url) {

	$temp_name = $_FILES['userfile']['tmp_name'];
	$file_name = $_FILES['userfile']['name']; 
	$file_type = $_FILES['userfile']['type']; 
	$file_size = $_FILES['userfile']['size']; 
	$result    = $_FILES['userfile']['error'];
	$file_url  = $upload_url.$file_name;
	$file_path = $upload_dir.$file_name;

	//File Name Check
    if ( $file_name =="") { 
    	$message = "Недопустимое имя файла";
    	return $message;
    }
    //File Size Check
    else if ( $file_size > 500000) {
        $message = "Размер файла более 500K.";
        return $message;
    }
    //File Type Check
    else if ( $file_type == "text/plain" ) {
        $message = "Извините, Вы не можете выгрузить файл" ;
        return $message;
    }

    $result  =  move_uploaded_file($temp_name, $file_path);
    $message = ($result)?"Адрес файла:<a href=$file_url>$file_url</a>" :
    	      "Ошибка выгрузки файла.";

    return $message;
}
?>
<form name="upload" id="upload" ENCTYPE="multipart/form-data" method="post">
  Выгрузка файла<input type="file" id="userfile" name="userfile">
  <input type="submit" name="выгрузить" value="Upload">
</form>  
<?
print_html_footer();
?>