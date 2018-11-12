<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

$mit_admin=mit_cert($mit_eventusers);

mit_lock();

$mit_copy=mit_getpost('copy');

$mit_old=mit_read('event.db');

$mit_eid = htmlspecialchars(mit_getpost('eid'));
$mit_ev = -1;
for($i=0;$i<count($mit_old);$i++)
 {
  if (mit_g($mit_old[$i],e_id)==$mit_eid) {$mit_ev=$i;break;}
 }
if ($mit_ev<0) $mit_eid='';

function mit_p($f)
 {
  global $mit_old,$mit_ev;
  if ($mit_ev<0) return;
  if (!array_key_exists($f,$mit_old[$mit_ev])) return;
  echo htmlspecialchars($mit_old[$mit_ev][$f]);
 }

function mit_c($f)
 {
  global $mit_old,$mit_ev;
  if ($mit_ev<0) return '';
  if (!array_key_exists($f,$mit_old[$mit_ev])) return '';
  return ''.$mit_old[$mit_ev][$f];
 }

function mit_getsuf($z)
 {
  if (strlen($z)>=5)
   {
    if (strcasecmp(substr($z,strlen($z)-4,4),'.png')==0) return '.png';
    if (strcasecmp(substr($z,strlen($z)-4,4),'.gif')==0) return '.gif';
    if (strcasecmp(substr($z,strlen($z)-4,4),'.jpg')==0) return '.jpg';
    if (strcasecmp(substr($z,strlen($z)-5,5),'.jpeg')==0) return '.jpg';
   }
  return '';
 }

function date_to_mmddyyyy($s) {
  $d = date_parse($s);
  return "".$d["month"]."/".$d["day"]."/".$d["year"];
}

function date_to_yyyymmdd($s) {
  $d = date_parse($s);
  return $d["year"]."-".$d["month"]."-".$d["day"];
}

function mit_sendemail_calchange($mit_old, $mit_new)
 {

  global $mit_calendar_email, $mit_eventcal_adminurl, $mit_url;

  // Notify the Calendar Administrator that an event has changed...


  $mit_title = mit_gg($mit_old, e_title);

  $str = '<html><head><title>Email</title></head><body>';
  $str = $str."The Westgate Event <b><a href='http://".$mit_url."event_view.php?eid=".mit_g($mit_new,e_id)."'>".$mit_title."</a></b> has been altered from the form posted on the <a href='".$mit_eventcal_adminurl."'>Westgate Events Calendar</a>.<br>";
  $str = $str."Please update the calendar at your earliest convenience.<br>";
  $str = $str."<br>** The above email is automatically generated **<br></body></html>\n\n";
  $str = wordwrap($str,70,"\n ");
  $str = str_replace("\r\n","\n",$str);
  $str = str_replace("\n\r","\n",$str);
  $str = str_replace("\r","\n",$str);
  $str = str_replace("\n","\n ",$str);

  $str = wordwrap($str,70,"\n ");
  $str = str_replace("\r\n","\n",$str);
  $str = str_replace("\n\r","\n",$str);
  $str = str_replace("\r","\n",$str);
  $str = str_replace("\n","\n ",$str);

  $email_text = $str;

  send_mail(
       'Westgate Scripting','westgate-gc@mit.edu', // sender name & email
       $mit_calendar_email,                        // recipient email
       "[Westgate Calendar] Event '".$mit_title."' requires modifying", // subject
       $email_text);    // body
 
 }

