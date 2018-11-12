<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

function mit_allow_signup()
 {
  global $zz, $restrict_opt, $mit_ip_prefix, $mit_westgate_ip_prefix, $mit_reason;

  $result = false;
  $mit_reason = 0;   // 0=Not open, 1=MIT cert required, 2=Westgate IP required

  //Roy Shilkrot 10/29/2013
  if (strlen(mit_g($zz,e_rsvp_dt))==10)
  {
    $closedate = mit_systime(mit_convdate(mit_g($zz,e_rsvp_dt)),mit_g($zz,e_rsvp_dt));
  } else $closedate = time();  

  if (mit_g($zz,e_opendate)!='')
  {
// Ankur Chavda 5/19/2014
//    $opendate = mit_systime(mit_convdate(mit_g($zz,e_opendate)),mit_g($zz,e_opendate));
    $opendate = mit_systime(mit_convdate(mit_g($zz,e_opendate)),mit_g($zz,e_opentime));
  } else $opendate = time();

  if (time() >= $opendate && time() <= $closedate) $result = true;

  if ((mit_g($zz,e_restrict) != restrict_none) and ($result == true))
  {
     if (mit_g($zz,e_restrict)==restrict_mit)
      {
       if (!mit_checkip($mit_ip_prefix))
        {
         if (mit_username()=='') {$result = false; $mit_reason = 1;}
        }
      } else if (mit_g($zz,e_restrict)==restrict_westgate)
      {
       if (!mit_checkip($mit_westgate_ip_prefix)) {$result = false; $mit_reason = 2;}
      }
  }
  return $result;
 }

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
    $isfamily = mit_g($zz,e_isfamily) != '';
    
    for($i=0;$i<count($p);$i++)
    {
        if (!$isfamily) {
            if ($cc!='') $j=0+mit_g($p[$i],p_adult_num); else $j=0;
            if ($c!='') $j=$j+mit_g($p[$i],p_child_num);
            if (mit_g($p[$i],p_waitlist)!='') $mit_wait=$mit_wait+$j;
            else $mit_num=$mit_num+$j;
        } else
            $mit_num++;
    }
    $mit_left=0+mit_g($zz,e_spots_num);
    if ($mit_left==0) $mit_left=0-1;
    else if ($mit_left>$mit_num) $mit_left=$mit_left-$mit_num; else $mit_left=0;
    
    $mit_now=mit_convdate(date("m/d/Y"));
    $e=mit_g($zz,e_enddate); if ($e=='') $e=mit_g($zz,e_date); $e=mit_convdate($e);
    $mit_now=($e>=$mit_now);
    $mit_reason = 0;
    $mit_signup_allowed = mit_allow_signup();

/*
?><pre><?
//print_r($zz);
echo mit_g($zz,e_rsvp_dt);
?></pre><?
*/

// ============== Add new Participant entry in DB =============================

