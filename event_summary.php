<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

// If user clicked "Create New Event", then go to https://.../event_create.php

// Read the database, then sort it by DATE
mit_lock(); $mit_events=mit_read('event.db'); mit_unlock();
$mit_cmp=e_date;
usort($mit_events,'mit_cmp_date');


// A helper function to display 1 single event
function mit_print_event($e)
 {
  global $mit_rand;
#  echo "\n<b><a target='_top' style=\"text-decoration:none\" href=\"event.php?#Event",
   echo "\n<b><a target='_top' style=\"text-decoration:none\" href=\"event_view.php?t=",
    $mit_rand,"&eid=",
    mit_gg($e,e_id),"\">",mit_gg($e,e_title),"</a></b>\n";
  if (mit_g($e,e_date)==mit_g($e,e_enddate))
     echo '(',mit_shortdate($e,e_date),")<br>\n";
  else
     echo '(',mit_shortdate($e,e_date)," - \n",mit_shortdate($e,e_enddate),")<br>\n";
 }

/*=========================================================================*/?>

<html>
<head>
<title>Westgate Events</title>
</head>
<body>

<p>
<table border=0 cellspacing=0 cellpadding=5 width="100%">
<td style="width:100%;text-align:center;">
<?php
  $event_count = 0;
  $m=mit_convdate(date("m/d/Y"));
  $n=count($mit_events);
  for($i=$n-1;$i>=0;$i--)
   {
    $d=mit_g($mit_events[$i],e_date);
    $e=mit_g($mit_events[$i],e_enddate);
    $t=mit_g($mit_events[$i],e_title);  
    $h=mit_g($mit_events[$i],e_hidden);
    if ($e=='') { $e=$d; $mit_events[$i][e_enddate]=$e; }
    if ((mit_convdate($e)>=$m) and ($h==''))    // Future, un-hidden events only

     {
      if ((mit_convdate($e)-mit_convdate($d) < 7) and (!is_numeric(strpos($t,$mit_sporteventstr))))
        // Assume events that last more than 1 week are not single events
        // Also must not have string (e.g. IM in title
       {
        $event_count++;
        mit_print_event($mit_events[$i]);
       }
     }
   }
  if ($event_count < 1)
   {
   echo "\n<i>",
    '<a href="event.php" target="_top">There are currently no upcoming events that require sign-up.</a>',
    "</i>\n";
   }
?>
</td>
</table>
<p>

<?php
  $m=mit_convdate(date("m/d/Y"));
  $event_count = 0;
  $n=count($mit_events);
  for($i=$n-1;$i>=0;$i--)
   {
    $t=mit_g($mit_events[$i],e_title);
    $d=mit_g($mit_events[$i],e_date);
    $e=mit_g($mit_events[$i],e_enddate);
    $h=mit_g($mit_events[$i],e_hidden);

    if ($e=='') { $e=$d; $mit_events[$i][e_enddate]=$e; }
    if ((mit_convdate($e)-mit_convdate($d) >= 7) and (mit_convdate($e)-mit_convdate($d)<10000) and (mit_convdate($e)>=$m) and (!is_numeric(strpos($t,$mit_sporteventstr))) and ($h==''))
      // Assume events that last more than 1 week and less than 1 year are classes
      // Must also be in the future & not have (e.g.) 'IM' in title, or be hidden
     {
      if ($event_count == 0)
       {
        echo '<table border=0 cellpadding=0 cellspacing=0 style="width:100%;"><tr valign=top>',
             '<td style="width:100%;text-align:center;">',
             '<span style="font:28px arial; color:#993333">Classes</span><br></tr></table>',
             '<p><table border=0 cellspacing=0 cellpadding=5 width="100%"><td style="width:100%;text-align:center;">';
       }
      $event_count++;
      mit_print_event($mit_events[$i]);
     }
   }

  if ($event_count > 0) echo '</td></table><p>';
?>

<?php
  $m=mit_convdate(date("m/d/Y"));
  $event_count = 0;
  $n=count($mit_events);

  for($i=$n-1;$i>=0;$i--)
   {
    $d=mit_g($mit_events[$i],e_date);
    $e=mit_g($mit_events[$i],e_enddate);
    $h=mit_g($mit_events[$i],e_hidden);

    if ($e=='') { $e=$d; $mit_events[$i][e_enddate]=$e; }
    if ((mit_convdate($e)-mit_convdate($d) >= 10000) and (mit_convdate($e)>=$m) and ($h==''))     {
      // Assume events that last more than 1 year are continuing programs (must also be in future and unhidden)
      if ($event_count == 0)
       {
        echo '<table border=0 cellpadding=0 cellspacing=0 style="width:100%;"><tr valign=top>',
             '<td style="width:100%;text-align:center;">',
             '<span style="font:28px arial; color:#993333">Continuing Programs</span><br></tr></table>',
             '<p><table border=0 cellspacing=0 cellpadding=5 width="100%"><td style="width:100%;text-align:center;">';
       }
      $event_count++;
      echo "\n<b><a target='_top' style=\"text-decoration:none\" href=\"event_view.php?t=",
      $mit_rand, "&eid=",
       mit_gg($mit_events[$i],e_id),"\">",mit_gg($mit_events[$i],e_title),
       "</a></b><br>\n";
     }  
   }

  if ($event_count > 0) echo '</td></table><p>';
?>

</form>
</body>
</html>