function my_save_event($id)
 {
  global $emap,$mit_uploc,$mit_old,$mit_copy,$mit_admin;
  if ($id!='' && $mit_copy=='') $myid=$id; else $myid=mit_new_id();
  $mit_new=array();
  foreach($emap as $key => $value) { $mit_new[$key] = mit_getpost($value);}
  
  $dates_to_conv = array(e_date,e_enddate,e_opendate,e_rsvp_dt);
  foreach($dates_to_conv as $dtc) { if($mit_new[$dtc]!='') { $mit_new[$dtc] = date_to_mmddyyyy($mit_new[$dtc]); } }

  $mit_new[e_image]='';
  if (array_key_exists('e_image',$_FILES) &&
   filesize($_FILES['e_image']['tmp_name'])>0)
   {
    $mit_part=trim($_FILES['e_image']['name']);
    $suffix=mit_getsuf($mit_part);
    if ($suffix!='')
     {
      $mit_odo=mit_new_id();
      $suffix='event.'.$myid.'.'.$mit_odo.$suffix; $mit_new[e_image]=$suffix;
      $suffix=$mit_uploc.$suffix;
      move_uploaded_file($_FILES['e_image']['tmp_name'],$suffix);
      clearstatcache();
     }
   }
  $mit_new[e_id]=$myid;
  $mit_new[e_adult_fee]=0+mit_g($mit_new,e_adult_fee);
  $mit_new[e_child_fee]=0+mit_g($mit_new,e_child_fee);
  if ($id=='')
   {
    // add mode
    $mit_new[e_auth]=$mit_admin;
    $mit_new[e_shorturl]=file_get_contents('http://westgate.mit.edu/PHP-URL-Shortener/shorten.php?longurl=' . urlencode('https://' . $_SERVER['HTTP_HOST']  . '/registration/event_view.php?eid='.$myid));
    array_push($mit_old, $mit_new);
    mit_write($mit_old,'event.db');
   }
  else
   {
    // edit or copy mode
    for($i=0;$i<count($mit_old);$i++)
     {
      if ($id==mit_g($mit_old[$i],e_id))
       {
        $j=mit_g($mit_old[$i],e_image);
        if ($mit_copy!='')
         {
          if (mit_g($mit_new,e_image)=='' && $j!='')
           {
            $jj=mit_getsuf($j); if ($jj=='') $jj='.jpg';
            $jj='event.'.$myid.'.'.mit_new_id().$jj;
            copy($mit_uploc.$j,$mit_uploc.$jj);
            $mit_new[e_image]=$jj;
           }
          array_push($mit_old, $mit_new);
         }
        else
         {
          // Look to see if any of the elements on the google calendar
          // have been changed
          if ((mit_g($mit_old[$i],e_title) != mit_g($mit_new,e_title)) or 
              (mit_g($mit_old[$i],e_date) != mit_g($mit_new,e_date)) or
              (mit_g($mit_old[$i],e_enddate) != mit_g($mit_new,e_enddate)) or
              (mit_g($mit_old[$i],e_start) != mit_g($mit_new,e_start)) or
              (mit_g($mit_old[$i],e_end) != mit_g($mit_new,e_end)) or
              (mit_g($mit_old[$i],e_location) != mit_g($mit_new,e_location)))
           {
            // Send an e-mail to the calendar administrator
            mit_sendemail_calchange($mit_old[$i], $mit_new);
           }

          if (mit_g($mit_new,e_image)=='') $mit_new[e_image]=$j;
          else if ($j!='') unlink($mit_uploc.$j);
          $mit_old[$i]=$mit_new;
         }
        mit_write($mit_old,'event.db'); break;
       }
     }
   }
  return $myid;
 }

if ($_SERVER['REQUEST_METHOD']=='POST')
 {
  if (mit_getpost('e_date')!=''
  && mit_getpost('e_title')!=''
  && mit_getpost('e_location')!=''
  && mit_getpost('e_name')!=''
  && mit_getpost('e_email')!='') 
   { 
   $mit_eid=my_save_event($mit_eid);
   if ($mit_ev<0)
    {
//     mit_gos('event_post.php?t='.$mit_rand.'&eid='.$mit_eid);
//    } else {
     mit_gos('event_people.php?t='.$mit_rand.'&eid='.$mit_eid);
    }
   } else
	  mit_gos('event_create.php?t='.$mit_rand.'&bad=x&eid='.$mit_eid);
 }

mit_unlock();

/*=========================================================================*/?>

<html>

<head>
<title>
<?php if ($mit_ev<0) echo 'Create a New Event'; elseif ($mit_copy!='') echo 'Copy Event'; else echo 'Edit Event'; ?>
</title>
<!--link rel="stylesheet" charset="UTF-8" type="text/css" href="static/event.css"-->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
</head>