$reason = 'x';
while ($_SERVER['REQUEST_METHOD']=='POST' && $mit_now)
 // need to use a while loop so that we can use
 // "break" to break out at earliest possible moment
 {
     if ($mit_signup_allowed == false) { $reason = "Signup not open"; break;}
     
     $mit_ca=mit_g($zz,e_child_friendly);
     $mit_cb=mit_g($zz,e_adult_friendly);
     if(mit_g($zz,e_isfamily)=='') {
         $mit_a=0+mit_getpost('p_adult_num'); if ($mit_a<0 || $mit_cb=='') $mit_a=0;
         $mit_b=0+mit_getpost('p_child_num'); if ($mit_b<0 || $mit_ca=='') $mit_b=0;
     }
     if (mit_getpost('p_name')=='') { $reason = "Name not given"; break;}
     if (mit_getpost('p_apt')=='') { $reason = "Apartment not given"; break;}
     $mit_email=mit_getpost('p_email');
     if ($mit_email=='') { $reason = "Email not given"; break;}
     // Email must have One or more "a-z 0-9 - _ .",
     // followed by One @, followed by One or more "a-z 0-9 - _ ."
     if (ereg('^[-a-zA-Z0-9_\.]+@[-a-zA-Z0-9_\.]+$',$mit_email)) {} else break;
     if(mit_g($zz,e_isfamily)=='') {
         if ($mit_a<1 && $mit_b<1) { $reason = "Number of people/families not given"; break;}
     }
     $mit_d=0+mit_g($zz,e_spots_num);
     $mit_c=0;
     for($i=0;$i<count($mit_part);$i++)
     {if (mit_g($mit_part[$i],p_waitlist)!='') continue;
         if ($mit_cb!='') $mit_c=$mit_c+mit_g($mit_part[$i],p_adult_num);
         if ($mit_ca!='') $mit_c=$mit_c+mit_g($mit_part[$i],p_child_num);
     }
     if ($mit_d>$mit_c) $mit_c=$mit_d-$mit_c; else $mit_c=0;
     $mit_new_id=mit_new_id();
     $mit_new=array();
     foreach($pmap as $mit_k => $mit_v) {$mit_new[$mit_k]=mit_getpost($mit_v);}
     if ($mit_d!=0 && $mit_c<$mit_a+$mit_b)
     {
         $mit_new[p_waitlist]='Yes'; $mit_new[p_waitcount]=$mit_c;
     }
     $mit_new[p_paid]='';
     $mit_new[p_paid_dt]='';
     $mit_new[p_resp_dt]=date("m/d/Y");
     $mit_new[p_id]=$mit_new_id;
     $mit_new[p_cookie]=$mit_rand;
     $mit_new[p_adult_num]=$mit_a;
     $mit_new[p_child_num]=$mit_b;
     array_push($mit_part,$mit_new);
     mit_write($mit_part,'event.'.$mit_eid.'.db');
     mit_go('event_view.php?t='.$mit_rand.'&eid='.$mit_eid.'&pid='.$mit_new_id.'&cookie='.$mit_rand);
 }

mit_unlock();

// The only way to get in here is if the break condition happened from the
// above "if ($_SERVER['REQUEST_METHOD']=='POST')" block
if ($_SERVER['REQUEST_METHOD']=='POST')
 {
  mit_go('event_view.php?t='.$mit_rand.'&eid='.$mit_eid.'&bad='.urlencode($reason));
 }

    /*=====================================================================*/?><!DOCTYPE html>
<html lang="en">
<head>
<title>View Event</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
</head>
<body>

<script>
function mit_chk()
 {
     /*
  var mit_form=document.forms['mit_form'],ze,za=0,zb=0;
  ze=mit_form['p_email'].value;
  if (ze=='')
     {alert('Please fill out your email!'); return false;}
  if (ze.indexOf('@')<0)
     {alert('The email address is not valid! Please check if it is mistyped.'); return false;}
  if (mit_form['p_name'].value=='')
     {alert('Please fill out your name!'); return false;}
  if (mit_form['p_apt'].value=='')
     {alert('Please fill out your apartment information!'); return false;}
  <?php if (mit_g($zz,e_adult_friendly)!='') { ?>
    za=parseInt('0'+mit_form['p_adult_num'].value,10); mit_form['p_adult_num'].value=za;
  <?php } ?>
  <?php if (mit_g($zz,e_child_friendly)!='') { ?>
    zb=parseInt('0'+mit_form['p_child_num'].value,10); mit_form['p_child_num'].value=zb;
  <?php } ?>
  if (za<1 && zb<1)
   {
    alert('Please fill out the number of adults and/or children attending this event!');
    return false;
   }
  return confirm('Are you sure you wish to sign up for this event?');
      */
 }

</script>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-validate.min.js"></script>
</head>
<body>

<div class="container">

<ol class="breadcrumb">
    <li><a href="http://westgate.mit.edu">Home</a></li>
    <li><a href="event.php">Westgate Events</a></li>
    <li class="active">Event</li>
</ol>

<div class="page-header">
<h1>Welcome to Westgate Events Sign-Up Page</h1>
<p class="lead">To sign up, please fill out the form at the bottom of the page, then click <b>Sign Up</b>.</p>
</div>
<?php //=======================================================================

