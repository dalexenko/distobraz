<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Студенческий модуль</title>
<link rel="stylesheet" type="text/css" href="../style.css">
        <script type="text/javascript" language="JavaScript">
        function time() {
                var seconds = "yes";
                var d = new Date();
                var h = d.getHours();
                var m = d.getMinutes();
                var s = d.getSeconds();
                if (m < 10) m = "0" + m;
                if (s < 10) s = "0" + s;
                var time = h + ':' + m;
                if (seconds == 'yes') {
                        var time = time + ':' + s;
                        }
                document.getElementById("clock").innerHTML = time;
                setTimeout("time()", 1000);
                }
        </script>
</head>
<body onload="time();">
<span id="clock"></span>
<?
function setmin($insec)
{

$hours=floor($insec/3600);

if ($hours == $insec/3600)
{
$minutes=0;
$seconds=0;
}
else
{
$minutes= floor(($insec-$hours*3600)/60);
if ($minutes == ($insec-$hours*3600)/60)
{
$seconds=0;
}
else
{
$seconds = $insec-$hours*3600-$minutes*60;
}
}
$res=array ('hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds);

return $res;
}
$row=setmin(5400);
if($row['hours'] == 0){$hours=" ";} else {$hours=$row['hours']." час(ов) ";}
if($row['minutes'] == 0){$minutes=" ";} else {$minutes=$row['minutes']." минут(ы) ";}
if($row['seconds'] == 0){$seconds=" ";} else {$seconds=$row['seconds']." секунд(ы) ";}

$testlong=$hours.$minutes.$seconds;
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Продолжительность теста - ".$testlong."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Начало теста - ".date("H:i:s");
?>
</body>
</html>