<script>
/*
function mit_chk()
 {
     
  var mit_form=document.forms['mit_form'],za,zb;
  if (mit_form['e_auth'].value=='')
     {alert('Please list at least 1 name in the Authorized Event Manager text box!'); return false;}
  if (mit_form['e_date'].value=='')
     {alert('Please fill out the event date!'); return false;}
  if (mit_form['e_title'].value=='')
     {alert('Please fill out the event title!'); return false;}
  if (mit_form['e_location'].value=='')
     {alert('Please fill out the event location!'); return false;}
  if (mit_form['e_name'].value=='')
     {alert('Please fill out your name!'); return false;}
  if (mit_form['e_email'].value=='')
     {alert('Please fill out your email!'); return false;}
  return confirm('Are you sure you wish to save this event?');
 }
*/
</script>
</head>

<body>

<div class="container">
<?php
?>

<ol class="breadcrumb">
<li><a href="http://westgate.mit.edu">Home</a></li>
<li><a href="event.php">Westgate Events</a></li>
<li class="active">Create Event</li>
</ol>

<div class="page-header">
<h1>
<?php if ($mit_ev<0) echo 'Create a New Event'; elseif ($mit_copy!='') echo 'Copy Event'; else echo 'Edit Event'; ?></td>
</h1>
<p class="lead">Please fill out the form, then click <b>Save</b> or <strong>Cancel</strong>.</p>
</div>

<?php /*=====================================================================*/
if (mit_getpost('bad')=='x') echo '<table cellpadding=0 cellspacing=0 ',
  'width="80%" style="margin-bottom:10px;">',
  '<tr><td style="border:2px solid black;width:80%;font:bold 16px arial;',
  'padding:20px;color:#ffffff;background-color:#3030df;text-align:center;">',
  'Please fill out all the required fields, ',
  'then click <u>Sign Up</u> again.</td></tr></table>';
/*========================================================================*/ ?>

<form name="mit_form" method="post" action="event_create.php" enctype="multipart/form-data" onSubmit="return mit_chk();" role="form" class="form-horizontal">

<p class="well well-sm">
  Event Information (All fields in <b> bold </b> are required).
</p>

<?php
if($_GET['bad']) {
?>
<div class="alert alert-danger">Oops, something went wrong...</div>
<?php
}
?>

<div class="form-group"><div class="col-xs-3">
  <b>Authorized Event Manager:</b>
