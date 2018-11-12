<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

// If user clicked "Create New Event", then go to https://.../event_create.php
if (mit_getpost('Create')!='') mit_gos('event_create.php');

// Read the database, then sort it by DATE
mit_lock(); $mit_events=mit_read('event.db'); mit_unlock();
$mit_cmp=e_date;
usort($mit_events,'mit_cmp_date');

// Do we want to show every event? Or just future events?
$a='current events only'; $b='All';
if (mit_getpost('All')!='') { $a='all events'; $b='Current'; }

// If an event organizer then show the hidden events also
$admin = (mit_cert_nonfatal($mit_eventusers)!='');

// A helper function to display 1 single event
function mit_print_event($e)
 {
  global $mit_rand;
  echo "<div class=\"panel panel-default\">";
  echo "\n<div class=\"panel-heading\"><h4><a name=\"Event",mit_gg($e,e_id),"\"></a>\n";
  echo "\n<a target=\"_parent\" href=\"event_view.php?t=",$mit_rand,
       '&eid=',mit_gg($e,e_id),'">',mit_gg($e,e_title),"</a></h4></div><div class=\"panel-body\"><ul>\n";
  if (mit_g($e,e_date)==mit_g($e,e_enddate))
     echo '<li><b>Date:</b> ',mit_gg($e,e_date),"<br>\n";
  else
     echo '<li><b>First Day:</b> ',mit_gg($e,e_date),"<br>\n",
     '<li><b>Last Day:</b> ',mit_gg($e,e_enddate),"<br>\n";
  $x=mit_gg($e,e_location);
  if ($x!='') echo '<li><b>Location:</b> ',$x,"<br>\n";
  if (mit_g($e,e_child_friendly)!='')
     echo "<li><b>Children-friendly?</b> Yes<br>\n";
  $x=mit_gg($e,e_adult_fee); if ($x=='') $x='none.';
  echo '<li><b>Fee:</b> ',$x,"<br>\n";
  $x=mit_gg($e,e_rsvp_dt);
  if ($x!='') echo '<li><b>Sign up by:</b> ',$x,"<br>\n";
  echo "</ul></div>\n";
  echo "</div>";
 }

/*=========================================================================*/
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Event Registration Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
</head>
<body>

<form method="get" action="event.php">

<div class="container">

<ol class="breadcrumb">
<li><a href="http://westgate.mit.edu">Home</a></li>
<li class="active"><a href="event.php">Westgate Events</a></li>
</ol>

<div class="page-header">
<h1>Welcome to Westgate Event Registration Page</h1>
<p class="lead">Please click on the event below that you'd like to attend:</p>
</div>

<div class="row" style="background-color: #DD6600;">
  <div class="col-md-6">
    <h4>Showing <?php echo $a;?></h4>
  </div>
  <div class="col-md-6 text-right" style="padding: 5px 0;">
    <input type=hidden name="t" value="<?php echo $mit_rand;?>">
    <input type=submit name="<?php echo $b;?>" value="Show <?php echo $b;?> Events">&nbsp;
    <input type=submit name="Create" value="Create New Event">&nbsp;
  </div>
</div>

<p>
<?php
  $m=mit_convdate(date("m/d/Y"));
  $n=count($mit_events);
  if ($n==0)
   {
    echo '<div style="font:bold 14px arial;text-align:left;width:100%;">',
    'There are currently no events ready for sign-up. ',
    'Please check back later!</div><hr align="left" width="80%">';
   }
  for($i=$n-1;$i>=0;$i--)
   {
    $d=mit_g($mit_events[$i],e_date);
    $e=mit_g($mit_events[$i],e_enddate);
    $h=mit_g($mit_events[$i],e_hidden);

     if ($admin) $h = '';
    if ($e=='') { $e=$d; $mit_events[$i][e_enddate]=$e; }
    if (('All'!=$b || mit_convdate($e)>=$m) && ($h==''))
     {
      mit_print_event($mit_events[$i]);
     }
   }
?>
</p>

</div>

</form>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
