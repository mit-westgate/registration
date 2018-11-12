<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

$mit_x=mit_cert_nonfatal($mit_movieusers);
$mit_v=mit_getpost('v');
$mit_a=mit_getpost('a');
$mit_vv=array();
$mit_w=array(); $mit_w[0]=''; // winner

$mit_e=""; if (array_key_exists('SSL_CLIENT_S_DN_Email',$_SERVER)) {$mit_e=$_SERVER['SSL_CLIENT_S_DN_Email'];}
$mit_n=""; if (array_key_exists('SSL_CLIENT_S_DN_CN',$_SERVER)) {$mit_n=$_SERVER['SSL_CLIENT_S_DN_CN'];}
if ($mit_e=='' || $mit_n=='') {$mit_e='';$mit_n='';}

function mit_dup($e)
 {
  global $mit_vv,$num_votes;
  for($i=0; $i<count($mit_vv); $i++)
   {
    if (strcasecmp($mit_vv[$i][2],$e)==0) $num_votes++;
	if ($num_votes>=10) return true;
   }
  return false;
 }

function mit_save_vote($v,$a,$e,$n)
 {
  global $mit_vv;
  $v=array($v,$a,$e,$n,date("Y/m/d H:i:s"));
  array_push($mit_vv,$v);
  mit_write($mit_vv,'vote.db');
  return true;
 }

function mit_display_current_votes()
 {
  global $mit_x,$mit_vv,$mit_rand;
  $x=array();
  for($i=0;$i<count($mit_vv);$i++)
   {
    array_push($x,$mit_vv[$i][0]);
   }
  $x=array_count_values($x);
  arsort($x,SORT_NUMERIC);
  echo '<ol style="padding-bottom:5px;">';
  foreach($x as $k => $v)
   {
    echo "<li>";
    if ($mit_x=='')
      echo "<a href=\"javascript:location.href='vote.php?v=",urlencode($k),
      "&t=",$mit_rand,"';\">";
    echo "<nobr><b>",htmlspecialchars($k),"</b></nobr>";
    if ($mit_x=='') echo "</a>";
    echo " (",$v;
    if ($v>1) {echo " votes)";} else {echo " vote)";}
    echo " <a target='_blank' href='http://www.imdb.com/find?s=tt&q=".$k."'><i>More Info</i></a>\n";
   }
  echo '</ol>';
 }

$z0=trim(mit_getpost('vote0'));
$z1=trim(mit_getpost('vote1'));
$z2=trim(mit_getpost('vote2'));
$z3=trim(mit_getpost('vote3'));
if ($z2=='') {$z2=$z3; $z3='';}
if ($z1=='') {$z1=$z2; $z2=$z3; $z3='';}
$zz='<b>The previous election ended on '.date('M d, Y').'</b>';
mit_lock();
$mit_vv = mit_read('vote.db');
$mit_w = mit_read('votewinner.db');
if ($mit_x!='')
 {
  if (mit_getpost('votec')!='')
   {
    $zz=$zz;
   }
  else if (mit_getpost('voteb')!='' && $z1!='' && $z2!='')
   {
    $zz=$zz.'There were multiple winners:'; $zzc='';
    $zza=htmlspecialchars($z1);
    if ($zza!='') {$zz=$zz.' '.$zzc.' <u><i>'.$zza.'</i></u>'; $zzc=',';}
    $zza=htmlspecialchars($z2);
    if ($zza!='') {$zz=$zz.' '.$zzc.' <u><i>'.$zza.'</i></u>'; $zzc=',';}
    $zza=htmlspecialchars($z3);
    if ($zza!='') {$zz=$zz.' '.$zzc.' <u><i>'.$zza.'</i></u>'; $zzc=',';}
    $zz=$zz.' .</ul>';
   }
  else if (mit_getpost('voteb')!='' && $z1!='')
   {
    $zz=$zz.'The winner was <u><i>'.htmlspecialchars($z1).'</i></u>.</ul>';
   }
  else if (mit_getpost('votea')!='' && $z0!='')
   {
    $zz=$zz.'The winner was <u><i>'.htmlspecialchars($z0).'</i></u>.</ul>';
   }
  else $zz='';
  if ($zz!='')
   {
    $mit_vv=array(); $mit_w=array(); $mit_w[0]=$zz;
    mit_write($mit_w,'votewinner.db'); mit_write($mit_vv,'vote.db');
    mit_go('vote.php?t='.$mit_rand);
   }
 }
if ($mit_v!='' && $mit_e!='' && $mit_a!='')
 {
  if (mit_dup($mit_e)) mit_go('votedup.php?t='.$mit_rand);
  mit_save_vote($mit_v,$mit_a,$mit_e,$mit_n); mit_go('voted.php?t='.$mit_rand);
 }
mit_unlock();