</div><div class="col-xs-6">
  <input name="e_auth" type="text" size=70 class="form-control" value="<?php
    if (strcasecmp(mit_c(e_auth),'')==0) echo $mit_admin;
    else echo htmlspecialchars(str_replace('.','',str_replace(' ','',mit_c(e_auth))));
  ?>">
  <br>
  <nobr>You can use "," to list multiple names. For example: adam,ben,john</nobr>
  <br>
  Note: each name must be a valid username on @mit.edu
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr><b>First Day of Event (mm/dd/yyyy)</b></nobr>
</div><div class="col-xs-6">
  <input name="e_date" type="text" value="<?=date_to_mmddyyyy(mit_c(e_date)) ?>" size=12>&nbsp;&nbsp;&nbsp;From:&nbsp;
  <Select Name="e_start" style="text-align:right;">
  <option value="">Not Specified&nbsp; <?php $zz=mit_c(e_start); ?>
  <option value="600" <?php if ($zz=='600') echo 'SELECTED'; ?>>6:00 AM
  <option value="630" <?php if ($zz=='630') echo 'SELECTED'; ?>>6:30 AM
  <option value="700" <?php if ($zz=='700') echo 'SELECTED'; ?>>7:00 AM
  <option value="730" <?php if ($zz=='730') echo 'SELECTED'; ?>>7:30 AM
  <option value="800" <?php if ($zz=='800') echo 'SELECTED'; ?>>8:00 AM
  <option value="830" <?php if ($zz=='830') echo 'SELECTED'; ?>>8:30 AM
  <option value="900" <?php if ($zz=='900') echo 'SELECTED'; ?>>9:00 AM
  <option value="930" <?php if ($zz=='930') echo 'SELECTED'; ?>>9:30 AM
  <option value="1000" <?php if ($zz=='1000') echo 'SELECTED'; ?>>10:00 AM
  <option value="1030" <?php if ($zz=='1030') echo 'SELECTED'; ?>>10:30 AM
  <option value="1100" <?php if ($zz=='1100') echo 'SELECTED'; ?>>11:00 AM
  <option value="1130" <?php if ($zz=='1130') echo 'SELECTED'; ?>>11:30 AM
  <option value="1200" <?php if ($zz=='1200') echo 'SELECTED'; ?>>Noon
  <option value="1230" <?php if ($zz=='1230') echo 'SELECTED'; ?>>12:30 PM
  <option value="1300" <?php if ($zz=='1300') echo 'SELECTED'; ?>>1:00 PM
  <option value="1330" <?php if ($zz=='1330') echo 'SELECTED'; ?>>1:30 PM
  <option value="1400" <?php if ($zz=='1400') echo 'SELECTED'; ?>>2:00 PM
  <option value="1430" <?php if ($zz=='1430') echo 'SELECTED'; ?>>2:30 PM
  <option value="1500" <?php if ($zz=='1500') echo 'SELECTED'; ?>>3:00 PM
  <option value="1530" <?php if ($zz=='1530') echo 'SELECTED'; ?>>3:30 PM
  <option value="1600" <?php if ($zz=='1600') echo 'SELECTED'; ?>>4:00 PM
  <option value="1630" <?php if ($zz=='1630') echo 'SELECTED'; ?>>4:30 PM
  <option value="1700" <?php if ($zz=='1700') echo 'SELECTED'; ?>>5:00 PM
  <option value="1730" <?php if ($zz=='1730') echo 'SELECTED'; ?>>5:30 PM
  <option value="1800" <?php if ($zz=='1800') echo 'SELECTED'; ?>>6:00 PM
  <option value="1830" <?php if ($zz=='1830') echo 'SELECTED'; ?>>6:30 PM
  <option value="1900" <?php if ($zz=='1900') echo 'SELECTED'; ?>>7:00 PM
  <option value="1930" <?php if ($zz=='1930') echo 'SELECTED'; ?>>7:30 PM
  <option value="2000" <?php if ($zz=='2000') echo 'SELECTED'; ?>>8:00 PM
  <option value="2030" <?php if ($zz=='2030') echo 'SELECTED'; ?>>8:30 PM
  <option value="2100" <?php if ($zz=='2100') echo 'SELECTED'; ?>>9:00 PM
  <option value="2130" <?php if ($zz=='2130') echo 'SELECTED'; ?>>9:30 PM
  <option value="2200" <?php if ($zz=='2200') echo 'SELECTED'; ?>>10:00 PM
  <option value="2230" <?php if ($zz=='2230') echo 'SELECTED'; ?>>10:30 PM
  <option value="2300" <?php if ($zz=='2300') echo 'SELECTED'; ?>>11:00 PM
  <option value="2330" <?php if ($zz=='2330') echo 'SELECTED'; ?>>11:30 PM
  </Select>
  &nbsp;To:&nbsp;
  <Select Name="e_end" style="text-align:right;">
  <option value="">Not Specified&nbsp; <?php $zz=mit_c(e_end); ?>
  <option value="600" <?php if ($zz=='600') echo 'SELECTED'; ?>>6:00 AM
  <option value="630" <?php if ($zz=='630') echo 'SELECTED'; ?>>6:30 AM
  <option value="700" <?php if ($zz=='700') echo 'SELECTED'; ?>>7:00 AM
  <option value="730" <?php if ($zz=='730') echo 'SELECTED'; ?>>7:30 AM
  <option value="800" <?php if ($zz=='800') echo 'SELECTED'; ?>>8:00 AM
  <option value="830" <?php if ($zz=='830') echo 'SELECTED'; ?>>8:30 AM
  <option value="900" <?php if ($zz=='900') echo 'SELECTED'; ?>>9:00 AM
  <option value="930" <?php if ($zz=='930') echo 'SELECTED'; ?>>9:30 AM
  <option value="1000" <?php if ($zz=='1000') echo 'SELECTED'; ?>>10:00 AM
  <option value="1030" <?php if ($zz=='1030') echo 'SELECTED'; ?>>10:30 AM
  <option value="1100" <?php if ($zz=='1100') echo 'SELECTED'; ?>>11:00 AM
  <option value="1130" <?php if ($zz=='1130') echo 'SELECTED'; ?>>11:30 AM
  <option value="1200" <?php if ($zz=='1200') echo 'SELECTED'; ?>>Noon
  <option value="1230" <?php if ($zz=='1230') echo 'SELECTED'; ?>>12:30 PM
  <option value="1300" <?php if ($zz=='1300') echo 'SELECTED'; ?>>1:00 PM
  <option value="1330" <?php if ($zz=='1330') echo 'SELECTED'; ?>>1:30 PM
  <option value="1400" <?php if ($zz=='1400') echo 'SELECTED'; ?>>2:00 PM
  <option value="1430" <?php if ($zz=='1430') echo 'SELECTED'; ?>>2:30 PM
  <option value="1500" <?php if ($zz=='1500') echo 'SELECTED'; ?>>3:00 PM
  <option value="1530" <?php if ($zz=='1530') echo 'SELECTED'; ?>>3:30 PM
  <option value="1600" <?php if ($zz=='1600') echo 'SELECTED'; ?>>4:00 PM
  <option value="1630" <?php if ($zz=='1630') echo 'SELECTED'; ?>>4:30 PM
  <option value="1700" <?php if ($zz=='1700') echo 'SELECTED'; ?>>5:00 PM
  <option value="1730" <?php if ($zz=='1730') echo 'SELECTED'; ?>>5:30 PM
  <option value="1800" <?php if ($zz=='1800') echo 'SELECTED'; ?>>6:00 PM
  <option value="1830" <?php if ($zz=='1830') echo 'SELECTED'; ?>>6:30 PM
  <option value="1900" <?php if ($zz=='1900') echo 'SELECTED'; ?>>7:00 PM
  <option value="1930" <?php if ($zz=='1930') echo 'SELECTED'; ?>>7:30 PM
  <option value="2000" <?php if ($zz=='2000') echo 'SELECTED'; ?>>8:00 PM
  <option value="2030" <?php if ($zz=='2030') echo 'SELECTED'; ?>>8:30 PM
  <option value="2100" <?php if ($zz=='2100') echo 'SELECTED'; ?>>9:00 PM
  <option value="2130" <?php if ($zz=='2130') echo 'SELECTED'; ?>>9:30 PM
  <option value="2200" <?php if ($zz=='2200') echo 'SELECTED'; ?>>10:00 PM
  <option value="2230" <?php if ($zz=='2230') echo 'SELECTED'; ?>>10:30 PM
  <option value="2300" <?php if ($zz=='2300') echo 'SELECTED'; ?>>11:00 PM
  <option value="2330" <?php if ($zz=='2330') echo 'SELECTED'; ?>>11:30 PM
  </Select>
