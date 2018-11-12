<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");


//  A function to send an e-mail instructing the calendar
//  administrator to remove the event

function mit_sendemail_caldelete($e)
 {

  global $mit_calendar_email, $mit_eventcal_adminurl;

  // Notify the Creator...

  $mit_title = mit_gg($e, e_title);
  $mit_email = mit_g($e, e_email);

  $str = "<html><head><title>Email</title></head><body>";
  $str = $str."The Westgate Event <b>".$mit_title."</b>"." has just been deleted from the Event listings.<br>";
  $str = $str."Please remove it from the <a href='".$mit_eventcal_adminurl."'>Westgate Events Calendar</a> at your earliest convenience.<br>";
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
       "[Westgate Calendar] Event '".$mit_title."' requires deleting", // subject
       $email_text);    // body

 
 }

// ****** Main code starts here ******

mit_lock();
$e=htmlspecialchars(mit_getpost('eid'));
$z=mit_read('event.db');
$n=count($z);
for($i=0;$i<$n;$i++)
 {
  if (mit_g($z[$i],e_id)==$e)
   {
    mit_cert(mit_g($z[$i],e_auth));
    $j=mit_g($z[$i],e_image);
    if ($j!='') unlink($mit_uploc.$j);
    $curevent=$z[$i];
    unlink($mit_loc.'event.'.$e.'.db');
    $z[$i]=$z[$n-1]; unset($z[$n-1]);
    mit_write($z,'event.db');
    mit_sendemail_caldelete($curevent);
    mit_go('event.php');
    exit;
   }
 }
mit_fail();
