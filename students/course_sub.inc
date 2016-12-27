<?php
  global $PHP_SELF;
  global $orderby;
  global $find;
  $sel_b = '<font color=red><b>';
  $sel_e = '</b></font>';
  print "<tr>\n";
  print "<td>" . highlight($row->user_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->course_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td><a href=\"course_themes.php?course_id=$row->course_id\">Темы курса</a></td>\n";
  print "</tr>\n";
?>