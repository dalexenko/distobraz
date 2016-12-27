<?
echo "<meta http-equiv=\"refresh\" content=\"10;URL=?theme_id=$theme_id&i=1\">";
echo "<FRAMESET ROWS=\"7%, *\" border=0>";
echo "<FRAME SRC=\"top.php\" NAME=\"top\" scrolling=no>";
if (!$i)
{
echo "<FRAME SRC=\"testing_prepair.php?theme_id=$theme_id\" NAME=\"bottom\">";
}
else
{
echo "<FRAME SRC=\"theme_testing.php?theme_id=$theme_id&i=$i\" NAME=\"bottom\">";
}
echo "</FRAMESET>";
?>