$mit_a=mit_getpost('bad');
$mit_b=0+mit_g($zz,e_spots_num);
if ($mit_a!='')
 {
  echo '<table cellpadding=0 cellspacing=0 width="100%" ',
  'style="margin-top:10px;margin-bottom:10px;">',
  '<tr><td style="border:2px solid black;width:80%;font:bold 16px arial;',
  'padding:20px;color:#ffffff;background-color:#3030df;text-align:center;">',
  'Please fill out all the required fields, ',
  'then click <u>Sign Up</u> again. ('.$mit_a.')</td></tr></table>';
 }
elseif ($mit_a!='' && $mit_b!=0)
 {
  $mit_a=0+$mit_a; if ($mit_a>$mit_b) $mit_a=$mit_b;
  echo '<table cellpadding=0 cellspacing=0 width="100%" ',
  'style="margin-top:10px;margin-bottom:10px;">',
  '<tr><td style="border:2px solid black;width:80%;font:bold 16px arial;',
  'padding:20px;color:#ffffff;background-color:#3030df;text-align:center;">';
  if ($mit_a<1)
   echo 'Sorry! This event is now full.';
  elseif ($mit_a==1)
   echo 'Sorry! There is currently only 1 available spot remaining.';
  else
   echo 'Sorry! There are currently only ',$mit_a,' available spots remaining.';
  echo '<br>&nbsp;</br>',mit_gg($zz,e_full_msg),'</td></tr></table>';
 }

//============= Confirmation mode ===============================//
if ($mit_pid>0)
 {
  if (mit_g($mit_part[$mit_pid-1],p_waitlist)!='')
   {
  echo '<table cellpadding=0 cellspacing=0 width="100%" ',
  'style="margin-top:10px;margin-bottom:10px;">',
  '<tr><td style="border:2px solid black;width:80%;font:bold 16px arial;',
  'padding:20px;color:#ffffff;background-color:#3030df;text-align:center;">';
  echo 'Sorry! This event does not have enough available spots.<br>',
  ' You have been added to the waiting list.<br>You will be notified',
  ' if space opens up.<br>&nbsp;</br>',mit_htmlspecialchars(mit_g($zz,e_full_msg)),
  '</td></tr></table>';
   }
  if (mit_g($mit_part[$mit_pid-1],p_waitlist)=='')
   {
  // Output success summary info
  $mit_p=$mit_part[$mit_pid-1];
  echo '<table border=0 cellspacing=0 cellpadding=3 width="100%">',
  '<tr bgcolor=#DD6600>',
  '<td style="font:bold 14px arial;">Confirmation</td></tr></table>',
  '<h3>Thank you for signing up! If you wish, you can print this summary:',
  '</h3><ul>',
  '<li><b>Your name:</b> ', mit_gg($mit_p,p_name),
  '<li><b>Your email:</b> ', mit_gg($mit_p,p_email),
  '<li><b>Your apartment:</b> ', mit_gg($mit_p,p_apt);
  $mit_a=0+mit_g($mit_p,p_adult_num);
  $mit_b=0+mit_g($mit_p,p_child_num);
  $mit_c=($mit_a)*(mit_g($zz,e_adult_fee))+($mit_b)*(mit_g($zz,e_child_fee));
  if ($mit_a>0 && mit_g($zz,e_adult_friendly)!='') echo '<li><b>Total number of adults attending:</b> ',$mit_a;
  if ($mit_b>0 && mit_g($zz,e_child_friendly)!='') echo '<li><b>Total number of children attending:</b> ',$mit_b;
  for($i=1;$i<=15;$i++)
   {
    $mit_a=mit_gg($zz,e_flextext_1+($i-1));
    $mit_b=mit_gg($mit_p,p_flextext_1+($i-1));
    if ($mit_a!='' && $mit_b!='') echo '<li><b>',$mit_a,':</b> ',$mit_b;
   }
  for($i=1;$i<=5;$i++)
   {
    $mit_a=mit_gg($zz,e_flexcb_1+($i-1));
    $mit_b=mit_g($mit_p,p_flexcb_1+($i-1));
    if ($mit_b!='') $mit_b='Yes'; else $mit_b='No';
    if ($mit_a!='') echo '<li><b>',$mit_a,':</b> ',$mit_b;
   }
  if ($mit_c>0) echo '</ul>Please pay <font color="#2020e0" style="font:bold 14px arial;">$',$mit_c,'</font> to ';
  else echo '</ul>If you have any questions, please contact ';
  $mit_a=mit_gg($zz,e_name);
  if (mit_gg($zz,e_email)!='')
     { $mit_a='<a href="mailto:'.mit_g($zz,e_email).'">'.$mit_a.'</a>'; }
  echo '<font color="#2020e0" style="font:bold 14px arial;">',$mit_a,'</font>';
  $mit_a=mit_gg($zz,e_apt);
  if ($mit_c>0 && $mit_a!='') echo ' at Westgate apartment <font color="#2020e0" style="font:bold 14px arial;">',$mit_a,'</font>';
  $mit_a=mit_gg($zz,e_pay_dt);
  if ($mit_c>0 && $mit_a!='') echo ' by <font color="#2020e0" style="font:bold 14px arial;">',$mit_a,'</font>';
  echo '<p>',mit_htmlspecialchars(mit_g($zz,e_confirm_msg)),'<hr>';
  }
 } // end of confirmation messages