if ($mit_v!='')
 {
  echo "<html><head><script>",
  "function chk(){ if ((document.forms[\"main\"][\"a\"].value)==\"\")\n",
  "{alert('Please provide the apartment number!');return false;}\n",
  "return true;}\n",
  "</script></head><body>\n",
  "<form name=main onSubmit=\"return chk();\"\n",
  "method=\"get\" action=\"https://",$mit_url,"vote.php\">\n",
  "<input type=hidden name=t value=\"",htmlspecialchars($mit_rand),"\">\n",
  "<input type=hidden name=v value=\"",htmlspecialchars($mit_v),"\">\n",
  "<div style=\"border:solid; border-color:#000000;",
  "background:#ffd0d0;margin:2px;padding:10px;\">\n",
  "You've selected the following movie: <ul><li><B><font color=\"#10af10\">\n",
  htmlspecialchars($mit_v),
  "</font></B></ul><p>\n",
  "To vote, you will need to have your MIT web certificate.<P>\n",
  "<ul>",
    "<li>If you don't have your MIT web certificate yet, you can\n",
    "get it <a href=\"http://web.mit.edu/is/help/cert/\">HERE</a>.<p>\n",
    "<li>If you have your MIT web certificate ready, please input your<br>\n",
    "APARTMENT NUMBER here: <input name=a size=4 maxlength=4>,\n",
    "then click <input type=submit value=HERE> to cast your vote.",
  "</ul>",
  "To cancel your vote, please click ",
  "<a target=\"_top\" href=\"http://web.mit.edu/westgate/\">HERE</a> ",
  "to return to the Westgate web page.</div></form></body></html>";
  exit;
 }

?>

<html>

<head>
<title>Westgate Video Borrowing Service: Voting Page</title>
<style type="text/css">
<!--
body, th, td, div
 {
  vertical-align: top;
  font-family : Verdana, Arial, sans-serif;
  font-size : 10pt;
 }
-->
</style>
</head>

<body onContextMenu="return false;">
<form method="get" action="">
<input type="hidden" name="t" value="<?php echo $mit_rand;?>">
<h3>Welcome to Westgate Video Voting Page</h3>
<table border=1 cellpadding=2 cellspacing=0>
<tr><td bgcolor="#e0f0f0" width=750>

  <?php if ($mit_x=='') { ?>
  <b>Westgate has a small budget to buy additional videos.
  We would love you to suggest them!</b><br>
  <B><FONT SIZE=+2>VOTING IS CLOSED -- Current Cutoff is around 2 or 3 votes (around rank 25)!</FONT> <BR>
  Movies that have not been released yet will not be purchased (or pre-ordered), but will be given priority consideration for future funds.</B>
  <div style="background-color:#f0b0f0; margin:20px; border:2px solid black;">
  <ul>
    <li><b>Step 1:</b>
    Please fill out one of your suggestions, then click VOTE.<br>
    (Each apartment gets 10 votes).
    <br><input type="text" name="v" size=30 value="">
    <input name="submit" type="submit" value="Vote"> <br>(Leave out apostrophes, ', in movie titles.)
    <p>
    <li><b>Step 2:</b>
    Alternatively: you can look at what people have voted for so far.
    <br>Then click on the movie title to vote for the same movie (this 
	counts toward your apartment's 10 votes).
    <p>
    <li><b>Step 3:</b> At midnight on September 12, 2007, the voting period will 
	close and we'll purchase the movies with the most votes while taking 
	into account the price of each movie. We hope to purchase ~25 
	new movies with the available funds.
    
  </ul>
  </div>
  <?php } ?>

  <?php
    if (count($mit_vv)==0)
     {
      echo "<b>There are currently NO votes during this election.</b><p>";
     }
    else
     {
      echo "<b>The current tally is: ";
      if ($mit_x=='') echo "(If you click on a movie, you can vote for it)";
      echo "</b><div style=\"background-color:#f0b0f0; margin:20px; border:2px solid black;\">";
      mit_display_current_votes();
      echo '</div>';
      if ($mit_x!='')
       {
        echo '<b>As the administrator, you have 3 choices:</b><p>'

        ,'<div style="border:2px solid black; background-color:#f0b0f0; margin:20px; padding:10px;">'
        ,'(A) If there is a clear winner, then fill in the movie name below:<br>'
        ,'<input name=vote0>&nbsp;'
        ,'then press <input name=votea type=submit value="Elect One Winner">.</div>'

        ,'<div style="border:2px solid black; background-color:#f0b0f0; margin:20px; padding:10px;">'
        ,'(B) If there are ties, or if you wish to grant multiple winners, '
        ,'then fill in one or more names below:<br>'
        ,'<input name=vote1><br>'
        ,'<input name=vote2><br>'
        ,'<input name=vote3>&nbsp;'
        ,'then press <input name=voteb type=submit value="Elect Multiple Winners">.</div>'

        ,'<div style="border:2px solid black; background-color:#f0b0f0; margin:20px; padding:10px;">'
        ,'(C) If you wish to wipe out the entire election without any winner, '
        ,'<br>and start a new election, then press '
        ,'<input name=votec type=submit value="Erase All"></div>';
       }
     }
   echo $mit_w[0];
  ?>

  <b>If you have suggestions or questions, or if you have videos to donate</b>:

  <ul>
  <li>Please email: <a href="mailto:westgate-gc@mit.edu">westgate-gc@mit.edu</a>
  </ul>
  To return to the Westgate website,
  please click <a target="_top" href="http://web.mit.edu/westgate/">HERE</a>.
</td></tr>
</table>

<?
if ($mit_x!='')
 {
  echo "<br><a href='http://scripts-cert.mit.edu/~westgate/vote.php'>Return to the non-admin voting page</a><br><br>";
 }
else
 {
  echo '</form>'
  ,'<form method="get" action="https://'.$mit_url.'vote.php" name="mit_admin_vote">'
  ,'<td style="font:bold 14px arial;" align="right">'
  ,'<input type=submit value="Administrator Use Only">&nbsp;'
  ,'</td>'
  ,'</form>';
 }
?>

</body>
</html>