</div></div>

<div class="form-group"><div class="col-xs-3">
  Last Day of Event (mm/dd/yyyy)
</div><div class="col-xs-6">
  <input name="e_enddate" type="text" value="<?php
    if (mit_c(e_enddate)!=mit_c(e_date)) date_to_mmddyyyy(mit_c(e_enddate));
  ?>" size=12>
  <br><b>(fill in this field if this event spans more than 1 day)</b>
</div></div>

<div class="form-group"><div class="col-xs-3">
  <b>Event Title</b>
</div><div class="col-xs-6">
  <input class="form-control" name="e_title" type="text" size=70 value="<?php mit_p(e_title);?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  <b>Location</b>
</div><div class="col-xs-6">
  <input class="form-control" name="e_location" type="text" size=70 value="<?php mit_p(e_location);?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  <b>Organizer Name</b>
</div><div class="col-xs-6">
  <input class="form-control" name="e_name"  type="text" size=40 value="<?php mit_p(e_name);?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  <b>Organizer E-mail</b>
</div><div class="col-xs-6">
  <input class="form-control" name="e_email"  type="text" size=40 value="<?php mit_p(e_email);?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>Organizer Apartment</nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_apt" type="text" size=5 value="<?php mit_p(e_apt);?>">
  <br>
  (Required, if you want participants to give the cheque to your apartment)
</div></div>

<div class="form-group"><div class="col-xs-3">
  Web Link
</div><div class="col-xs-6">
  <input class="form-control" name="e_link" type="text" size=40 value="<?php mit_p(e_link);?>">
</div></div>

<?php 
if (mit_c(e_opentime)=='') $zz = $mit_opensignuptime; else $zz = 0+mit_c(e_opentime);
?>

