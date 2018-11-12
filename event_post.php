<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

$mit_admin=mit_cert($mit_eventusers);

mit_lock();

$mit_eid = htmlspecialchars(mit_getpost('eid'));
$zz=mit_read('event.db');
for($i=0;;$i++)
 {
  if ($i>=count($zz)) mit_fail();
  if (mit_g($zz[$i],e_id)==$mit_eid) {$zz=$zz[$i];break;}
 }

$mit_part=mit_read('event.'.$mit_eid.'.db');
$mit_pid=htmlspecialchars(mit_getpost('pid'));
for($i=0;;$i++)
 {
  if ($i>=count($mit_part)) {$mit_pid='';break;}
  if (mit_g($mit_part[$i],p_id)==$mit_pid)
   {
    if (mit_g($mit_part[$i],p_cookie)==mit_getpost('cookie'))
     {$mit_pid=1+$i;break;}
   }
 }

$p=$mit_part;
$c=mit_g($zz,e_child_friendly);
$cc=mit_g($zz,e_adult_friendly);
$a=0+mit_getpost('p_adult_num'); if ($a<0 || $cc=='') $a=0;
$b=0+mit_getpost('p_child_num'); if ($b<0 || $c=='') $b=0;
$mit_num=0;
$mit_wait=0;
for($i=0;$i<count($p);$i++)
 {
  if ($cc!='') $j=0+mit_g($p[$i],p_adult_num); else $j=0;
  if ($c!='') $j=$j+mit_g($p[$i],p_child_num);
  if (mit_g($p[$i],p_waitlist)!='') $mit_wait=$mit_wait+$j;
  else $mit_num=$mit_num+$j;
 }
$mit_left=0+mit_g($zz,e_spots_num);
if ($mit_left==0) $mit_left=0-1;
else if ($mit_left>$mit_num) $mit_left=$mit_left-$mit_num; else $mit_left=0;

$mit_startdate = mit_g($zz,e_date);
$mit_enddate   = mit_g($zz,e_enddate); 
$mit_starttime = mit_gg($zz,e_start);
$mit_endtime   = mit_gg($zz,e_end);
$mit_location  = mit_gg($zz,e_location);
$mit_link      = $mit_shorturl."event_view.php?eid=".$mit_eid;
$mit_title     = mit_gg($zz,e_title);
$mit_email     = mit_g($zz,e_email);

mit_unlock();

/*=========================================================================*/?>

<html>
<head>
<?php
// echo '<META HTTP-EQUIV="Refresh" CONTENT="10; URL=event_people.php?t='.$mit_rand.'&eid='.$mit_eid.'">';
?>
<title>Event Creation</title>
<link rel="stylesheet" charset="UTF-8" type="text/css" href="static/event.css">
</head>
<body>

<table border=0 cellpadding=0 cellspacing=0 style="width:100%;"><tr valign=top>
<td style="text-align:left;width:65%;">
<span style="font:bold 18px arial;">Westgate Event Creation</span>
<p><span style="font:14px arial;">The event <b><?php echo $mit_title ?></b> has been created successfully</span>
</td>
<td style="font:bold 14px arial;text-align:right;width:35%;">
<a href="event.php">Westgate Events</a>
</td></tr></table><br>

<?php

$created = false;

if ($mit_enddate=='')
 {

  $result = mit_postevent($mit_title, $mit_location, 
              mit_hyphdate($mit_startdate), mit_time24($mit_starttime),
              '', mit_time24($mit_endtime), $mit_link );

  if ($result == true) 
   {
     echo("The event has been posted to the <i>Westgate Events Calendar</i>\n");
     $created = true;
   } else {
    echo "Unable to post the event to the <i>Westgate Events Calendar</i>.\n";
   }
 } else {
  echo "Events spanning multiple days cannot be added to the <i>Westgate Event Calendar</i> automatically.\n";
 }

if ($created == false) 
 { 

  // Notify the creator to post the event...

  $str = '<html><head><title>Email</title></head><body>';
  $str = $str."The Westgate Event <b><a href='http://".$mit_url."event_view.php?eid=".$mit_eid."'>".$mit_title."</a></b> could not be added to the <a href='".$mit_eventcal_adminurl."'>Westgate Events Calendar</a> automatically.<br>";
  $str = $str."Please can you do this manually at your earliest convenience.<br>";
  $str = $str."<br>** The above email is automatically generated **<br></body></html>\n\n";
  $str = wordwrap($str,70,"\n ");
  $str = str_replace("\r\n","\n",$str);
  $str = str_replace("\n\r","\n",$str);
  $str = str_replace("\r","\n",$str);
  $str = str_replace("\n","\n ",$str);

  $email_text = $str;

  send_mail(
       'Westgate Scripting','westgate-gc@mit.edu', // sender name & email
       $mit_email,                        // recipient email
       "[Westgate Calendar] New event '".$mit_title."' requires posting", // subject
       $email_text);    // body
  
  echo "Please post the event manually. A reminder has been sent via e-mail.";

}


?>

<p>

<?php
// echo 'You will be redirected to the event page in 10 seconds or' 
  echo 'Click <a href="event_people.php?t='.$mit_rand.'&eid='.$mit_eid.'">here</a> to continue.';
?>

</body>
</html>
