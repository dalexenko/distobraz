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

  print "<td><a href=\"$PHP_SELF?action=edit&stpage=$stpage&orderby=$orderby&find=$find&id=$row->theme_id\"><img src='../pics/edit.gif' alt='Редактировать' border=0></a></td>\n";
  print "<td><a href=\"$PHP_SELF?action=confirm&stpage=$stpage&orderby=$orderby&find=$find&id=$row->theme_id\"><img src='../pics/trashcan.gif' alt='Удалить' border=0></a></td>\n";
  print "<td><a href=\"upload.php?course_id=$row->course_id&theme_id=$row->theme_id\"><img src='../pics/download.gif' alt='Загрузить файл лекций' border=0></a></td>\n";
  print "<td><a href=\"course_questions.php?theme_id=$row->theme_id\"><img src='../pics/test.gif' alt='Вопросы теста' border=0></a></td>\n";
  print "</tr>\n";
?>