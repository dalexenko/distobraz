<?php
  global $PHP_SELF;
  global $orderby;
  global $find;
  $sel_b = '<font color=red><b>';
  $sel_e = '</b></font>';
  print "<tr>\n";
  print "<td>" . highlight($row->course_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->course_name,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->user_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->control_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->success_count,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";

  print "<td><a href=\"$PHP_SELF?action=view&stpage=$stpage&orderby=$orderby&find=$find&id=$row->course_id\"><img src='../pics/view.gif' alt='Просмотр' border=0></a></td>\n";
  print "<td><a href=\"$PHP_SELF?action=edit&stpage=$stpage&orderby=$orderby&find=$find&id=$row->course_id\"><img src='../pics/edit.gif' alt='Редактировать' border=0></a></td>\n";
  print "<td><a href=\"$PHP_SELF?action=confirm&stpage=$stpage&orderby=$orderby&find=$find&id=$row->course_id\"><img src='../pics/trashcan.gif' alt='Удалить' border=0></a></td>\n";
  print "</tr>\n";
?>