<div class="form-group"><div class="col-xs-3">
  Open Sign-up on (mm/dd/yyyy)
</div><div class="col-xs-3">
  <input class="form-control" name="e_opendate" type="text" value="<?=date_to_mmddyyyy(mit_c(e_opendate)) ?>" size=12> <br>
   (fill in this field to delay opening of event until <?php echo mit_formatdate(mit_convdate(date('m/d/Y')),$zz,"g:i A") ?> on the chosen date)
</div></div>

<input name="e_opentime" type="hidden" value="<?php echo $zz; ?>">

<div class="form-group"><div class="col-xs-3">
  RSVP By (mm/dd/yyyy)
</div><div class="col-xs-3">
  <input class="form-control" name="e_rsvp_dt" type="text" size=10 value="<?=date_to_mmddyyyy(mit_c(e_rsvp_dt))?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  Pay By (mm/dd/yyyy)
</div><div class="col-xs-3">
  <input class="form-control" name="e_pay_dt"  type="text" size=10 value="<?=date_to_mmddyyyy(mit_c(e_pay_dt))?>">
</div></div>

<div class="form-group"><div class="col-xs-3">
  Fee per Adult (in whole dollars)
</div><div class="col-xs-6">
  <input class="form-control" name="e_adult_fee" type="text" size=10 value="<?php mit_p(e_adult_fee);?>">&nbsp;
  (If it's free for adults, leave this field blank)
</div></div>

<div class="form-group"><div class="col-xs-3">
  Fee per Child (in whole dollars)
</div><div class="col-xs-6">
  <input class="form-control" name="e_child_fee" type="text" size=10 value="<?php mit_p(e_child_fee); ?>">&nbsp;
  (If it's free for children, leave this field blank)
</div></div>

<div class="form-group"><div class="col-xs-3">
  Fee varies
</div><div class="col-xs-6">
  <input class="form-control" name="e_fee_varies" type="checkbox" size=10 value="yes" <?=(mit_c(e_fee_varies)!='')?'CHECKED':'' ?>>&nbsp;In case the fee is more complicated. Please explain the fees in the description.
</div></div>

<div class="form-group"><div class="col-xs-3">
   <nobr>Is registration per family?</nobr>
   </div><div class="col-xs-6">
   <input class="form-control" name="e_isfamily" type="checkbox" value="yes" <?php if (mit_c(e_isfamily)!='') echo 'CHECKED';?>>
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>Adults Allowed?</nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_adult_friendly" type="checkbox" value="yes" <?php if (mit_c(e_adult_friendly)!='') echo 'CHECKED';?>>
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>Children Allowed?</nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_child_friendly" type="checkbox" value="yes" <?php if (mit_c(e_child_friendly)!='') echo 'CHECKED';?>>
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>GSC Sponsored?<nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_gsc" type="checkbox" value="yes" <?php if (mit_c(e_gsc)!='') echo 'CHECKED';?>>
</div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>WCA Funded?<nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_eca" type="checkbox" value="yes" <?php if (mit_c(e_eca)!='') echo 'CHECKED';?>>
</div></div>

<div class="form-group"><div class="col-xs-3">
  Restrict Sign-Up?
</div><div class="col-xs-6">
  <Select Name="e_restrict" style="text-align:left;">
  <?php
  $zz = 0+mit_c(e_restrict);

  foreach($restrict_opt as $key => $value) 
   {
    echo '<option value="',$key,'"';
    if ($key == $zz) echo ' SELECTED';
    echo '>', $value;
   }
  ?>
  </Select>
   </div></div>

<div class="form-group"><div class="col-xs-3">
  <nobr>Do <b>NOT</b> show event in listings?<nobr>
</div><div class="col-xs-6">
  <input class="form-control" name="e_hidden" type="checkbox" value="yes" <?php if (mit_c(e_hidden)!='') echo 'CHECKED';?>>
</div></div>

<?php $zz = mit_c(e_image); ?>
<div class="form-group"><div class="col-xs-9">
  <?php if ($zz!='') { echo '<img src="',$mit_st,urlencode($zz),'"><br>'; } ?>
  To upload a <?php if ($zz!='') echo ' <b>different</b> '; ?>
  picture for this event, please click the button below:<br>
  <input name="MAX_FILE_SIZE" type="hidden" value="1048576">
  <input class="form-control" name="e_image" type="file" size=40><br>
</div></div>
   
<?php /*======================================================================================*/ ?>
<?php /*======================================================================================*/ ?>

<div class="form-group"><div class="col-xs-9">
  Description: (please specify event details, disclaimers, etc.)<br/>
  <textarea class="form-control" name="e_desc" rows=12 cols=85 wrap=off><?php mit_p(e_desc); ?></textarea>
</div></div>

<?php /*======================================================================================*/ ?>
<?php /*======================================================================================*/ ?>

<table border=0 cellspacing=0 cellpadding=2 style="margin-top:20px;" width="80%">
<tr class="cell4">
  <td>
  <span style="font:bold 16px arial;">Additional Questions</span><br>
  <nobr>(Eg: "I can drive this many people", "I can bring this dish")</nobr>
  </td><td><span style="font:bold 16px arial;">
  &nbsp;&nbsp;&nbsp;Additional "Yes and No" Questions</span><br>
  <nobr>&nbsp;&nbsp;&nbsp;(Eg: "I am a vegetarian", "I can volunteer at 6:00PM")</nobr>
  </td>
</tr>
<td valign=top width="50%">
<table border=0 cellspacing=0 cellpadding=2>
  <tr><td><nobr>Question 1</nobr></td><td><input class="form-control" name="e_flextext_1" value="<?php mit_p(e_flextext_1); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 2</nobr></td><td><input class="form-control" name="e_flextext_2" value="<?php mit_p(e_flextext_2); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 3</nobr></td><td><input class="form-control" name="e_flextext_3" value="<?php mit_p(e_flextext_3); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 4</nobr></td><td><input class="form-control" name="e_flextext_4" value="<?php mit_p(e_flextext_4); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 5</nobr></td><td><input class="form-control" name="e_flextext_5" value="<?php mit_p(e_flextext_5); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 6</nobr></td><td><input class="form-control" name="e_flextext_6" value="<?php mit_p(e_flextext_6); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 7</nobr></td><td><input class="form-control" name="e_flextext_7" value="<?php mit_p(e_flextext_7); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 8</nobr></td><td><input class="form-control" name="e_flextext_8" value="<?php mit_p(e_flextext_8); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 9</nobr></td><td><input class="form-control" name="e_flextext_9" value="<?php mit_p(e_flextext_9); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 10</nobr></td><td><input class="form-control" name="e_flextext_10" value="<?php mit_p(e_flextext_10); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 11</nobr></td><td><input class="form-control" name="e_flextext_11" value="<?php mit_p(e_flextext_11); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 12</nobr></td><td><input class="form-control" name="e_flextext_12" value="<?php mit_p(e_flextext_12); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Question 13</nobr></td><td><input class="form-control" name="e_flextext_13" value="<?php mit_p(e_flextext_13); ?>" type="text" size=27></td></tr>
</table>
</td>
<td valign=top width="50%">
<table border=0 cellspacing=0 cellpadding=2>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Yes/No Question 1</nobr></td><td><input class="form-control" name="e_flexcb_1" value="<?php mit_p(e_flexcb_1); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Yes/No Question 2</nobr></td><td><input class="form-control" name="e_flexcb_2" value="<?php mit_p(e_flexcb_2); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Yes/No Question 3</nobr></td><td><input class="form-control" name="e_flexcb_3" value="<?php mit_p(e_flexcb_3); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Yes/No Question 4</nobr></td><td><input class="form-control" name="e_flexcb_4" value="<?php mit_p(e_flexcb_4); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Yes/No Question 5</nobr></td><td><input class="form-control" name="e_flexcb_5" value="<?php mit_p(e_flexcb_5); ?>" type="text" size=27></td></tr>
</table>
</td></tr>
</table>

<?php /*======================================================================================*/ ?>
<?php /*======================================================================================*/ ?>

<div class="form-group"><div class="col-xs-9">
Confirmation Message (to be displayed once a participant has signed up for an event) <br/>
(Note: if you need participants to follow special instructions, you can specify them here as well)<br/>
   <textarea class="form-control" name="e_confirm_msg" rows=5 cols=110 wrap=off><?php mit_p(e_confirm_msg); ?></textarea>
</div></div>

<div class="form-group"><div class="col-xs-9">
  When the number of participants (either person or family, depends on the type chosen) reach this number
  <input style="width: 150px" name="e_spots_num" type="text" value="<?php echo 0+mit_c(e_spots_num); ?>" size=4> ,<br/>
  display the following "Event Full Message"
  (Note: if you set it to 0, that means this event has no limit, and the message below will never be displayed.)
<br><textarea class="form-control" name="e_full_msg" rows=5 cols=110 wrap=off><?php mit_p(e_full_msg); ?></textarea>
</div></div>

<?php /*==================================================================*/ ?>

<table border=0 cellspacing=0 cellpadding=2 style="margin-top:20px;" width="80%">
<tr class="cell4" style="background-color:#7070ef;">
  <td colspan=2 style="font:16px arial;">
  <b>On the "Participant Summary and Detail Listing" page,
  you can have additional fields that are not shown
  to the participants when they sign up.
  </b>&nbsp;(For example, "Waiver is Signed", "Notes about this participant", etc.)
  </td></tr>
<tr><td valign=top width="50%">
<table border=0 cellspacing=0 cellpadding=2>
  <tr><td><nobr>Text Label 1</nobr></td><td><input class="form-control" name="e_atext_1" value="<?php mit_p(e_atext_1); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Text Label 2</nobr></td><td><input class="form-control" name="e_atext_2" value="<?php mit_p(e_atext_2); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Text Label 3</nobr></td><td><input class="form-control" name="e_atext_3" value="<?php mit_p(e_atext_3); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Text Label 4</nobr></td><td><input class="form-control" name="e_atext_4" value="<?php mit_p(e_atext_4); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>Text Label 5</nobr></td><td><input class="form-control" name="e_atext_5" value="<?php mit_p(e_atext_5); ?>" type="text" size=27></td></tr>
</table>
</td><td valign=top width="50%">
<table border=0 cellspacing=0 cellpadding=2>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Checkbox Label 1</nobr></td><td><input class="form-control" name="e_abox_1" value="<?php mit_p(e_abox_1); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Checkbox Label 2</nobr></td><td><input class="form-control" name="e_abox_2" value="<?php mit_p(e_abox_2); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Checkbox Label 3</nobr></td><td><input class="form-control" name="e_abox_3" value="<?php mit_p(e_abox_3); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Checkbox Label 4</nobr></td><td><input class="form-control" name="e_abox_4" value="<?php mit_p(e_abox_4); ?>" type="text" size=27></td></tr>
  <tr><td><nobr>&nbsp;&nbsp;&nbsp;Checkbox Label 5</nobr></td><td><input class="form-control" name="e_abox_5" value="<?php mit_p(e_abox_5); ?>" type="text" size=27></td></tr>
</table>
</td></tr>
</table>

<?php /*==================================================================*/ ?>

<table border=0 cellspacing=0 cellpadding=2 style="margin-top:10px;"
width="80%">
<tr><td><input class="btn btn-primary btn-lg" type="submit" value="Save">
<input type="hidden" name="eid" value="<? echo htmlspecialchars($mit_eid); ?>">
<input type="hidden" name="copy" value="<? if ($mit_copy!='') echo 'y'; ?>">
<input type="button"  class="btn btn-default btn-lg" value="Cancel"
<?php if ($mit_ev<0)
   echo "onClick=\"location.href='event.php?t=",$mit_rand,"'\""; // Create
else
   echo "onClick=\"location.href='event_people.php?eid=",$mit_eid,"&t=",$mit_rand,"'\""; // Copy/Edit
?>>
</td></tr></table>

</form>

   <script src="js/jquery-1.10.2.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script>
	function setFee() {
	   $("input[name='e_adult_fee']").prop("disabled",$("input[name='e_fee_varies']").is(":checked"));
	   $("input[name='e_child_fee']").prop("disabled",$("input[name='e_fee_varies']").is(":checked"));
	}
	$("input[name='e_fee_varies']").click(setFee);
	$(document).ready(function() { setFee(); });
   </script>

   </div> <!-- container -->
   
   </body>
</html>
