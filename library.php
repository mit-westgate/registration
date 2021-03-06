<?php  session_start(); ?>
<?php

// **********************************************************************************
// **** PERMISSIONS: Enter MIT Usernames to enable Administrative Website Access ****
// **** You should only need to change the officer position usernames ****
// **********************************************************************************

// These must be comma-separated strings
$mit_officer_pres = "brij";      // President
$mit_officer_crc  = "galashin";        // Couples Resource Coordinators
$mit_officer_prc  = "cfunk";         // Parents Resource Coordinators
$mit_officer_sc   = "scotttan";     // Social Chairs
$mit_officer_rfro = "elehnhar";       // Recycling & Floor Rep Organizers
$mit_officer_csc = "yyn";       // Community Organizers
$mit_officer_gc   = "amiya";      // Graduate Coordinators
$mit_officer_tr  = "nili,lpersits";       // Treasurer
$mit_officer_pcc = "marijas,yuguo";        // Partners Community Coordinator
$mit_officer_rla  = "naomic";       // RLA
$mit_officer_web  = "yasushis,niuren,jlmiao,mmjin";     // Person maintaining php pages
$mit_community = "";  // community members needing web access

// **********************************************************************************
// **** Hopefuly you won't need to modify any other options ****
// **********************************************************************************


// **********************************************************************************
// **** For further customization, these can be modified ****

// These people can do EVERYTHING
$mit_superusers = $mit_officer_rla.",".$mit_officer_web;

// WHO can admin the FORUM pages
$mit_forumusers = $mit_officer_gc;

// WHO can create NEW EVENTS
$mit_eventusers = $mit_officer_crc.",".$mit_officer_prc.",".$mit_officer_sc.",".$mit_officer_pres.",".$mit_officer_rfro.",".$mit_officer_tr.",".$mit_officer_pcc.",".$mit_officer_gc.",".$mit_officer_csc.",".$mit_community;

// WHO can admin the MOVIE pages
$mit_movieusers = $mit_officer_web;

// WHO can admin the BIKE Rental & Bike Registration Pages
$mit_bikeusers  = $mit_officer_web;

// WHO can admin the SPORTS pages
$mit_sportusers = $mit_officer_web;


// **********************************************************************************
// **** Path Details of Where Website is stored ****

// AFS location of the DATABASE files
$mit_loc='/mit/westgate/web_scripts/registration/db/';

// AFS location for TEMPORARY files
$mit_temploc='/mit/westgate/web_scripts/registration/tmp/';

// AFS location of the uploaded picture files
$mit_uploc='/mit/westgate/web_scripts/registration/public/';

// HTTP location of the uploaded picture files
$mit_st='http://westgate.scripts.mit.edu/registration/public/';

// HTTP location of the main web site files
$mit_htmlurl='http://westgate.scripts.mit.edu/';

// The MAIN URL to access the scripts...
$mit_url='westgate.scripts.mit.edu/registration/';
$mit_url_https='westgate.scripts.mit.edu:444/registration/';

// I (Jason) am not sure about this address; westgate.mit.edu doesn't belong to us
// $mit_shorturl='eastgate.mit.edu/';
$mit_shorturl='westgate.scripts.mit.edu/';

// *** (Not currently in use) Options for the PhotoList web page ***

// The AFS location of Westgate Past Events Photos
// Note, this directory doesn't even exist for us
$mit_eventphotosdir = '/mit/westgate/www/eventphotos/';

// The location of Westgate Past Events Photos (web URL)
// Note, this directory doesn't even exist for us
$mit_eventphotoswebdir = 'http://web.mit.edu/~westgate/www/eventphotos/';

// **********************************************************************************
// **** Details related to Bike Rental Program ****
// Note, this is Eastgate legacy code; we don't even have a bike rental program

// The number of Bikes in the MIT Bike Rental Brogram
$mit_numbikes   = 1;  // Mens Bikes
$mit_numbikes_w = 2;  // Womens Bikes
$mit_numtrailers = 1; // Child Trailers

// To allow easy linking to the Bike Rental Page 
// (shouldn't need to change this - check this if bikes.php doesn't work correctly)
$mit_bike_eventID = 2649;

// **********************************************************************************
// **** Details related to the Event Pages ****

// String to Search for in Event Title to classify it as 'Sport'
$mit_sporteventstr = 'IM';    // case-sensitive

// URL Link to Event-Photo Web page
$mit_pastevents = 'http://picasaweb.google.com/westgate.events';
// $mit_pastevents = 'photo_list.php'; // If using the photo_list scripts

// Default Time hour (24 hr) to open sign-up
$mit_opensignuptime = 2001;

// **********************************************************************************
// **** IP Details for restricting access to MIT campus or to Eastgate only ****

// Eastgate Computer IP Address Prefix:
$mit_eastgate_ip_prefix = "18.98.";
// MIT Computer IP Address Prefix:
$mit_ip_prefix = "18.";

// **********************************************************************************
// **** Details related to the SPORTS Sign-up Pages ****
// Not sure how this should be changed to fit with Westgate; check with Aidan

// Web Address of MAILMAN pages e.g. $mit_mailman_url/eastgate-list
$mit_mailman_url = 'http://mailman.mit.edu/mailman/listinfo/';

// Sports@Eastgate Scripting E-mail
$mit_sports_sender = "eastgate-sports@mit.edu"; // From Address
$mit_sports_prefix = "[Pick-up Sports]";        // E-mail subject prefix
$mit_sports_sendername = "SportMeister";        // From Name

// By default, only display sports that have e-mail lists including with the following in the address:
$mit_sportfilter = "eastgate";

// **********************************************************************************

// **********************************************************************************
// **** Details related to the Movie Pages ****
// Note, this is Eastgate legacy code, Westgate doesn't manage movie rentals

// Eastgate Video E-mail Configuration
$mit_video_email = "eastgate-video@mit.edu";    // From Address on E-mails

// **********************************************************************************

// **** For Event Calendar hosted on Google ****

// Google Account Login for Westgate Events Calendar
$mit_event_account = "westgate.events@gmail.com";        

// Password to the above named account
$mit_event_acpwd   = "540memorial";

//  URL for HTML Calendar for Westgate Residents (known as 'Private URL')
$mit_eventcal_url = "http://westgate.scripts.mit.edu/events";

// URL for Westgate Events Calendar for Administrators
$mit_eventcal_adminurl = "http://www.google.com/calendar/embed?src=westgate.events%40gmail.com";

// Person responsible for updating calendar
// RMC Added back in, emails advising for updating the calendar after an event change were going
// to event creators, which didn't make sense
$mit_calendar_email = "westgate-web@mit.edu";


// **********************************************************************************
// ****  Bike Registration Page ****

// Note that if these are edited, text in bikereg.php must be adjusted manually
// Expiration Month
$mit_bikereg_expire = 8;  // August 31
// Open Registration Month
$mit_bikereg_open = 7;    // July 1

// **********************************************************************************

//===========================================================================//
// Hopefully, we shouldn't need to modify anything below here...             //
//===========================================================================//

error_reporting(0); umask(0177);
header('Expires: Fri, 01 Jan 1990 00:00:00 GMT');
header('Pragma: no cache');
header('Cache-Control: no-cache, must-revalidate');

// After Feb 5 2006, pages that require authentication will no longer
// work on "scripts.mit.edu", and instead we have to use "scripts-cert.mit.edu"
// Since many people still have bookmark/links to the old URL,
// the following code will redirect the user to the new URL.
if (array_key_exists('HTTP_HOST',$_SERVER))
 if (array_key_exists('REQUEST_URI',$_SERVER))
  {
   $a=$_SERVER['HTTP_HOST'];
   $b=$_SERVER['REQUEST_URI'];
   if (strcasecmp($a,'scripts.mit.edu')==0)
    {
     if ($_SERVER['SERVER_PORT']=='443')
       header('Location: https://scripts-cert.mit.edu'.$b);
     else
       header('Location: http://scripts-cert.mit.edu'.$b);
     exit;
    }
  }

// A random ID that we append to the URLs to make sure we don't get cached
$mit_rand = date('Y.m.d.H.i.s.').rand(1,32768);

//===========================================================================//

function mit_divide_10($k) // Convert $k to an integer then divide by 10
 {
  // The reason we need this function is that 'a/b' in PHP will always return
  // a floating point number even if a and b are both integers!
  // => this can cause a round-off error!
  $k=''.(0+floor($k)); $l=strlen($k);
  if ($l<=1) return 0; $k=substr($k,0,$l-1); return 0+$k;
 }

function mit_divide_100($k) // Convert $k to an integer then divide by 100
 {
  $k=''.(0+floor($k)); $l=strlen($k);
  if ($l<=2) return 0; $k=substr($k,0,$l-2); return 0+$k;
 }

function mit_divide_10000($k) // Convert $k to an integer then divide by 10000
 {
  $k=''.(0+floor($k)); $l=strlen($k);
  if ($l<=4) return 0; $k=substr($k,0,$l-4); return 0+$k;
 }

function mit_getpost($k)
 {
  // Retrieves a parameter from the URL or from a FORM submission
  // For example, if user visits your page as something.php?a=3&b=4,
  // then mit_getpost('a') will return 3.
  if (array_key_exists($k,$_GET))
     { if ($_GET[$k]!='') return $_GET[$k]; }
  if (array_key_exists($k,$_POST)) return $_POST[$k];
  return '';
 }

function mit_max_days($y,$m)
 {
  // Returns the maximum number of days in year $y=1970... and month $m=1..12
  // NOTE:
  // If $m==0, we treat it as if it's December of the previous year
  // If $m==13, we treat it as if it's January of the next year
  // To prevent integer overflow, if $y!=2000..2999 or $m!=0..13, we return 31
  $y=$y+0;
  $m=$m+0;
  if ($y<2000 || $y>2999 || $m<0 || $m>13) return 31;
  while($m<1) {$y--; $m=$m+12;}
  while($m>12) {$y++; $m=$m-12;}
  if ($m>7) return 31-($m%2);
  if ($m!=2) return 30+($m%2);
  if ($y<0) return 31;
  if (($y%4)!=0) return 28;
  if (($y%400)==0) return 29;
  if (($y%100)==0) return 28;
  return 29;
 }