/*========================================================================*/ ?>

<div class="row" style="background-color: #DD6600;">
    <div class="col-md-6">
        <h4>Event Information</h4>
    </div>
    <div class="col-md-6 text-right" style="padding: 5px 0;">
<?php
    //======  Set hidden variables etc in preparation for Participant Data Entry =========//
    if ($mit_pid==''){ ?>
        <form method="get" action="https://<? echo $mit_url_https; ?>event_people.php" name="mit_form2">
        <td style="font:bold 14px arial;" align="right">
        <input type=hidden name="t" value="<?php echo $mit_rand; ?>">
        <input type=hidden name="eid" value="<?php echo $mit_eid; ?>">
        <input type=submit value="Administrator Use Only">&nbsp;
        </td>
        </form>
        <?php } ?>
    </div>
</div>

<form class="form-horizontal" role="form" method="post" action="event_view.php" id="mit_form" onSubmit="return mit_chk();">
<input type=hidden name=eid value="<?php echo $mit_eid; ?>">
<table border=0 cellspacing=3 cellpadding=3 class="table"><tr>
<td valign="top"><table cellspacing=3 cellpadding=3 class="table">

<?php //============= Display this section no matter what ===============================//

$mit_a=mit_gg($zz,e_title); $mit_b=mit_gg($zz,e_link);
if ($mit_a=='') $mit_a=htmlspecialchars(mit_g($zz,e_link));
if ($mit_b=='') mit_td('Event Name:','<strong>'.$mit_a.'</strong>');
else mit_td('Event Name:','<a target="_blank" href="'.$mit_b.'">'.$mit_a.'</a>');

if (mit_g($zz,e_enddate)=='') $zz[e_enddate]=mit_g($zz,e_date);
if (mit_g($zz,e_date)==mit_g($zz,e_enddate))
 {
  mit_td('Date:',mit_gg($zz,e_date));
 }
else
 {
  mit_td('First Day:',mit_gg($zz,e_date));
  mit_td('Last Day:',mit_gg($zz,e_enddate));
 }

mit_td('Location:',mit_gg($zz,e_location));

if (mit_g($zz,e_child_friendly)!='') mit_td('Children allowed?','Yes');

$mit_fee=mit_gg($zz,e_adult_fee);
if ($mit_fee=='') mit_td('Fee:','None'); else mit_td('Fee:',$mit_fee);

$mit_a=mit_g($zz,e_eca); $mit_b=mit_g($zz,e_gsc);
if ($mit_a!='' && $mit_b!='')
   {$mit_row=3-$mit_row; mit_td('','This event is sponsored by the GSC Funding Board '.
   'and the Westgate Community Association');}
