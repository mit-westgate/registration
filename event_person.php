<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

mit_lock();

$e=htmlspecialchars(mit_getpost('eid'));
$a=mit_read('event.db');
for($i=0;;$i++)
 {
  if ($i>=count($a)) mit_fail();
  if (mit_g($a[$i],e_id)==$e) {$z=$a[$i];break;}
 }
mit_cert(mit_g($z,e_auth));

$d = htmlspecialchars(mit_getpost('pid'));
$t=mit_read('event.'.$e.'.db');
for($i=0;;$i++)
 {
  if ($i>=count($t)) mit_fail();
  if (mit_g($t[$i],p_id)==$d) {$p=$t[$i];break;}
 }

mit_unlock();

?>

<html>
<head>
<title>Participant Information</title>
<link rel="stylesheet" charset="UTF-8" type="text/css" href="static/event.css">
</head>

<?php

echo '<table border=2 cellpadding=2 cellspacing=2>';
echo '<tr bgcolor=#dd6600><td class=col1 colspan=2>Participant Information</td></tr>';
echo '<tr><td class=col1>Name:</td><td class=col2>',mit_gg($p,p_name),'&nbsp;</td></tr>';
echo '<tr><td class=col1>Email:</td><td class=col2>',mit_gg($p,p_email),'&nbsp;</td></tr>';
echo '<tr><td class=col1>Apartment:</td><td class=col2>',mit_gg($p,p_apt),'&nbsp;</td></tr>';
echo '<tr><td class=col1># Adults:</td><td class=col2>',htmlspecialchars(0+mit_g($p,p_adult_num)),'&nbsp;</td></tr>';
echo '<tr><td class=col1># Children:</td><td class=col2>',htmlspecialchars(0+mit_g($p,p_child_num)),'&nbsp;</td></tr>';
for($i=1;$i<=5;$i++)
 {
  if (mit_g($z,e_flextext_1+($i-1))!='')
  echo '<tr><td class=col1>',mit_gg($z,e_flextext_1+($i-1)),
  '&nbsp;</td><td class=col2>',mit_gg($p,p_flextext_1+($i-1)),
  '&nbsp;</td></tr>';
 }
for($i=1;$i<=5;$i++)
 {
  if (mit_g($z,e_flexcb_1+($i-1))!='')
  {
  echo '<tr><td class=col1>',mit_gg($z,e_flexcb_1+($i-1)),
  '&nbsp;</td><td class=col2>';
  if (mit_g($p,p_flexcb_1+($i-1))=='') echo 'No'; else echo 'Yes';
  echo '</td></tr>';
  }
 }
for($i=1;$i<=5;$i++)
 {
  if (mit_g($z,e_atext_1+($i-1))!='')
  echo '<tr><td class=col1>',mit_gg($z,e_atext_1+($i-1)),
  '&nbsp;</td><td class=col2>',mit_gg($p,p_atext_1+($i-1)),'&nbsp;</td></tr>';
 }
for($i=1;$i<=5;$i++)
 {
  if (mit_g($z,e_abox_1+($i-1))!='')
  {
  echo '<tr><td class=col1>',mit_gg($z,e_abox_1+($i-1)),
  '&nbsp;</td><td class=col2>';
  if (mit_g($p,p_abox_1+($i-1))=='') echo 'No'; else echo 'Yes';
  echo '&nbsp;</td></tr>';
  }
 }
echo '<tr><td class=col1>Paid</td><td class=col2>';
if (mit_g($p,p_paid)!='') echo 'Yes'; else echo 'No';
echo '</tr><tr><td class=col1>On Waiting List</td><td class=col2>';
if (mit_g($p,p_waitlist)!='') echo 'Yes'; else echo 'No';
echo '</tr><tr><td class=col1>Paid on this Date (m/d/y)</td><td class=col2>';
if (mit_g($p,p_paid)!='') echo mit_gg($p,p_paid_dt);
echo '&nbsp;</td></tr><tr><td class=col1>Sign Up Date (m/d/y)</td><td class=col2>',
mit_gg($p,p_resp_dt),'&nbsp;</td></tr>',
'<tr><td class=col1>Comments:</td><td class=col2>',
mit_gg($p,p_comments),'&nbsp;</td></tr></table>';

if (mit_g($p,p_comments)!='')
 {
  $a=mit_g($p,p_comments);
  $a=str_replace("\r\n","%0A> ",$a);
  $a=str_replace("\n\r","%0A> ",$a);
  $a=str_replace("\n","%0A> ",$a);
  $a=str_replace("\r","%0A> ",$a);
  echo 'Click <a href="mailto:'
  ,urlencode(mit_g($p,p_email))
  ,'?subject=Eastgate Event Signup'
  ,'&body='
  ,htmlspecialchars(mit_g($p,p_email)." wrote:%0A> ".$a."%0A%0A")
  ,'">HERE</a> if you wish to reply to this person.';
 }