// If this value > 0, that means we are holding the LOCK. Else, we are not.
$mit_locked=0;

// If $mit_lock > 0, then this variable holds the file handle to the LOCK FILE.
$mit_lock_handle='';

function mit_lock()
 {
  // Lock the database.
  // It may wait for a while for the lock to open up.
  // When it fails to get the lock, it will display an ERROR MESSAGE and exit.
  global $mit_loc,$mit_locked,$mit_lock_handle;
  if ($mit_locked>0) return;
  $mit_lock_handle=fopen($mit_loc.'lock.db','a');
  if (flock($mit_lock_handle,LOCK_EX)) {$mit_locked=1;clearstatcache();} else
   {
    echo '<H1>Error</H1>The system is currently busy. Please try again later!';
    exit;
   }
 }

function mit_unlock()
 {
  // Unlock the database.
  global $mit_locked,$mit_lock_handle;
  if ($mit_locked!=0)
   {
    fclose($mit_lock_handle); clearstatcache(); $mit_locked=0;
   }
 }

function mit_fail()
 {
  // Redirects the user to the "failed.php" page
  global $mit_url;
  mit_unlock(); header('Location: http://'.$mit_url.'failed.php'); exit;
 }

function mit_go($w) // Redirects the user to a particular HTTP url
 {
  global $mit_url; mit_unlock(); header('Location: http://'.$mit_url.$w);exit;
 }

function mit_gos($w) // Redirects the user to a particular HTTPS url
 {
  global $mit_url_https; mit_unlock(); header('Location: https://'.$mit_url_https.$w);exit;
 }

function mit_convdate($x)
 {
  // Given a date given in "m/d/y" format,
  // convert it to YYYYMMDD and return it as an integer.
  // (If the input is mal-formed, return 0)
  $x=''.$x; $l=strlen($x); $y=0; $m=0; $d=0;
  for($i=0;$i<$l;$i++)
   {
    $b=substr($x,$i,1);
    if (ord($b)>=48 && ord($b)<=57)
     {
      $y=$y*10+ord($b)-48; if ($y>9999) return 0; continue;
     }
    if ($b==' ') continue;
    if ($b!='/' || $m!=0 || $y==0) return 0;
    $m=$d; $d=$y; $y=0;
   }
  if ($y<0 || $m<1 || $m>12 || $d<1) return 0;
  if ($d>mit_max_days($y,$m)) return 0;
  return $y*10000+$m*100+$d;
 }

function mit_hyphdate($x)
 {
  // Given a date given in "m/d/y" format,
  // convert it to YYYY-MM-DD and return it as a string
  // (If the input is mal-formed, return '')

  $intdate = mit_convdate($x);
  if ($intdate>0)
   {
    $y = floor($intdate / 10000);
    $dm = $intdate % 10000;
    $m = floor($dm / 100);
    $d = $dm % 100;

    $strdate = str_pad($y, 4, "0", STR_PAD_LEFT).'-'.
               str_pad($m, 2, "0", STR_PAD_LEFT).'-'.
               str_pad($d, 2, "0", STR_PAD_LEFT);
    
    return $strdate;

   } else return '';

 }

function mit_time24($x)
 {
  // Given a time given in format "H:MM PM" or "HH:MM PM" or "HH:MM"
  // convert it to HH:MM 24-hour format and return it as a string
  // (If the input is mal-formed, return '')

  $x=''.$x; $l=strlen($x); $m=0;

  if ($x == '') return '';

  $splitpos = strpos($x, ":", 0);
  if ($splitpos < 0) return '';

  $strhour=substr($x, 0, $splitpos);
  $endminpos = strpos($x, " ", $splitpos+1);

  if ($endminpos < 0) // Minute goes all way to end
   {
    $strmin = substr($x,$splitpos+1);
   } else {           // Minute + AM/PM
    $strmin = substr($x,$splitpos+1,$endminpos-$splitpos-1);
    $ampm = trim(strtoupper(substr($x,$endminpos+1)));
    if ($ampm == "PM") $strhour=12+$strhour;
   }
  
  if ((0+$strhour > 23) or (0+$strhour) < 0) return '';
  if ((0+$strmin > 59) or (0+$strmin) < 0) return '';
  
  $result = str_pad(0+$strhour,2,"0", STR_PAD_LEFT).":".str_pad(0+$strmin,2,"0", STR_PAD_LEFT);

  return $result;

 }

function mit_convapt($x)
 {
  // Given an Eastgate apartment number written as "2A", "2-A", "2 A", " 2A", or 02A...
  // Return a 3 digit number FFU (FF=2 digit floor number, and U=1..8 for A..H)
  // (If the apartment doesn't exist, then return 0)
  $x=''.$x; $l=strlen($x); $a=0; $b=0;
  for($i=0;$i<$l;$i++)
   {
    $t=substr($x,$i,1);
    if (ord($t)>=48 && ord($t)<=57)
     {
      if ($b>0) return 0; $a=$a*10+(ord($t)-48); // 0..9
     }
    elseif (ord($t)>=65 && ord($t)<=72)
     {
      if ($a==0 || $b>0) return 0; $b=ord($t)-64; // A..H
     }
    elseif (ord($t)>=97 && ord($t)<=104)
     {
      if ($a==0 || $b>0) return 0; $b=ord($t)-96; // a..h
     }
    elseif ($t!=' ' && $t!='-') return 0;
   }
  if ($a<2 || $a>28 || $b==0 || ($a>22 && $b>6)) return 0;
  return $a*10+$b;
 }

function mit_g($a,$f) // Read a field from an EVENT OBJECT
 {
  if (array_key_exists($f,$a)) {
	if(in_array($f,array(e_rsvp_dt,e_opendate,e_pay_dt,e_date,e_enddate)) && strlen($a[$f]) < 8){
		return ''; }
	else{
		return $a[$f]; }
  } else 
	return '';
 }

$mit_cmp=e_name; // This GLOBAL FLAG decides which FIELD we do the sorting on.

function mit_cmp_text($a,$b) // This performs a CASE-INSENSITIVE TEXT SORT
 {
  global $mit_cmp;
  return strcasecmp(mit_g($a,$mit_cmp),mit_g($b,$mit_cmp));
 }

function mit_cmp_num($a,$b) // This performs an INTEGER SORT
 {
  global $mit_cmp;
  $a=0+mit_g($a,$mit_cmp); $b=0+mit_g($b,$mit_cmp);
  if ($a<$b) return -1; if ($a>$b) return 1; return 0;
 }

function mit_cmp_date($a,$b) // This sorts by DATE
 {
  global $mit_cmp;
  $a=mit_convdate(mit_g($a,$mit_cmp));
  $b=mit_convdate(mit_g($b,$mit_cmp));
  if ($a<$b) return -1; if ($a>$b) return 1; return 0;
 }

function mit_cmp_apt($a,$b) // This sorts by eastgate apartment number
 {
  global $mit_cmp;
  $a=mit_convapt(mit_g($a,$mit_cmp));
  $b=mit_convapt(mit_g($b,$mit_cmp));
  if ($a<$b) return -1; if ($a>$b) return 1; return 0;
 }

function mit_read($f)
 {
  global $mit_loc; $f=$mit_loc.$f;
  if (!file_exists($f)) return array();
  $d=fopen($f,'rb');
  $t=fread($d,filesize($f));
  fclose($d);
  return unserialize($t);
 }

function mit_write($c,$f)
 {
  global $mit_loc; $f=$mit_loc.$f;
  $c=serialize($c);
  $d=fopen($f.'.tmp','w+b');
  fwrite($d,$c);
  fclose($d);
  rename($f.'.tmp',$f);
  clearstatcache();
 }

function mit_new_id()
 {
  $z=mit_read('scoreboard.db');
  if (array_key_exists(0,$z)) {$z=$z[0];$z++;} else $z=1;
  $a=array($z); mit_write($a,'scoreboard.db'); return $z;
 }

function mit_cert_nonfatal($mp)
 {
  global $mit_superusers;
  $m=$mit_superusers;
  if ($mp!='') $m = $m.",".$mp;
  $e="";
  if (array_key_exists('SSL_CLIENT_S_DN_Email',$_SERVER))
   {
    $e=$_SERVER['SSL_CLIENT_S_DN_Email'];
   }

  if(''==$e){
    $e = $_SESSION['user'];
  }
  $z=explode(",",$m);
  foreach($z as $k => $v)
   {
    $v=trim($v," \t@.");
    if (strcasecmp($e,$v)==0) return $v;
    if (strcasecmp($e,$v.'@mit.edu')==0) return $v;
   }
  return '';
 }

function mit_cert($m)
 {
  $m=mit_cert_nonfatal($m); if ($m!='') return $m; mit_fail();
 }

function mit_page($a,$c,$b) // $a=PRE $b=COUNT $c=POST
 {
  global $mit_rand;
  $q=$c;
  $r=mit_divide_10($q); if ($r*10<$q) $r=$r+1;
  $p=0+mit_getpost('p'); if ($p>=$r) $p=$r-1;
  if ($r>1)
   {
    echo $a,'Pages: ';
    for($i=0;$i<$r;$i++)
     {
      if ($p!=$i) echo '<a href="forum.php?t=',urlencode(mit_getpost('t')),
         '&f=',urlencode(mit_getpost('f')),'&p=',$i,
         '&tt=',$mit_rand,'">'; else echo '<b>';
      echo 1+$i;
      if ($p!=$i) echo "</a> \n"; else echo "</b> \n";
     }
    echo $b;
   }
  return $p;
 }

function mit_pad2($n)
 {
  $n=$n+0;
  if ($n < 0 || $n > 99) return '00'; // Sanity Check...
  if ($n < 10) return '0'.$n;
  return ''.$n;
 }

function mit_pad4($n)
 {
  $n=$n+0;
  if ($n < 0 || $n > 9999) return '0000'; // Sanity Check...
  if ($n < 10) return '000'.$n;
  if ($n < 100) return '0'.$n;
  if ($n < 1000) return '0'.$n;
  return ''.$n;
 }