elseif ($mit_a!='')
   {$mit_row=3-$mit_row; mit_td('','This event is sponsored by Westgate Community Association');}
elseif ($mit_b!='')
   {$mit_row=3-$mit_row; mit_td('','This event is sponsored by the GSC Funding Board');}



mit_td('RSVP By:',mit_gg($zz,e_rsvp_dt));

if ($mit_fee!='') mit_td('Pay By:',mit_gg($zz,e_pay_dt));

mit_td('Organizer Name:',mit_gg($zz,e_name));
mit_td('Organizer Email:',mit_gg($zz,e_email));
//mit_td('Organizer Apt#:',mit_gg($zz,e_apt));

echo '</table>';

if (mit_g($zz,e_restrict)!=restrict_none) 
 {
  echo '<table border=0 cellpadding=2 cellspacing=2 style="padding-top:10px;">';
  echo '<tr bgcolor=#FF2000><td><b>Sign-up for this event is restricted to ';
  if (mit_g($zz,e_restrict)==restrict_mit) echo 'users with on-campus locations or MIT certificates.'; else 
  if (mit_g($zz,e_restrict)==restrict_westgate) echo 'computers within Westgate.';

  echo '</b></td></tr>';
 }

echo '<table border=0 cellpadding=2 cellspacing=2>';
echo '<tr><td class=col1>Number of '.(mit_g($zz,e_isfamily)==''?'people':'families').' signed up so far: <font color="#2020af"><b>',$mit_num,'</b></font></td></tr>';
//echo '<tr><td>Number of people on waiting list: ',$mit_wait,'</td></tr>'; {Commented out since it's confusing when there are people on waiting list and yet there are empty spaces...}
if ($mit_left<0)
echo '<tr><td class=col1>Number of spaces left: <font color="#2020af"><b>Unlimited</b></font></td></tr>';
else
{
echo '<tr><td class=col1><nobr>Number of spaces left: <font color="#2020af"><b>',$mit_left;
if ($mit_left==0) echo '&nbsp;(Note: you can still sign up below.<br>You will automatically be placed in the waiting list)';
echo '</b></font></nobr></td></tr>';
}

echo '</table></td><td valign="top" align="left">';
$mit_a=mit_g($zz,e_image);
if ($mit_a!='') echo '<img src="',$mit_st,urlencode($mit_a),'">';
echo '</td></tr></table>';

// $mit_a=mit_htmlspecialchars(mit_g($zz,e_desc));
$mit_a=mit_g($zz,e_desc);
// $mit_a=mit_gg($zz,e_desc);
if ($mit_a!='')
 {
  ?>
<div class="row" style="background-color: #DD6600;">
    <div class="col-md-6">
        <h4>Event Description</h4>
    </div>
</div>
<p id="event_description"><?=nl2br($mit_a)?></p>
<?php
 }

// ================= Participant Data Entry mode  ===============================//

