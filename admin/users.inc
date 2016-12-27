<?php
  global $PHP_SELF;
  global $orderby;
  global $find;
  $sel_b = '<font color=red><b>';
  $sel_e = '</b></font>';
  print "<tr>\n";
  print "<td>" . highlight($row->user_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->usercat_id,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->username,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->usermediumname,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->userlastname,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->user_email,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";
  print "<td>" . highlight($row->passwd,true,true,$find,$sel_b,$sel_e,'_blank') . "</td>\n";

  print "<td><a href=\"$PHP_SELF?action=view&stpage=$stpage&orderby=$orderby&find=$find&id=$row->user_id\"><img src='../pics/view.gif' alt='Просмотр' border=0></a></td>\n";
  print "<td><a href=\"$PHP_SELF?action=edit&stpage=$stpage&orderby=$orderby&find=$find&id=$row->user_id\"><img src='../pics/edit.gif' alt='Редактировать' border=0></a></td>\n";
  print "<td><a href=\"$PHP_SELF?action=confirm&stpage=$stpage&orderby=$orderby&find=$find&id=$row->user_id\"><img src='../pics/trashcan.gif' alt='Удалить' border=0></a></td>\n";
  print "</tr>\n";
?>