$mit_row=1;

function mit_tr($a)
 {
  global $mit_row;
  if ($mit_row==1) {echo "\n\n<tr class=\"row1\"",$a,">\n";$mit_row=2;}
  else {echo "\n\n<tr class=\"row2\"",$a,">\n";$mit_row=1;}
 }

function mit_td($a,$b)
 {
  if ($b=='') return;
  mit_tr("");
  if ($a=='')
    echo "<td class=\"col2\" colspan=2\n>",$b,"</td></tr>\n";
  else
    echo "<td class=\"col1\"\n><nobr>",$a,
    "</nobr></td><td class=\"col2\"\n><nobr>",$b,"</nobr></td></tr>\n";
 }

function mit_tdbox($a,$b)
 {
  if ($b=='') return;
  mit_tr("");
  if ($a=='')
    echo "<td class=\"col3\" colspan=2\n>",$b,"</td></tr>\n";
  else
    echo "<td class=\"col3\"\n><nobr>",$a,
    "</nobr></td><td class=\"col2\"\n><nobr>",$b,"</nobr></td></tr>\n";
 }

//======Returns a key from the MIT certificate information=======
// ACC: 8/8/06

function mit_cert_info($key)
 {
  if (array_key_exists($key,$_SERVER))
   {
    $ret=$_SERVER[$key];
   } else $ret='';

  return $ret;

 }
//==============================================================

//======Returns the MIT user ID================================
// ACC 8/8/06

function mit_username()
 {
  $username = mit_cert_info('SSL_CLIENT_S_DN_Email');
  $atpos = strpos($username,"@");
  if ($atpos > 0) $mit_user = trim(substr($username,0,$atpos)); else 
   $mit_user = trim($username);

  return $mit_user;
 }

//=============================================================


//========= Determines if computer is in specified IP range =======
// ACC 8/8/06

function mit_checkip($ip_prefix)
 { 

  $remote_ip = mit_cert_info('REMOTE_ADDR');

  if ($remote_ip != '') 
   {
    if (substr($remote_ip,0,strlen($ip_prefix)) == $ip_prefix)
     {
      return true;
     }
   }
  return false; 
 }


//========= Restricts page to MIT use only =======
// ACC: 9/12/06
function mit_restrict($page)
 {
  // Checks if user is within MIT IP range
  // If not, check is user is using certificate
  // If also not, forwards user to page where MIT certificate can be obtained
  // and secure connection retried
  global $mit_url,$mit_ip_prefix;

  if (!mit_checkip($mit_ip_prefix))
   {
    if (mit_username() == '')
     {
      mit_unlock();
      header('Location: http://'.$mit_url.'mitonly.php?page='.$page); exit;
     }
   }
  return true;
 }




//====================================================================

// =========== ACC 9/8/06 ===============
// Generates a random string

function randomkeys($length)
{
  $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
  $key = "";
  for($i=0;$i<$length;$i++)
  {
    $key .= $pattern{rand(0,35)};
  }
  return $key;
}

// Filter sports based on the specified filter
// Check that all sports have the filter in them, otherwise set the sport ID to -1

function mit_filter_sports($mit_sports, $mit_filter)
{
  if ($mit_filter=='') return $mit_sports;

  $mit_sports_new = array();

  for($i=0;$i<count($mit_sports);$i++)
   {
    $inc = 0;
    $cur_sport = $mit_sports[$i];
    $cur_email = mit_g($cur_sport,sp_email);
    $z=explode(",",$cur_email);
    foreach($z as $k => $v)
     {
      if (is_numeric(strpos($v,$mit_filter)) and ($inc==0))
       {
        array_push($mit_sports_new,$cur_sport);
        $inc = 1;
       }
     }
   }
  if (count($mit_sports_new)>0) return $mit_sports_new;
   else return $mit_sports;
}




//===========================================================================//
// mit_htmlspecialchars (Inserted by ACC: 6/4/06)                            //
//  works just like htmlspecialchars() except if text is enclosed between    //
//  <HTML>this</HTML> then it does not convert this to HTML                  //
//===========================================================================//