if ($mit_pid=='' && $mit_now)
 if ($mit_signup_allowed)
 {
     ?>
<div class="row" style="background-color: #DD6600;">
<div class="col-md-12">
<h4>To sign up, please fill out the form below, then click Sign Up. ( All fields in bold are required )</h4>
</div>
</div>
<?php
//  echo '<table border=0 cellspacing=3 cellpadding=3 width="100%" ',
//    'style="padding-top:10px;">',
//     '<tr bgcolor=#DD6600><td style="font:bold 14px arial;">',
//    'To sign up, please fill out the form below, then click Sign Up.<br>',
//    '( All fields in bold are required )',
//    '</td></tr></table>',
   echo '<table border=0 cellspacing=0 cellpadding=0 class="table">',
    '<tr><td><table border=0 cellspacing=3 cellpadding=3 class="table">';
    if(mit_g($zz,e_isfamily)!='') {
        ?>
<tr><td colspan=2><div class="alert alert-info"><strong>Note:</strong> You will be signing up for your entire family</div></td></tr>
<?
    }
  mit_td('<label for="p_name" class="control-label">Your Name</label>','<input class="form-control" name="p_name" type="text" size="25" data-required>');
  mit_td('<label for="p_email" class="control-label">Your Email</label>','<input class="form-control" name="p_email" type="text" size="25" data-required>');
  mit_td('<label for="p_apt" class="control-label">Your Apartment</label>','<input class="form-control" name="p_apt" type="text" size="25" data-required>');
  if (mit_g($zz,e_adult_friendly)!='' && mit_g($zz,e_child_friendly)!='')
   {
    mit_td('<label for="p_adult_num" class="control-label"># Adults Attending</label>','<input class="form-control" name="p_adult_num" type="text" size="25" value="0">');
    mit_tdbox('<label for="p_child_num" class="control-label"># Children Attending</label>','<input class="form-control" name="p_child_num" type="text" size="25" value="0">');
   }
  else if (mit_g($zz,e_child_friendly)!='')
   {
    mit_td('<label for="p_child_num" class="control-label"># Children Attending</label>','<input class="form-control" name="p_child_num" type="text" size="25" value="0">');
   }
  else if (mit_g($zz,e_adult_friendly)!='')
   {
    mit_td('<label for="p_adult_num" class="control-label"># Adults Attending</label>','<input class="form-control" name="p_adult_num" type="text" size="25" value="0">');
   }
  for($i=1;$i<=15;$i++)
   {
    $mit_a=mit_gg($zz,e_flextext_1+($i-1)); if ($mit_a=='') continue;
    mit_tdbox($mit_a,'<input class="form-control" name="p_flextext_'.$i.'" type="text" size="25">');
   }
  for($i=1;$i<=5;$i++)
   {
    $mit_a=mit_gg($zz,e_flexcb_1+($i-1)); if ($mit_a=='') continue;
    mit_tdbox($mit_a,'<input class="form-control" name="p_flexcb_'.$i.'" type="checkbox" value="yes">');
   }
  echo '</table>';
  echo '<span style="font:16px arial;">If you have special requests or questions, please enter it here:</span><BR>';
  echo '<textarea class="form-control" name="p_comments" cols="60" rows="4" wrap="off"></textarea><br>';
  echo '</td></tr><tr><td colspan=2 align="left">',
  '<button type="submit" class="btn btn-primary">Sign Up</button>&nbsp;',
  "<button class=\"btn\" onClick=\"location.href='event.php'\">Cancel</button></td></tr></table>\n";
 } else {
  // Sign-up not allowed. Give reason:
  if ($mit_reason == 0) {
    echo "<div class=\"alert alert-info\">";
    echo "Sign-up for this event will open at ".mit_formatdate(mit_convdate(mit_g($zz,e_opendate)),mit_g($zz,e_opentime), 'g:iA \o\n l jS F');
	//Roy Shilkrot 11/29/2013
	if(mit_g($zz,e_rsvp_dt)!='') {
         echo " and close by ".mit_formatdate(mit_convdate(mit_g($zz,e_rsvp_dt)),mit_g($zz,e_rsvp_dt), 'g:iA \o\n l jS F');
	}
    echo "</div>";
  }

  if ($mit_reason == 1) echo 'To sign up using your MIT certificate, please click <a href="https://'.$mit_url.'event_view.php?eid='.$mit_eid.'&t='.$mit_rand.'">here</a>. MIT certificates can be obtained from <a target="_blank" href="http://web.mit.edu/ist/">MIT IST</a>.';

//  if ($mit_reason == 2) echo 'Sign-up has been restricted to computers within Westgate.';

 }
?>

<hr>

</form>

<script src="js/bootstrap.min.js"></script>
<script>
$('#mit_form').validate({
   onKeyup : true,
   eachValidField : function() {
        var td = $(this).closest('td');
        if(td.hasClass('alert-danger')) { td.removeClass('alert alert-danger');}
   },
   eachInvalidField : function() {
       $(this).closest('td').removeClass('success').addClass('alert alert-danger');
   }
});
</script>

</body></html>
