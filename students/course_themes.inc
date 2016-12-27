<?php
  global $PHP_SELF;
  global $orderby;
  global $find;
  $sel_b = '<font color=red><b>';
  $sel_e = '</b></font>';
  print "<tr>\n";
  print "<td>" . highlight($row->theme_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->course_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->theme_name,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->theme_query,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->success_count,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";

  print "<td><a href=\"download.php?course_id=$row->course_id&theme_id=$row->theme_id&file=$row->theme_id.zip\"><img src='../pics/download.gif' alt='Скачать материал' border=0></a></td>\n";
  print "<td><a href=\"view.php?course_id=$row->course_id&theme_id=$row->theme_id&file=$row->theme_id.html\"><img src='../pics/view.gif' alt='Просмотр лекции' border=0></a></td>\n";
  print "<td><a href=\"testing\?theme_id=$row->theme_id\"><img src='../pics/test.gif' alt='Запустить тест' border=0></a></td>\n";
  print "</tr>\n";
?>