function mit_htmlspecialchars($strsearch)
 {
  $htmlstart = '<HTML>';
  $htmlend = '</HTML>';

  $inhtml = 0;
  $textpos = 0;
  $endpos = 0;
  $startpos = 0;
  $output = '';

  while ($textpos <= strlen($strsearch)) {
   if ($inhtml == 1) {
    $endpos = strpos(strtoupper($strsearch), $htmlend, $textpos);
    if ($endpos === false) {
     $textpos = strlen($strsearch) + 1;
     $extractedstr = substr($strsearch, $startpos+strlen($htmlstart));
    } else {
     $inhtml = 0;
     $textpos = $endpos + 1;
     $extractedstr = substr($strsearch, $startpos+strlen($htmlstart), $endpos-$startpos-strlen($htmlstart));
    }

    // Written in HTML Code
    $output = $output.$extractedstr;
  
   } else {
    $startpos = strpos(strtoupper($strsearch), $htmlstart, $textpos);
    if ($startpos === false) {
     if ($endpos > 0) {
      $extractedstr = substr($strsearch, $endpos+strlen($htmlend));
     } else {
      $extractedstr = $strsearch;
     } 
     $textpos = strlen($strsearch) + 1;
    } else {
     $inhtml = 1;
     $textpos = $startpos + 1;
     if ($endpos > 0) {
      $extractedstr = substr($strsearch, $endpos+strlen($htmlend), $startpos-$endpos-strlen($htmlend));
     } else {
      $extractedstr = substr($strsearch, 0, $startpos);
     } 
    }

    // Not Written in HTML Code - Convert
    $output = $output.htmlspecialchars($extractedstr);

   }
  }

  return (str_replace('
','<BR>',$output));

//  return $output;

 }



// This function is similar to mit_htmlspecialchars
// except it converts everything as if it is NOT
// written in HTML, but items between 
// <LINK>http://www.google.com</LINK> are converted to hyperlinks

function mit_htmlspecialchars_convertlinks($strsearch)
 {
  $htmlstart = '<LINK>';
  $htmlend = '</LINK>';

  $inhtml = 0;
  $textpos = 0;
  $endpos = 0;
  $startpos = 0;
  $output = '';

  while ($textpos <= strlen($strsearch)) {
   if ($inhtml == 1) {
    $endpos = strpos(strtoupper($strsearch), $htmlend, $textpos);
    if ($endpos === false) {
     $textpos = strlen($strsearch) + 1;
     $extractedstr = substr($strsearch, $startpos+strlen($htmlstart));
    } else {
     $inhtml = 0;
     $textpos = $endpos + 1;
     $extractedstr = substr($strsearch, $startpos+strlen($htmlstart), $endpos-$startpos-strlen($htmlstart));
    }

    // Link Desired
    $output = $output."<a target='_blank' href='".$extractedstr."'>".htmlspecialchars($extractedstr)."</a>";  

   } else {
    $startpos = strpos(strtoupper($strsearch), $htmlstart, $textpos);
    if ($startpos === false) {
     if ($endpos > 0) {
      $extractedstr = substr($strsearch, $endpos+strlen($htmlend));
     } else {
      $extractedstr = $strsearch;
     } 
     $textpos = strlen($strsearch) + 1;
    } else {
     $inhtml = 1;
     $textpos = $startpos + 1;
     if ($endpos > 0) {
      $extractedstr = substr($strsearch, $endpos+strlen($htmlend), $startpos-$endpos-strlen($htmlend));
     } else {
      $extractedstr = substr($strsearch, 0, $startpos);
     } 
    }

    // Convert HTML characters
    $output = $output.htmlspecialchars($extractedstr);

   }
  }

  return (str_replace('
','<BR>',$output));

  //  return $output;

 }


// ----------------ACC: 08/21/2006------------

// mit_g() with HTMLSpecialChars() applied

function mit_gp($e,$f)
 {
  $v=htmlspecialchars(mit_g($e,$f));
  return $v;
 }

// -------------------------------------------

// ----------------ACC: 09/06/2006-------------
// Some date converting/formatting functions


// Converts a date that looks like YYYYMMDD to system time.
function mit_systime($dateint, $timeint)
 {
  $sec   = 0;
  $min   = $timeint % 100;
  $hour  = intval($timeint/100);
  $day   = $dateint % 100;
  $month = (($dateint % 10000) - $day)/100;
  $year = intval($dateint / 10000);

  return mktime($hour,$min,$sec,$month,$day,$year);
 }

// Reformats a date in integer form to anything else.
function mit_formatdate($dateint,$timeint,$format)
 {
  $systime = mit_systime($dateint,$timeint);
  return date($format,$systime);
 }


function mit_easydate($systime)
 {
  $dispdate = date(Ymd,$systime);
  $d_disp = date('l jS M',$systime);
  $curtime = time();
  $today = date(Ymd,$curtime);
  $tomorrow = date(Ymd,$curtime+86400);
  if ($dispdate==$today) $d_disp = 'Today ('.$d_disp.')';
  if ($dispdate==$tomorrow) $d_disp = 'Tomorrow ('.$d_disp.')';

  return $d_disp;

 }

//--------------------------------------------------------------



//===========================================================================//
// mit_gg($array,field)                                                      //
// => Just like mit_g(), except that                                         //
//    (1) it performs some changes to make some fields look nicer,           //
//    (2) it then calls htmlspecialchars() to prevent messing up HTML        //
//===========================================================================//

function mit_gg($e,$f)
 {
  $v=htmlspecialchars(mit_g($e,$f));
//  $v=mit_htmlspecialchars(mit_g($e,$f));
  if (e_desc==$f || e_confirm_msg==$f || e_full_msg==$f)
   { 
    return (str_replace('
','<BR>',$v));
   }
  if (e_link==$f)
   {
    if ($v=='') return '';
    if (strlen($v)>=7)
    {if (strcasecmp(substr($v,0,7),'http://')==0) return $v;}
    return 'http://'.$v; // zzz TODO: Worry about quotes!
   }
  if (e_start==$f || e_end==$f)
   {
    if ($v=='') return '';
    $h=mit_divide_100($v);
    $m=mit_pad2($v%100);
    if ($h<12) return $h.':'.$m.' AM';
    if ($h>12) return ($h-12).':'.$m.' PM';
    if ($m==0) return 'Noon'; return '12:30 PM';
   }
  if (e_date==$f || e_enddate==$f
   || e_rsvp_dt==$f || e_pay_dt==$f)
   {
    $m=array('Jan','Feb','Mar','Apr','May'
    ,'Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $d = mit_convdate($v); if ($d<=0) return '';
    $v=($m[mit_divide_100($d)%100-1]).' '.($d%100).', ';
    $v=$v.mit_divide_10000($d).'&nbsp;&nbsp;';
    if (e_date!=$f) return $v;
    $a=mit_gg($e,e_start); if ($a=='') return $v;
    $b=mit_gg($e,e_end); if ($b=='') return $v.'(Start Time: '.$a.')';
    return $v.'(Time: '.$a.' - '.$b.')';
   }
  if (e_adult_fee==$f)
   {
   if(mit_gg($e,e_fee_varies)!='') return 'Fee varies.';
    $a=$v;
    $c=mit_gg($e,e_child_fee);
    if ($a=='0'|| $a=='0.0'|| $a=='0.00') {$a='';}
    if ($c=='0'|| $c=='0.0'|| $c=='0.00') {$c='';}
    if ($a=='' && $c=='') return '';
    if (mit_g($e,e_adult_friendly)=='')
     {
      if (mit_g($e,e_child_friendly)=='') return 'undecided';
      if ($c!='') return '$'.$c.' per child'; return 'free for children';
     }
    if ($a!='') $a='$'.$a.' per adult'; else $a='free for adults';
    if (mit_g($e,e_child_friendly)=='') return $a;
    if ($c!='') $c='$'.$c.' per child'; else $c='free for children';
    return $a.', '.$c;
   }
  return $v;
 }


// Copied mit_gg, but modified date to return a shortdate
// returns a short date (e.g. "June 4")
// this could use some trimming or be merged into above

function mit_shortdate($e,$f)
 {
  $v=htmlspecialchars(mit_g($e,$f));
  if (e_desc==$f || e_confirm_msg==$f || e_full_msg==$f)
   {
    return (str_replace('
','<BR>',$v));
   }
  if (e_link==$f)
   {
    if ($v=='') return '';
    if (strlen($v)>=7)
    {if (strcasecmp(substr($v,0,7),'http://')==0) return $v;}
    return 'http://'.$v; // zzz TODO: Worry about quotes!
   }
  if (e_start==$f || e_end==$f)
   {
    if ($v=='') return '';
    $h=mit_divide_100($v);
    $m=mit_pad2($v%100);
    if ($h<12) return $h.':'.$m.' AM';
    if ($h>12) return ($h-12).':'.$m.' PM';
    if ($m==0) return 'Noon'; return '12:30 PM';
   }
  if (e_date==$f || e_enddate==$f
   || e_rsvp_dt==$f || e_pay_dt==$f)
   {
    $m=array('Jan','Feb','Mar','Apr','May'
    ,'Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $d = mit_convdate($v); if ($d<=0) return '';
    $v=($m[mit_divide_100($d)%100-1]).' '.($d%100);
#    $v=$v.mit_divide_10000($d).'&nbsp;&nbsp;';
    return $v;
   }
  if (e_adult_fee==$f)
   {
    $a=$v;
    $c=mit_gg($e,e_child_fee);
    if ($a=='0'|| $a=='0.0'|| $a=='0.00') {$a='';}
    if ($c=='0'|| $c=='0.0'|| $c=='0.00') {$c='';}
    if ($a=='' && $c=='') return '';
    if (mit_g($e,e_adult_friendly)=='')
     {
      if (mit_g($e,e_child_friendly)=='') return 'undecided';
      if ($c!='') return '$'.$c.' per child'; return 'free for children';
     }
    if ($a!='') $a='$'.$a.' per adult'; else $a='free for adults';
    if (mit_g($e,e_child_friendly)=='') return $a;
    if ($c!='') $c='$'.$c.' per child'; else $c='free for children';
    return $a.', '.$c;
   }
  return $v;
 }


//===========================================================================//
// File Structure:                                                           //
// * Multiple Event records will make up 1 Event file.                       //
// * Each Event will have an ID.                                             //
// * For Each Event, participants will be stored in 1 participant file       //
//   whose file name is equal to EVENT ID (e_id).                            //
//===========================================================================//

// (Bulletin Board Use) Each FORUM has the following fields:
define("bb_f_id",0);
define("bb_f_name",1);
define("bb_f_desc",2);
define("bb_f_numtopics",3);
define("bb_f_numposts",4);
define("bb_f_lastpostdt",5);

// (Bulletin Board Use) Each TOPIC has the following fields:
define("bb_t_id",0);
define("bb_t_subject",1);
define("bb_t_createdt",2);
define("bb_t_lastpostdt",3);
define("bb_t_numposts",4);

// (Bulletin Board Use) Each POST has the following fields:
define("bb_p_id",0);
define("bb_p_date",1);
define("bb_p_submitter",2);
define("bb_p_ip",3);
define("bb_p_cert",4);
define("bb_p_approved",5);
define("bb_p_text",6);

// These fields are common between calendar app and event app
$emap=array();
define("e_id",0);              $emap[e_id            ]='e_id';
define("e_date",1);            $emap[e_date          ]='e_date';
define("e_enddate",39);        $emap[e_enddate       ]='e_enddate';
define("e_start",2);           $emap[e_start         ]='e_start';
define("e_end",4);             $emap[e_end           ]='e_end';
define("e_title",6);           $emap[e_title         ]='e_title';
define("e_desc",7);            $emap[e_desc          ]='e_desc';
define("e_link",8);            $emap[e_link          ]='e_link';
define("e_name",9);            $emap[e_name          ]='e_name';
define("e_email",11);          $emap[e_email         ]='e_email';
define("e_apt",12);            $emap[e_apt           ]='e_apt';
define("e_auth",38);           $emap[e_auth          ]='e_auth';

//calendar-specific or bike-calendar-specific:
define("e_startap",3);         $emap[e_startap       ]='e_startap';
define("e_endap",5);           $emap[e_endap         ]='e_endap';
define("e_phone",10);          $emap[e_phone         ]='e_phone';
define("e_mgr",13);            $emap[e_mgr           ]='e_mgr';
define("e_crd",14);            $emap[e_crd           ]='e_crd';
define("e_stereo",15);         $emap[e_stereo        ]='e_stereo';
define("e_alcohol",16);        $emap[e_alcohol       ]='e_alcohol';
define("e_stereo_p",17);       $emap[e_stereo_p      ]='e_stereo_p';
define("e_alcohol_p",18);      $emap[e_alcohol_p     ]='e_alcohol_p';
define("e_reserve_p",19);      $emap[e_reserve_p     ]='e_reserve_p';
define("e_deposit_p",20);      $emap[e_deposit_p     ]='e_deposit_p';
define("e_bgcolor",21);        $emap[e_bgcolor       ]='e_bgcolor';
define("e_notes",22);          $emap[e_notes         ]='e_notes';
define("e_allday",40);         $emap[e_allday        ]='e_allday';
define("e_resource",41);       $emap[e_resource      ]='e_resource';
define("e_numbikes",42);       $emap[e_numbikes      ]='e_numbikes';
define("e_numbikes_w",45);     $emap[e_numbikes_w    ]='e_numbikes_w';
define("e_waiver_p",43);       $emap[e_waiver_p      ]='e_waiver_p';
define("e_trailer",46);        $emap[e_trailer       ]='e_trailer';

//event-specific:
define("e_image",23);          $emap[e_image         ]='e_image';
define("e_location",24);       $emap[e_location      ]='e_location';
define("e_child_friendly",25); $emap[e_child_friendly]='e_child_friendly';
define("e_adult_friendly",44); $emap[e_adult_friendly]='e_adult_friendly';
define("e_gsc",26);            $emap[e_gsc           ]='e_gsc';
define("e_eca",27);            $emap[e_eca           ]='e_eca';
define("e_spots_num",28);      $emap[e_spots_num     ]='e_spots_num';
define("e_rsvp_dt",30);        $emap[e_rsvp_dt       ]='e_rsvp_dt';
define("e_pay_dt",31);         $emap[e_pay_dt        ]='e_pay_dt';
define("e_adult_fee",32);      $emap[e_adult_fee     ]='e_adult_fee';
define("e_child_fee",33);      $emap[e_child_fee     ]='e_child_fee';
define("e_confirm_msg",35);    $emap[e_confirm_msg   ]='e_confirm_msg';
define("e_full_msg",36);       $emap[e_full_msg      ]='e_full_msg';
define("e_fee_varies",408);    $emap[e_fee_varies    ]='e_fee_varies';
define("e_flextext_1",101);    $emap[e_flextext_1    ]='e_flextext_1';
define("e_flextext_2",102);    $emap[e_flextext_2    ]='e_flextext_2';
define("e_flextext_3",103);    $emap[e_flextext_3    ]='e_flextext_3';
define("e_flextext_4",104);    $emap[e_flextext_4    ]='e_flextext_4';
define("e_flextext_5",105);    $emap[e_flextext_5    ]='e_flextext_5';
define("e_flextext_6",106);    $emap[e_flextext_6    ]='e_flextext_6';
define("e_flextext_7",107);    $emap[e_flextext_7    ]='e_flextext_7';
define("e_flextext_8",108);    $emap[e_flextext_8    ]='e_flextext_8';
define("e_flextext_9",109);    $emap[e_flextext_9    ]='e_flextext_9';
define("e_flextext_10",110);    $emap[e_flextext_10    ]='e_flextext_10';
define("e_flextext_11",111);    $emap[e_flextext_11    ]='e_flextext_11';
define("e_flextext_12",112);    $emap[e_flextext_12    ]='e_flextext_12';
define("e_flextext_13",113);    $emap[e_flextext_13    ]='e_flextext_13';
define("e_flextext_14",114);    $emap[e_flextext_14    ]='e_flextext_14';
define("e_flextext_15",115);    $emap[e_flextext_15    ]='e_flextext_15';
define("e_flexcb_1",201);      $emap[e_flexcb_1      ]='e_flexcb_1';
define("e_flexcb_2",202);      $emap[e_flexcb_2      ]='e_flexcb_2';
define("e_flexcb_3",203);      $emap[e_flexcb_3      ]='e_flexcb_3';
define("e_flexcb_4",204);      $emap[e_flexcb_4      ]='e_flexcb_4';
define("e_flexcb_5",205);      $emap[e_flexcb_5      ]='e_flexcb_5';
define("e_atext_1",301);       $emap[e_atext_1       ]='e_atext_1';
define("e_atext_2",302);       $emap[e_atext_2       ]='e_atext_2';
define("e_atext_3",303);       $emap[e_atext_3       ]='e_atext_3';
define("e_atext_4",304);       $emap[e_atext_4       ]='e_atext_4';
define("e_atext_5",305);       $emap[e_atext_5       ]='e_atext_5';
define("e_abox_1",401);        $emap[e_abox_1        ]='e_abox_1';
define("e_abox_2",402);        $emap[e_abox_2        ]='e_abox_2';
define("e_abox_3",403);        $emap[e_abox_3        ]='e_abox_3';
define("e_abox_4",404);        $emap[e_abox_4        ]='e_abox_4';
define("e_abox_5",405);        $emap[e_abox_5        ]='e_abox_5';
define("e_shorturl",406);      $emap[e_shorturl      ]='e_shorturl';
define("e_isfamily",407);      $emap[e_isfamily      ]='e_isfamily';

// Currently unused:
define("e_followup_msg",34);   $emap[e_followup_msg  ]='e_followup_msg';
define("e_internal_notes",37); $emap[e_internal_notes]='e_internal_notes';

// Added Options
define("e_restrict",51);   $emap[e_restrict]='e_restrict';
define("e_opendate",53); $emap[e_opendate]='e_opendate';
define("e_opentime",54); $emap[e_opentime]='e_opentime';
// define("e_guest_friendly",55); $emap[e_guest_friendly]='e_guest_friendly';
// define("e_guest_fee",56); $emap[e_open_time]='e_guest_fee';
// define("e_email_confirmation",57); $emap[e_email_confirmation]='e_email_confirmation';
define("e_hidden",58); $emap[e_hidden]='e_hidden';


// Restrict Options
$restrict_opt=array();
define("restrict_none",0);        $restrict_opt[restrict_none]='No restrictions (Anyone can sign up)';
define("restrict_mit",1);         $restrict_opt[restrict_mit]='On-campus or MIT certificates required';
define("restrict_eastgate",2);    $restrict_opt[restrict_eastgate]='Computers within Westgate only (Not recommended)';


// Other options to add:
// Extras that cost money, Limits on adults per apt.
// check on previous apt sign-ups also.



// Each Participant has the following fields:
$pmap=array();
define("p_id",501);               $pmap[p_id]='p_id';
define("p_cookie",502);           $pmap[p_cookie]='p_cookie';
define("p_name",503);             $pmap[p_name]='p_name';
define("p_email",504);            $pmap[p_email]='p_email';
define("p_apt",505);              $pmap[p_apt]='p_apt';
define("p_resp_dt",506);          $pmap[p_resp_dt]='p_resp_dt';
define("p_adult_num",507);        $pmap[p_adult_num]='p_adult_num';
define("p_child_num",508);        $pmap[p_child_num]='p_child_num';
define("p_paid",509);             $pmap[p_paid]='p_paid';
define("p_paid_dt",513);          $pmap[p_paid_dt]='p_paid_dt';
define("p_waitlist",510);         $pmap[p_waitlist]='p_waitlist';
define("p_waitcount",511);        $pmap[p_waitcount]='p_waitcount';
define("p_comments",512);         $pmap[p_comments]='p_comments';
define("p_flextext_1",601);       $pmap[p_flextext_1]='p_flextext_1';
define("p_flextext_2",602);       $pmap[p_flextext_2]='p_flextext_2';
define("p_flextext_3",603);       $pmap[p_flextext_3]='p_flextext_3';
define("p_flextext_4",604);       $pmap[p_flextext_4]='p_flextext_4';
define("p_flextext_5",605);       $pmap[p_flextext_5]='p_flextext_5';
define("p_flextext_6",606);       $pmap[p_flextext_6]='p_flextext_6';
define("p_flextext_7",607);       $pmap[p_flextext_7]='p_flextext_7';
define("p_flextext_8",608);       $pmap[p_flextext_8]='p_flextext_8';
define("p_flextext_9",609);       $pmap[p_flextext_9]='p_flextext_9';
define("p_flextext_10",610);       $pmap[p_flextext_10]='p_flextext_10';
define("p_flextext_11",611);       $pmap[p_flextext_11]='p_flextext_11';
define("p_flextext_12",612);       $pmap[p_flextext_12]='p_flextext_12';
define("p_flextext_13",613);       $pmap[p_flextext_13]='p_flextext_13';
define("p_flextext_14",614);       $pmap[p_flextext_14]='p_flextext_14';
define("p_flextext_15",615);       $pmap[p_flextext_15]='p_flextext_15';
define("p_flexcb_1",701);         $pmap[p_flexcb_1]='p_flexcb_1';
define("p_flexcb_2",702);         $pmap[p_flexcb_2]='p_flexcb_2';
define("p_flexcb_3",703);         $pmap[p_flexcb_3]='p_flexcb_3';
define("p_flexcb_4",704);         $pmap[p_flexcb_4]='p_flexcb_4';
define("p_flexcb_5",705);         $pmap[p_flexcb_5]='p_flexcb_5';
define("p_atext_1",801);          $pmap[p_atext_1]='p_atext_1';
define("p_atext_2",802);          $pmap[p_atext_2]='p_atext_2';
define("p_atext_3",803);          $pmap[p_atext_3]='p_atext_3';
define("p_atext_4",804);          $pmap[p_atext_4]='p_atext_4';
define("p_atext_5",805);          $pmap[p_atext_5]='p_atext_5';
define("p_abox_1",901);           $pmap[p_abox_1]='p_abox_1';
define("p_abox_2",902);           $pmap[p_abox_2]='p_abox_2';
define("p_abox_3",903);           $pmap[p_abox_3]='p_abox_3';
define("p_abox_4",904);           $pmap[p_abox_4]='p_abox_4';
define("p_abox_5",905);           $pmap[p_abox_5]='p_abox_5';

/*===== Specific to Bike Registration Page ========*/
$brmap=array();

define("br_id",1);           $brmap[br_id]='br_id';
define("br_date",11);        $brmap[br_date]='br_date';
define("br_name",21);        $brmap[br_name]='br_name';
define("br_email",22);       $brmap[br_email]='br_email';
define("br_apt",23);         $brmap[br_apt]='br_apt';
define("br_phone",24);       $brmap[br_phone]='br_phone';
define("br_reg",31);         $brmap[br_reg]='br_reg';
define("br_cookie",41);      $brmap[br_cookie]='br_cookie';

/*======= Specific to Sports Page ===============*/
$spmap=array();

define("sp_id",1);           $spmap[sp_id]='sp_id';
define("sp_name",11);        $spmap[sp_name]='sp_name';
define("sp_email",12);       $spmap[sp_email]='sp_email';
define("sp_minnum_def",21);  $spmap[sp_minnum_def]='sp_minnum_def';
define("sp_maxnum_def",22);  $spmap[sp_maxnum_def]='sp_maxnum_def';
define("sp_hidden",31);      $spmap[sp_hidden]='sp_hidden';



$gamemap=array();

define("game_id",1);           $gamemap[game_id]='game_id';
define("game_name",11);        $gamemap[game_name]='game_name';
define("game_email",12);       $gamemap[game_email]='game_email';
define("game_auth",15);       $gamemap[game_auth]='game_auth';
define("game_sport",21);       $gamemap[game_sport]='game_sport';
define("game_type",25);       $gamemap[game_type]='game_type';
define("game_date",31);       $gamemap[game_date]='game_date';
define("game_enddate",32);       $gamemap[game_date]='game_date';
define("game_timestart",41);       $gamemap[game_timestart]='game_timestart';
define("game_timeend",42);       $gamemap[game_timeend]='game_timeend';
define("game_rsvp_dt",51);       $gamemap[game_rsvp_dt]='game_rsvp_dt';
define("game_rsvp_tm",52);       $gamemap[game_rsvp_tm]='game_rsvp_tm';
define("game_location",61);       $gamemap[game_location]='game_location';
define("game_skill", 63);         $gamemap[game_skill]='game_skill';
define("game_link",65);       $gamemap[game_link]='game_link';
define("game_minnum",71);  $gamemap[game_minnum]='game_minnum';
define("game_maxnum",72);  $gamemap[game_maxnum]='game_maxnum';
define("game_info",99);     $gamemap[game_info]='game_info';


$sports_skill=array();
define("skill_any",0);        $sports_skill[skill_any]='Any';
define("skill_beg",20);       $sports_skill[skill_beg]='Absolute Beginner (Played less than 10 times)';
define("skill_imp",40);       $sports_skill[skill_imp]='Improving Beginner (Played about 10-50 times)';
define("skill_int",60);       $sports_skill[skill_int]="Intermediate (Lost count how many times I've played, but probably >50)";
define("skill_adv",80);       $sports_skill[skill_adv]="Advanced (Come on then if you think you're 'ard enough!)";
define("skill_exp",100);      $sports_skill[skill_exp]="Unstoppable (I'd do it for a living if I weren't at MIT)";



$gpmap=array();

define("gp_id",1);           $gpmap[gp_id]='gp_id';
define("gp_name",11);        $gpmap[gp_name]='gp_name';
define("gp_email",12);       $gpmap[gp_email]='gp_email';
define("gp_date",21);        $gpmap[gp_date]='gp_date';
define("gp_code",31);        $gpmap[gp_code]='gp_code';
define("gp_stats",32);       $gpmap[gp_stats]='gp_stats';
define("gp_confirmed",41);   $gpmap[gp_confirmed]='gp_confirmed';






/*===========================================================================*/






//===========================================================================//
// Following is code specific to the BIKE CALENDAR                           //
//===========================================================================//

//===========================================================================//
// $m = read_monthly_events(..);
// $m[2][e_id]        3rd event's ID (Assume it's unique within a day)
// $m[2][e_date]      3rd event's date (Format is MM/DD/YYYY)
// - Events don't need to be in any specific order. Can sort them if you want.
// - cal_detail.php?r={b}&m={MM}&d={DD}&y={YYYY}&mode={add}
// - cal_detail.php?r={b}&m={MM}&d={DD}&y={YYYY}&mode={view}&id={someid}
//===========================================================================//

// Each EVENT has the following fields:
define("ev_id",0);
define("ev_date",1);
define("ev_start",2);
define("ev_startap",3);
define("ev_end",4);
define("ev_endap",5);
define("ev_title",6);
define("ev_desc",7);
define("ev_location",8);
define("ev_fee",9);
define("ev_org_name",10);
define("ev_org_email",11);
define("ev_org_phone",12);
define("ev_link",13);
define("ev_image",14);
define("ev_map",15);
define("ev_child_friendly",16);
define("ev_adult_friendly",44);
define("ev_gsc",17);
define("ev_spots_num",18);
define("ev_volunteers_num",19);
define("ev_rsvp_dt",20);
define("ev_pay_dt",21);
define("ev_disclaimer_msg",22);
define("ev_init_msg",23);
define("ev_followup_msg",24);
define("ev_confirm_msg",25);
define("ev_full_msg",26);
define("ev_internal_notes",27);
define("ev_reminder_dts",28);

// Web Show/Hide constants
define('cfg_shw_id',1);
define('cfg_shw_date',2);
define('cfg_shw_time',3);
define('cfg_shw_title',4);
define('cfg_shw_desc',5);
define('cfg_shw_link',6);
define('cfg_shw_name',7);
define('cfg_shw_ph_email',8);
define('cfg_shw_apt',9);
define('cfg_shw_mgr',10);
define('cfg_shw_crd',11);
define('cfg_shw_stereo',12);
define('cfg_shw_alcohol',13);
define('cfg_shw_stereo_p',14);
define('cfg_shw_alcohol_p',15);
define('cfg_shw_reserve_p',16);
define('cfg_shw_deposit_p',17);
define('cfg_shw_allday',18);
define('cfg_shw_numbikes',19);
define('cfg_shw_waiver_p',20);

// This is the default options.
// (Note: if a option isn't in this array, then it means TRUE).
$cfg = array(
 cfg_shw_desc=>false ,     cfg_shw_apt=>false ,
 cfg_shw_alcohol=>false,   cfg_shw_alcohol_p=>false,
 cfg_shw_stereo=>false,    cfg_shw_stereo_p=>false,
 cfg_shw_deposit_p=>false, cfg_shw_link=>false,
 cfg_shw_mgr=>false,       cfg_shw_crd=>false,
 cfg_shw_ph_email=>false,  cfg_shw_allday=>false,
 cfg_shw_time=>false,
 cfg_shw_waiver_p=>true,   cfg_shw_reserve_p=>true
);

//===========================================================================//
// check($field)                                                             //
// Eg. if (check(cfg_shw_title)) { echo 'Title'; }                           //
//===========================================================================//

function check($f)
 {
  global $cfg; if (array_key_exists($f,$cfg)) return $cfg[$f]; return true;
 }

//===========================================================================//
// print_month($month)
//===========================================================================//

function print_month($m)
 {
  switch ($m)
   {
    case  1: return "January";
    case  2: return "February";
    case  3: return "March";
    case  4: return "April";
    case  5: return "May";
    case  6: return "June";
    case  7: return "July";
    case  8: return "August";
    case  9: return "September";
    case 10: return "October";
    case 11: return "November";
   }
  return "December";
 }

//===========================================================================//
// get_monthly_events($mm, $yyyy)                                            //
//===========================================================================//

function get_monthly_events($m,$y)
 {
  $m=0+$m; $y=0+$y; return mit_read('bike.'.mit_pad4($y).mit_pad2($m).'.db');
 }

//===========================================================================//
// print_event()                                                             //
//===========================================================================*/

function print_event($x,$m,$d,$y) {
  global $mit_rand,$mit_url;
  $d=mit_pad2($d); $m=mit_pad2($m); $y=mit_pad4($y);

  if (check(cfg_shw_name))       // { echo 'Name: ',$x[e_name],'<br>';}
     echo '<a href="https://',$mit_url,'cal_detail.php?mode=view&z=',$mit_rand
     ,'&lb=b&m=',$m,'&d=',$d,'&y=',$y
     ,'&id=',$x[e_id],'">&nbsp;',htmlspecialchars($x[e_name])
     ,"&nbsp;</a><br>\n";

  if (check(cfg_shw_numbikes))
   {
     if ($x[e_trailer] == 'Y') $trailertxt = "T"; else $trailertxt = "";
     if ($x[e_numbikes] > 0) $bikesmtxt = htmlspecialchars($x[e_numbikes])."M "; else $bikesmtxt = "";
     if ($x[e_numbikes_w] > 0) $bikeswtxt = htmlspecialchars($x[e_numbikes_w])."W "; else $bikeswtxt = "";
     echo "Bikes: <b>".$bikesmtxt.$bikeswtxt.$trailertxt."</b><br>\n";
   }
}

//===========================================================================//
// print_val($ev $x) : For Use for the LOUNGE or BIKE calendar event object  //
// $ev   => the event object                                                 //
// $x    => the attribute for which to print the value                       //
// $mode => add, edit, or view                                               //
//===========================================================================//

function print_val($ev,$x)
 {
  global $emap,$mit_numbikes,$mit_numbikes_w,$mit_numtrailers;
  if (array_key_exists($x,$ev)) $val=htmlspecialchars($ev[$x]); else $val='';
  $mode = mit_getpost('mode');
  $str = $emap[$x];
  if ('view'==$mode)
   {
    if (e_alcohol==$x   || e_crd==$x
     || e_stereo==$x    || e_mgr==$x
     || e_alcohol_p==$x || e_stereo_p==$x
     || e_deposit_p==$x || e_waiver_p==$x
     || e_reserve_p==$x || e_allday==$x
     || e_trailer==$x)
     { if ($val=='on' || $val=='Y') $val='yes'; else $val='no'; }
    if (e_start==$x || e_end==$x) $val=substr($val,0,2).':'.substr($val,2,2);
    echo $val; return;
   }
  if ('edit'==$mode) { $id=mit_getpost('id'); if ($id=='') return; }
  else if ('add'==$mode) $val=''; else return;
  switch ($x)
   {
    case e_alcohol:   case e_crd:
    case e_stereo:    case e_mgr:
    case e_alcohol_p: case e_stereo_p:
    case e_deposit_p: case e_waiver_p:
    case e_reserve_p: case e_allday:
    case e_trailer:
       $tag='"'; if ($val=='on' || $val=='Y') $tag='" checked';
       echo '<input name="',$str,$tag," value=\"Y\" type=\"checkbox\">";return;
    case e_desc:
       echo '<textarea name="',$str,'" rows=3 cols=28 wrap=soft>'
       ,$val,'</textarea>'; return;
    case e_notes:
       echo '<textarea name="',$str,'" rows=2 cols=90 wrap=soft>'
       ,$val,'</textarea>'; return;
    case e_start: case e_end:
       $tag = '<select name="'.$str.'">';
       if ('add'==$mode )
          $tag=$tag.'<option value="----" SELECTED>----';
       if ('edit'==$mode && '----'==$val)
          $tag=$tag.'<option value="----" SELECTED>----';
       for($i=1;$i<=12;$i++)
         for($j=0;$j<=45;$j=$j+15)
          {
           $tag=$tag.'<option value="'.mit_pad2($i).mit_pad2($j).'"';
           if ($val==mit_pad2($i).mit_pad2($j)) $tag=$tag.' SELECTED';
           $tag=$tag.'>'.mit_pad2($i).':'.mit_pad2($j);
          }
       echo $tag,'</select>'; return;
    case e_numbikes:
       $tag='<select name="'.$str.'">';
       for($i=0;$i<=$mit_numbikes;$i++)
        {
         $tag=$tag.'<option value="'.$i.'"';
         if($val==$i) $tag=$tag.' SELECTED';
         $tag=$tag.'>'.$i;
        }
        echo $tag,'</select>'; return;
    case e_numbikes_w:
       $tag='<select name="'.$str.'">';
       for($i=0;$i<=$mit_numbikes_w;$i++)
        {
         $tag=$tag.'<option value="'.$i.'"';
         if($val==$i) $tag=$tag.' SELECTED';
         $tag=$tag.'>'.$i;
        }
        echo $tag,'</select>'; return;
    case e_startap: case e_endap:
       $tag='<select name="'.$str.'">';
       if ('add'==$mode ) { $tag=$tag.'<option value="----" SELECTED>----'; }
       $tag=$tag.'<option value="AM"'; if($val=='AM') $tag=$tag.' SELECTED';
       $tag=$tag.'>AM<option value="PM"'; if($val=='PM') $tag=$tag.' SELECTED';
       echo $tag,'>PM</select>'; return;
    }
  echo '<input name="',$str,'" value="',$val,'" type="text" size="30">';
 }

//===========================================================================//
// save_event($id,$m,$d,$y)                                                  //
//===========================================================================//

function save_event($id,$m,$d,$y)
 {
  $m=mit_pad2($m); $d=mit_pad2($d); $y=mit_pad4($y);
  $id=0+$id; if ($id>0) $myid=$id; else $myid=mit_new_id();

  // Read the posted values
  $e_arr = array(
   e_id        => $myid
  ,e_date      => $m.'/'.$d.'/'.$y
  ,e_resource  => mit_getpost('e_resource')
  ,e_allday    => mit_getpost('e_allday')
  ,e_start     => mit_getpost('e_start')
  ,e_startap   => mit_getpost('e_startap')
  ,e_end       => mit_getpost('e_end')
  ,e_endap     => mit_getpost('e_endap')
  ,e_title     => mit_getpost('e_title')
  ,e_desc      => mit_getpost('e_desc')
  ,e_link      => ' '
  ,e_name      => mit_getpost('e_name')
  ,e_phone     => mit_getpost('e_phone')
  ,e_email     => mit_getpost('e_email')
  ,e_apt       => mit_getpost('e_apt')
  ,e_mgr       => mit_getpost('e_mgr')
  ,e_crd       => mit_getpost('e_crd')
  ,e_stereo    => mit_getpost('e_stereo')
  ,e_alcohol   => mit_getpost('e_alcohol')
  ,e_stereo_p  => mit_getpost('e_stereo_p')
  ,e_alcohol_p => mit_getpost('e_alcohol_p')
  ,e_deposit_p => mit_getpost('e_deposit_p')
  ,e_bgcolor   => mit_getpost('e_bgcolor')
  ,e_notes     => mit_getpost('e_notes')
  ,e_numbikes  => ($id<0 ? -1 : 0+mit_getpost('e_numbikes')) // -1 for blocked
  ,e_numbikes_w => mit_getpost('e_numbikes_w')
  ,e_trailer   => mit_getpost('e_trailer')
  ,e_reserve_p => ($id>0 ? mit_getpost('e_reserve_p') : '') // For security!
  ,e_waiver_p  => ($id>0 ? mit_getpost('e_waiver_p') : '')  // For security!
  );

  // Read the posted event values
  $ev_arr = array(
   ev_id             => $myid
  ,ev_date           => $m.'/'.$d.'/'.$y
  ,ev_start          => mit_getpost('ev_start')
  ,ev_startap        => mit_getpost('ev_startap')
  ,ev_end            => mit_getpost('ev_end')
  ,ev_endap          => mit_getpost('ev_endap')
  ,ev_title          => mit_getpost('ev_title')
  ,ev_desc           => mit_getpost('ev_desc')
  ,ev_link           => mit_getpost('ev_link')
  ,ev_org_name       => mit_getpost('ev_org_name')
  ,ev_org_phone      => mit_getpost('ev_org_phone')
  ,ev_org_email      => mit_getpost('ev_org_email') // so far, above 12 fields all the same as for calendar
  ,ev_location       => mit_getpost('ev_location')
  ,ev_image          => mit_getpost('ev_image')
  ,ev_map            => mit_getpost('ev_map')
  ,ev_child_friendly => mit_getpost('ev_child_friendly')
  ,ev_adult_friendly => mit_getpost('ev_adult_friendly')
  ,ev_gsc            => mit_getpost('ev_gsc')
  ,ev_spots_num      => mit_getpost('ev_spots_num')
  ,ev_volunteers_num => mit_getpost('ev_volunteers_num')
  ,ev_rsvp_dt        => mit_getpost('ev_rsvp_dt')
  ,ev_pay_dt         => mit_getpost('ev_pay_dt')
  ,ev_disclaimer_msg => mit_getpost('ev_disclaimer_msg')
  ,ev_init_msg       => mit_getpost('ev_init_msg')
  ,ev_followup_msg   => mit_getpost('ev_followup_msg')
  ,ev_confirm_msg    => mit_getpost('ev_confirm_msg')
  ,ev_full_msg       => mit_getpost('ev_full_msg')
  ,ev_internal_notes => mit_getpost('ev_internal_notes')
  ,ev_reminder_dts   => mit_getpost('ev_reminder_dts')  // array of dates
  );

  // Find the correct file
  $filename='bike.'.mit_pad4($y).mit_pad2($m).'.db';
  $events=mit_read($filename);

  if ($id<1) // add mode or block mode
   {
    // Push the posted values into the end of the existing DB content. Assume no sorting
    array_push($events,$e_arr);
    mit_write($events,$filename);
    $email_text=print_event_email($e_arr,$m,$d,$y);
    if ($id==0)
     {
      send_mail(
       'Eastgate Scripting','eastgate-cc@mit.edu', // sender name & email
       'eastgate-cc@mit.edu',                     // recipient email
       'Bike Reservation for '.($e_arr[e_numbikes]+$e_arr[e_numbikes_w]).' bike(s) on '.$e_arr[e_date].' (mm/dd/yyyy)', // subject
       $email_text); // body
     }
    return;
   }

  // edit mode
  for($i=0;$i<count($events);$i++)
    if($id==$events[$i][e_id])
      {$events[$i]=$e_arr; mit_write($events,$filename); return;}
 }

//===========================================================================//
// print_event_email($x,$m,$d,$y)   // $x is the i-th event of the month     //
//===========================================================================//

function print_event_email($x,$m,$d,$y) {
  if ($x[e_trailer] == "Y") $traileryn = "Yes"; else $traileryn = "No";
  $str = '<html><head><title>Email</title></head><body>';
  $str = $str. "<table border=2 cellpadding=2 cellspacing=2>";
  $str = $str. "<tr><td><b>Book Date (mm/dd/yyyy):</b></td>\n<td>".htmlspecialchars($x[e_date])."</td></tr>\n";
  $str = $str. "<tr><td><b>Name:</b></td>\n<td>".htmlspecialchars($x[e_name])."</td></tr>\n";
  $str = $str. "<tr><td><b>Apartment:</b></td>\n<td>".htmlspecialchars($x[e_apt])."</td></tr>\n";
  $str = $str. "<tr><td><b>Phone:</b></td>\n<td>".htmlspecialchars($x[e_phone])."</td></tr>\n";
  $str = $str. "<tr><td><b>Email:</b></td>\n<td>".htmlspecialchars($x[e_email])."</td></tr>\n";
  $str = $str. "<tr><td><b># of bikes:</b></td>\n<td>".htmlspecialchars($x[e_numbikes])." Men's and ".htmlspecialchars($x[e_numbikes_w])." Women's </td></tr>\n";
  $str = $str. "<tr><td><b>Trailer:</b></td>\n<td>".$traileryn."</td></tr>\n";
  $str = $str. "<tr><td colspan=2><b>Comments:</b><br>&nbsp;\n<br>".htmlspecialchars($x[e_notes])."</td></tr>\n";
  $str = $str. "</table><hr>** The above email is automatically generated **<br>\n\n";
  $str = wordwrap($str,70,"\n ");
  $str = str_replace("\r\n","\n",$str);
  $str = str_replace("\n\r","\n",$str);
  $str = str_replace("\r","\n",$str);
  $str = str_replace("\n","\n ",$str);
  return $str;
}

//===========================================================================//
// eval_val($ev $x)                                                          //
// $ev   => the event object                                                 //
// $x    => the attribute for which to print the value                       //
// $mode => add, edit, or view                                               //
//===========================================================================*/

function eval_val($ev, $x) {
  global $emap;
  if (array_key_exists($x,$ev)) { $val = htmlspecialchars($ev[$x]); } else { $val=''; }
  $mode = mit_getpost('mode');
  $str = $emap[$x];
  if ( 'view'==$mode ) {
    if ( e_start==$x || e_end==$x ) { $val = substr($val,0,2).':'.substr($val,2,2); }
    return $val;
  }
}

//===========================================================================//
// send_mail
//===========================================================================//

function send_mail($fromname, $fromaddress, $toaddress, $subject, $message, $replyto)
{
 $headers  = "MIME-Version: 1.0\n";
 $headers .= "Content-type: text/html; charset=\"UTF-8\"\n";
 $headers .= "From: \"".$fromname."\" <".$fromaddress.">";
 if (isset($replyto)) $headers .= "\nReply-To: \"".$fromname."\" <".$replyto.">";

 mail($toaddress, $subject, $message, $headers);
}

//===========================================================================//
// mit_postevent
// Posts an event to the Google Eastgate Events Calendar
// Assumes Timezone is -05:00  (not sure what happens in DST yet!)
//===========================================================================//

function mit_postevent($name, $location, $start_date, $start_time, $end_date, $end_time, $link) {

   global $mit_event_account, $mit_event_acpwd;

// This is a sample XML used as an entry into Google Calendar, taken from the google website
// Only the appropriate fields have been modified.

// Convert Date & Time to UTC -- No Longer Need this!
//                      but leave it in case something goes wrong near DST
//   if ($start_time == '') $start_time = "00:00";
//   if ($end_time == '') $end_time = "23:59";
//   $start_datetime = mit_utcdate($start_date,$start_time).'Z';
//   $end_datetime = mit_utcdate($end_date,$end_time).'Z';


   $start_datetime = "startTime='".$start_date;
   if (($end_date != '') and ($end_date != $start_date))
    $end_datetime = "endTime='".$end_date;
   if (($end_datetime == '') and ($end_time != ''))
    $end_datetime = "endTime='".$start_date;

   if ($start_time != '') $start_datetime=$start_datetime.'T'.$start_time.":00";
   if ($end_time != '') $end_datetime = $end_datetime.'T'.$end_time.":00";

   $start_datetime = $start_datetime."'";
   if ($end_datetime != '') $end_datetime = $end_datetime."'";

   $entry = "<?xml version='1.0' ?>
	<entry xmlns='http://www.w3.org/2005/Atom' xmlns:gd='http://schemas.google.com/g/2005'>
	  <category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/g/2005#event'></category>
	  <title type='text'>".$name."</title>
	  <content type='xhtml'>
	  <div xmlns='http://www.w3.org/1999/xhtml'>For more details, 
          visit ".$link."</div>
	  </content>
	  <author>
		<name>Eastgate Community Association Event Posting</name>
		<email>$mit_event_account</email>
	  </author>
	  <gd:transparency value='http://schemas.google.com/g/2005#event.transparent'>
	  </gd:transparency>
	  <gd:eventStatus value='http://schemas.google.com/g/2005#event.confirmed'>
	  </gd:eventStatus>
	  <gd:where valueString='".$location."'></gd:where>
	  <gd:when ".$start_datetime." ".$end_datetime."></gd:when>
	</entry>";

   $result = mit_google_calpost($mit_event_account, $mit_event_acpwd, "Eastgate Scripting", $entry);

   return $result;

}


// Converts a Date/Time of form YYYY-MM-DD & HH:MM
// to the UTC equivalent. Returns a string YYYY-MM-DDTHH:MM:00
// Required for posting to Google Calendar

function mit_utcdate($date, $time)
 {
  $year = substr($date,0,4);
  $mon = substr($date,5,2);
  $day = substr($date,8,2);
  $hour = substr($time,0,2);
  $min = substr($time,3,2);

  $timestamp = mktime($hour, $min, 0, $mon, $day, $year);
  
  $newdate = gmdate("Y-m-d", $timestamp)."T".gmdate("H:i", $timestamp).":00";

  return $newdate;

 }

function mit_google_calpost($emailAddr, $passwd, $appName, $anEntry) {

/*
    Based on the original API for Google Calendar, released 19 April 2006
    And available at http://code.google.com/apis/gdata/calendar.html
	
    Copyright (C) Mark D. Pesce, 2006
	mpesce AT gmail DOT com
	
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

*/

	// We need to login to Google first, with this URL
	$calUrl = "https://www.google.com/accounts/ClientLogin";
	
	// Now let's create the POST data
	// This is an HTTPS request, so the password is NOT sent in the clear.
	$postData = urlencode("Email") . "=" . urlencode($emailAddr) . "&";
	$postData = $postData . urlencode("Passwd") . "=" . urlencode($passwd) . "&";
	$postData = $postData . urlencode("source") . "=" . urlencode($appName) . "&";
	$postData = $postData . urlencode("service") . "=" . urlencode("cl");
	
	error_reporting(E_ALL);
	
	// The POST URL and parameters
	$request =  $calUrl;
	$postargs = $postData;
	
	// Get the curl session object
	$session = curl_init($request);
	
	// Set the POST options.
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
	curl_setopt($session, CURLOPT_HEADER, true);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	
	// Do the POST and then close the session
	$response = curl_exec($session);
	curl_close($session);
	
	// Get HTTP Status code from the response
	$status_code = array();
	preg_match('/\d\d\d/', $response, $status_code);
	
	// Check for errors
	if ( $status_code[0] != 200 ) {		// Did we have a successful login?
		return false;					// If not, then we've failed.
	}
	
	// We should have an authorization string returned by the transaction
	// This has to be supplied in the HTTP headers of both subsequent transactions.
	// We'll pull it out, and assign it to a variable.
	$authPos = strpos($response, "Auth=");
	$authStr = substr($response, $authPos + strlen("Auth="));
	$authStr = substr($authStr, 0, strlen($authStr)-1);
	
	// OK we've authenticated ourselves to Google Calendar.
	// The second stage of the operation is a POST
	// This will return a session ID that we can use in the final POST - with the same data!
	// Google will reply with a 302 REDIRECT code, which we can basically ignore.
	// All we really want is that session ID.
	
	// The POST URL and parameters
	$newUrl =  "http://www.google.com/";		// Base URL for communication with Google - strangely enough.
	$page = "/calendar/feeds/default/private/full"; // We're building our own headers, so we need to break this out
	$post_string = $anEntry;					// We must supply the XML calendar data on both this transaction and the following one.
	
	// We make everything up by hand, because it makes cURL happy.
	// This code was "borrowed" from the PHP website.
	// And I'm very thankful for it.
	// So we create the headers the old fashioned way - as a string.
	$header  = "POST ".$page." HTTP/1.0 \n";
	$header .= "Content-type: application/atom+xml\n";
	$header .= "Content-length: " . strlen($post_string) . " \n";
	$header .= "Authorization: GoogleLogin auth=" . $authStr . "\n";  // Here's where we provide the authorization data we got in the last transaction
	$header .= "Content-transfer-encoding: text\n\n";
	$header .= $post_string;  // And finally, we supply the XML data we want to add to Google Calendar
	
	// Initialize the cURL call to ensure we get lots of control over the request header.
	// Because we've built the request header by hand, it's a bit more intricate.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$newUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);		// It seems wise to give Google long timeout values.
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $header);  // And here's where we supply the custom headers
	
	// Make the call to the cURL library, and examine the results
	$newResponse = curl_exec($ch);        
	if (curl_errno($ch)) {
	   return false;			// If cURL exploded, we fail
	} else {
		$new_replies = curl_getinfo($ch);
		$new_status_code = $new_replies["http_code"];		// We should get a 302 REDIRECT reply code
	}
	curl_close($ch);
	if ($new_status_code != 302) {		// Did we get the proper reply code?
		return false;					// If not, something went wrong, so abort.
	}
	
	// Get the session ID, which is passed back in the reply headers
	$sessionStr = substr($newResponse, strpos($newResponse, "?gsessionid="));
	$sessionStr = substr($sessionStr, 0, (strpos($sessionStr, "\n")-1));
	
	// And now, let's do it ALL OVER AGAIN, with FEELING.
	// For the third part of this transaction, we do exactly what we did in the second part of the transaction
	// But this time we provide the session ID we got from the last transaction.
	// Does anyone know why we need to go through this second step?  We're _already_ authenticated...
	$finalUrl =  "http://www.google.com/";		// As before
	$page = "/calendar/feeds/default/private/full" . $sessionStr;  // The new page, with the session ID appended to it
	
	// Once again, we hand-craft the headers passed in the HTTP transaction.
	// They are, however,  the same as last time, with the exception of the added session ID.
	$header  = "POST ".$page." HTTP/1.0 \n";
	$header .= "Content-type: application/atom+xml\n";
	$header .= "Content-length: " . strlen($post_string) . " \n";
	$header .= "Authorization: GoogleLogin auth=" . $authStr . "\n";
	$header .= "Content-transfer-encoding: text\n\n";
	$header .= $post_string;
	
	// And, now, let's setup the cURL call.
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL,$finalUrl);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_TIMEOUT, 15);			// Make it nice and long in case Google burps.
	curl_setopt($ch2, CURLOPT_HEADER, true);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $header);
	
	// The response returned by this call is actually chock-full of XML data
	// Which you could choose to parse for your own needs.
	// We're just dropping it onto the floor here.
	// But you could do something with it.  If you wanted to.
	$newResponse2 = curl_exec($ch2);        
	if (curl_errno($ch2)) {		// Did cURL throw an error?
	   return false;			// Then we failed.  So close, yet so far.  
	} else {
		$new_replies2 = curl_getinfo($ch2);
		$new_status_code2 = $new_replies2["http_code"];	// Get the reply code
	}
	curl_close($ch2);
	
	// The status code should be 201 CREATED
	// If there are problems with your XML, you'll probably throw a 400 INVALID or something like that
	// So you may want to add debugging here, to understand what's not working, if it's not working.
	if ($new_status_code2 != 201) {		// Did we create the entry?
		return false;
	}
	return true;
}


// A function to send an e-mail informing players that the game is OFF again.
// Number has dropped below minimum. - ACC 9/11/06

function mit_sendemail_gameoff($curgame, $mit_part, $mit_sports)
 {
  global $mit_url, $mit_sports_prefix, $mit_sports_sendername, $mit_filter, $mit_sportfilter;

  if (($curgame[game_minnum] > count($mit_part)) && (count($mit_part) > 0))
   {

    $s = -1;
    for($i=0;$i<count($mit_sports);$i++)
     {
      if (mit_g($mit_sports[$i],sp_id)==$curgame[game_sport]) $s = $i;
     }

    if ($s < 0) return;
 
    $game_datetime = $str.mit_formatdate(0,$curgame[game_rsvp_tm],"g:i A").' on '.mit_easydate(mit_systime($curgame[game_rsvp_dt],$curgame[game_rsvp_tm]));

    $sport_name = mit_gp($mit_sports[$s],sp_name);


    // Send an e-mail to all participants

    $str = '<html><head><title>Email</title></head><body>';
    $str = $str."The <b>".$sport_name."</b> game has been <b>SUSPENDED</b> until sufficient players sign up. If this happens before ".$game_datetime;
    $str = $str." the game will be back on and you will receive a follow-up e-mail.<p>";
    $str = $str."<b>When:</b> ".mit_easydate(mit_systime($curgame[game_date],$mit_new[game_timestart]));
    $str = $str." from ".mit_formatdate(0,$curgame[game_timestart],"g:i A")." until ";
    $str = $str.mit_formatdate(0,$curgame[game_timeend],"g:i A")."<br>";
    $str = $str."<b>Where:</b> ".$curgame[game_location]."<p>";
    $str = $str." You can check the status of the game at any time by clicking <a href='http://".$mit_url."sports.php?filter=".$mit_filter."'>here</a> or by visiting to the <b>Sports Sign-Up Page</b>";
    if ($mit_filter==$mit_sportfilter) $str = $str." on the Eastgate Website";
    $str = $str.".<p>";

    $str = $str."Reply to this e-mail if you have any questions about the game<p>";
    $str = $str."**This is an automatically generated e-mail**<br></body></html>";
    $str = wordwrap($str,70,"\n ");
    $str = str_replace("\r\n","\n",$str);
    $str = str_replace("\n\r","\n",$str);
    $str = str_replace("\r","\n",$str);
    $str = str_replace("\n","\n ",$str);

    $email_text = $str;   

    $part_emaillist = "";
    for($i=0;$i<count($mit_part);$i++)
     {
      if ($part_emaillist != '') $part_emaillist = $part_emaillist.',';
      $part_emaillist = $part_emaillist.(mit_g($mit_part[$i],gp_email));
     }

    send_mail(
       $mit_sports_sendername,$curgame[game_email], // sender name & email
       $part_emaillist,             // recipient email
       $mit_sports_prefix." ".$sport_name." game SUSPENDED" , // subject
       $email_text);    // body

   }
 } 





// Make sure there are no SPACES or NEWLINES after the PHP Closing Tag below.
// Otherwise, redirect() command will fail, due to output-already-in-progress.
?>
