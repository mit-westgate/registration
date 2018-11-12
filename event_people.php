<?php session_start();?>
<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8");

mit_lock();

$mit_eid = htmlspecialchars(mit_getpost('eid'));
$mit_all=mit_read('event.db');
for($i=0;;$i++)
 {
  if ($i>=count($mit_all)) mit_fail();
  if (mit_g($mit_all[$i],e_id)==$mit_eid) {$mit_main=$mit_all[$i];break;}
 }
mit_cert(mit_g($mit_main,e_auth));
$mit_part=mit_read('event.'.$mit_eid.'.db');
// BY now:
// $mit_main == the selected event object (based on the $mit_eid passed)
// $mit_part == all participants in event $mit_main
$mit_cmp=p_id; usort($mit_part,'mit_cmp_num');

if(mit_g($mit_main,e_shorturl)=='') {
    $mit_main[e_shorturl]=file_get_contents('http://westgate.scripts.mit.edu/PHP-URL-Shortener/shorten.php?longurl=' . urlencode('https://' . $_SERVER['SERVER_NAME']  . '/registration/event_view.php?eid='.$mit_eid));
}

$mit_sum = array();
    
    
function export_event(){
  global $mit_eid,$mit_main,$mit_part;
  $myfile = fopen("db/event.".$mit_eid.".xls", "w") or die("Unable to open file!");
  $txt="Name\t Email\t Apt\t";
  if(mit_g($mit_main,e_adult_friendly)!='')
    $txt .= "# Adults\t";
  if(mit_g($mit_main,e_child_friendly)!='')
    $txt .= "# Children\t";

  # the 15 questions
  for($k=1;$k<=15;$k++){
    if(mit_g($mit_main,e_flextext_1+($k-1))!='')
      $txt .= mit_gg($mit_main,e_flextext_1+($k-1))."\t";
  }
  # the 5 Yes/No questions
  for($k=1;$k<=5;$k++){
    if (mit_g($mit_main,e_flexcb_1+($k-1))!='')
      $txt .= mit_gg($mit_main,e_flexcb_1+($k-1))."\t";
  }
  
  # the 5 text labels
  for($k=1;$k<=5;$k++){
    if(mit_g($mit_main,e_atext_1+($k-1))!='')
      $txt .= mit_gg($mit_main,e_atext_1+($k-1))."\t";
  }

  # the 5 check box labels
  for($k=1;$k<=5;$k++){
    if (mit_g($mit_main,e_abox_1+($k-1))!='')
      $txt .= mit_gg($mit_main,e_abox_1+($k-1))."\t";
  }
  
  $txt .= "Paid\t Paid Date\t SignUp Date\t On Waiting List?\t Comments\n";
  fwrite($myfile, $txt);

  $txt ="";
  for ($k=0;$k<count($mit_part);$k++) {$txt .= export_participant($k,$mit_part[$k]); }
  fwrite($myfile, $txt);
  fclose($myfile);  
}
function export_participant($i,$p){
  global $mit_main,$mit_eid,$mit_rand,$mit_sum;
  $txt = "";
  $j=mit_gg($p,p_id);
  $txt .= mit_gg($p,p_name) ."\t";
  $txt .= mit_gg($p,p_email)."\t";
  $txt .= mit_gg($p,p_apt)  ."\t";

  if(mit_g($mit_main,e_adult_friendly)!='')
    $txt .= mit_g($p,p_adult_num)."\t";

  if(mit_g($mit_main,e_child_friendly)!='')
    $txt .= mit_g($p,p_child_num)."\t";

  # the 15 questions
  for($k=1;$k<=15;$k++){
    if(mit_g($mit_main,e_flextext_1+($k-1))!='')
      $txt .= mit_gg($p,p_flextext_1+($k-1))."\t"; 
  }

  # the 5 Yes/No questions
  for($k=1;$k<=5;$k++) {
    if(mit_g($mit_main,e_flexcb_1+($k-1))!=''){
      if(mit_g($p,p_flexcb_1+($k-1))!='')
        $txt .= "Yes\t"; 
      else
        $txt .= "No\t";
    }
  }
  # the 5 text labels
  for($k=1;$k<=5;$k++){
    if(mit_g($mit_main,e_atext_1+($k-1))!='')
      $txt .= mit_gg($p,p_atext_1+($k-1))."\t";
  }

  # the 5 check box labels
  for($k=1;$k<=5;$k++){
    if(mit_g($mit_main,e_abox_1+($k-1))!=''){
      if(mit_g($p,p_abox_1+($k-1))!='') 
        $txt .= "Yes\t"; 
      else
        $txt .= "No\t"; 
    }
  }

  #last five: paid, signup, waiting list, comments;
  if(mit_g($p,p_paid)!='') 
    $txt .= "Paid\t".mit_gg($p,p_paid_dt)."\t"; 
  else
   $txt .= "Not paid\t   \t"; 
  $txt .= mit_gg($p,p_resp_dt)."\t";
  if(mit_g($p,p_waitlist)!='') 
    $txt .= "Yes\t";
  else
    $txt .= "No\t";

  $txt .= mit_g($p,p_comments)."\t";

  return $txt."\n";
}
function print_participant($i,$p)
 {
  global $mit_main,$mit_eid,$mit_rand,$mit_sum;
  $j=mit_gg($p,p_id);
  mit_tr(" id=\"mit_row".$i."\"");
  echo "<td>",mit_gg($p,p_name),'&nbsp;</td>';
  echo "\n<td>",mit_gg($p,p_email),'<input type=hidden name="p_email__',$j,'" value="',mit_gg($p,p_email),'">&nbsp;</td>';
  echo "\n<td>",mit_gg($p,p_apt),'&nbsp;</td>';
     $person_row = array();

  if (mit_g($mit_main,e_adult_friendly)!='')
   {
    echo "\n<td>",'<input name="p_adult_num__',$j,'" size=4 value="',
    htmlspecialchars(0+mit_g($p,p_adult_num)),'"></td>';
       $person_row[] = 0+mit_g($p,p_adult_num);
   }
  if (mit_g($mit_main,e_child_friendly)!='')
   {
    echo "\n",'<td><input name="p_child_num__',$j,'" size=4 value="',
    htmlspecialchars(0+mit_g($p,p_child_num)),'"></td>';
       $person_row[] = 0+mit_g($p,p_child_num);
   }
  for($k=1;$k<=15;$k++)
   {
       if (mit_g($mit_main,e_flextext_1+($k-1))!='') {
           echo "\n",'<td><input size=5 name="p_flextext_',$k,'__',$j,
            '" value="',mit_gg($p,p_flextext_1+($k-1)),'"></td>';
           $person_row[] = 0+mit_gg($p,p_flextext_1+($k-1));
       }
   }
  for($k=1;$k<=5;$k++)
   {
    if (mit_g($mit_main,e_flexcb_1+($k-1))!='')
    {echo "\n",'<td><input type=checkbox name="p_flexcb_',$k,'__',$j,'"';
    if (mit_g($p,p_flexcb_1+($k-1))!='') echo ' checked'; echo '></td>';}
   }
  for($k=1;$k<=5;$k++)
   {
    if (mit_g($mit_main,e_atext_1+($k-1))!='')
    echo "\n",'<td><input size=5 name="p_atext_',$k,'__',$j,
    '" value="',mit_gg($p,p_atext_1+($k-1)),'"></td>';
   }
  for($k=1;$k<=5;$k++)
   {
    if (mit_g($mit_main,e_abox_1+($k-1))!='')
    {echo "\n",'<td><input type=checkbox name="p_abox_',$k,'__',$j,'"';
    if (mit_g($p,p_abox_1+($k-1))!='') echo ' checked'; echo '></td>';}
   }
  echo "\n",'<td><input name="p_paid__',$j,'" type="checkbox" value="yes"';
    if (mit_g($p,p_paid)!='') echo ' checked'; echo '></td>';
  if (mit_g($p,p_paid)!='')
    echo "\n",'<td>',mit_gg($p,p_paid_dt),'&nbsp;</td>';
  else
    echo "\n<td>&nbsp;</td>";
  echo "\n",'<td>',mit_gg($p,p_resp_dt),'&nbsp;</td>';
  echo "\n",'<td><input name="p_waitlist__',$j,'" type="checkbox" value="yes"';
    if (mit_g($p,p_waitlist)!='') echo ' checked'; echo '></td>';
  if (mit_g($p,p_comments)=='')
    echo "\n<td>&nbsp;</td>";
  else
    echo "\n<td><a target=\"new_",$j,
    '" href="event_person.php?t=',$mit_rand,'&eid=',$mit_eid,'&pid=',$j,
    "\"\n onClick=\"window.open('event_person.php?t=",$mit_rand,"&eid=",$mit_eid,
    "&pid=",$j,"','new_",$mit_eid,"_",$j,
    "','width=700,height=500,scrollbars=1,left=25,top=25');return false;",
    '">VIEW</a></td>';
  echo "\n",'<td><input name="cb_email__',$j,
  '" type="checkbox" onPropertyChange="mit_mail();" onChange="mit_mail();" value="yes"></td>';
  echo "\n",'<td><input name="p_delete__',$j,
  '" type="checkbox" value="yes"></td></tr>';
     
	
     if(count($mit_sum) == 0)
         $mit_sum = $person_row;
     else {
         for($i=0;$i<count($person_row);$i++) $mit_sum[$i] += $person_row[$i];
     }

 }

function update_checkboxes()
 {
  global $mit_main,$mit_eid,$mit_part; $n=count($mit_part);
  for($i=0;$i<$n;)
   {
    // do NOT increment $i yet since there can be multiple deletes in this call
    $pid = mit_g($mit_part[$i],p_id);
    if (mit_getpost('p_delete__'.$pid)=='') $i++; else
     {
      // Instead of deleting an element in the middle,
      // we just move the LAST element into this place, and then remove the last element.
      $mit_part[$i]=$mit_part[$n-1]; unset($mit_part[$n-1]); $n--;
     }
   }
  for($i=0;$i<$n;$i++)
   {
    $pid = mit_g($mit_part[$i],p_id);
    if (mit_getpost('p_email__'.$pid)=='') continue;
    if (mit_getpost('p_paid__'.$pid)!='')
     {
      if (strcasecmp($mit_part[$i][p_paid],"")==0)
       {
        $ff=''.mit_g($mit_main,e_email);
        $f=$ff;
        if (strcasecmp(substr($f,-8),'@mit.edu')!=0)
           $f='westgate-gc@mit.edu';
        $mit_part[$i][p_paid_dt]=date("m/d/Y");
        if ($mit_part[$i][p_email]!='')
        if ($mit_part[$i][p_adult_num]>0 || $mit_part[$i][p_child_num]>0)
        mail(
        // TO EMAIL
        $mit_part[$i][p_email],
        // SUBJECT
        "Payment for Westgate Event \""
        .mit_g($mit_main,e_title)."\" on "
        .mit_g($mit_main,e_date)." has been received",
        // BODY
        "<html><head></head><body>Dear <u>"
        .htmlspecialchars($mit_part[$i][p_name])
        ."</u>:<p>\nYour payment for the event <u>"
        .htmlspecialchars(mit_g($mit_main,e_title))
        ."</u>\n<br>on "
        .mit_g($mit_main,e_date)
        ." (mm/dd/yyyy) has been received.<p>\n"
        ."Your payment covers the cost of:<ul>\n"
        .( $mit_part[$i][p_adult_num]>0 ?
           ("<li>".(0+$mit_part[$i][p_adult_num])." adults (including yourself)") : "")
        .( $mit_part[$i][p_child_num]>0 ?
           ("<li>".(0+$mit_part[$i][p_child_num])." children") : "")
        ."</ul><p>Please email <u><tt>"
        .htmlspecialchars(mit_g($mit_main,e_email))
        ."</tt></u> if you have any questions.<p>\nThank you!<p>\n"
        ."** The above email is automatically generated by the database. **\n"
        ."</body></html>\n"
        // FROM EMAIL
        ,"From: ".$f
        .($ff!=''?"\nCC:".$ff:"")
        ."\nMIME-Version: 1.0"
        ."\nContent-Type: text/html; charset=\"UTF-8\"");
       }
      $mit_part[$i][p_paid]='Yes';
     }
    else
     {
      $mit_part[$i][p_paid]='';
     }
    if (mit_getpost('p_waitlist__'.$pid)!='') $mit_part[$i][p_waitlist]='Yes'; else $mit_part[$i][p_waitlist]='';
    $mit_part[$i][p_adult_num]=0+mit_getpost('p_adult_num__'.$pid);
    $mit_part[$i][p_child_num]=0+mit_getpost('p_child_num__'.$pid);
    for($j=1;$j<=5;$j++)
     {
      if (mit_getpost('p_flexcb_'.$j.'__'.$pid)!='')
         $mit_part[$i][p_flexcb_1+($j-1)]='Yes';
         else $mit_part[$i][p_flexcb_1+($j-1)]='';
      if (mit_getpost('p_abox_'.$j.'__'.$pid)!='')
         $mit_part[$i][p_abox_1+($j-1)]='Yes';
         else $mit_part[$i][p_abox_1+($j-1)]='';
      $mit_part[$i][p_atext_1+($j-1)]=mit_getpost('p_atext_'.$j.'__'.$pid);
     }
     for ($j=1; $j < 15; $j++) { 
      $mit_part[$i][p_flextext_1+($j-1)]=mit_getpost('p_flextext_'.$j.'__'.$pid);
     }
   }
  mit_write($mit_part,'event.'.$mit_eid.'.db');
 }

if ($_SERVER['REQUEST_METHOD']=='POST')
{
if(""!=$_POST["export"]){
  export_event();
  $email="miaojilang@gmail.com";
  $sbj = "From westgate scripts";
  $msg = "exported csv\n";
  $msg .= chr(0x0A)."the attachment can be found at http://westgate.scripts.mit.edu/registration/db/event.".$mit_eid.".xls";
  mail($email,$sbj,$msg);
  $url = "http://westgate.scripts.mit.edu/registration/db/event.".$mit_eid.".xls";
  header('Location:'.$url);
  delete("db/event.".$mit_eid.".xls");
 }
if(""!=$_POST["save"]){
  update_checkboxes();
  mit_gos('event_people.php?t='.$mit_rand.'&eid='.urlencode($mit_eid));
 }
}

mit_unlock();

    /*=========================================================================*/?><!DOCTYPE html>
<html lang="en">
<head>
<title>Westgate Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<script>
var mit_loadedS=0,mit_loadedB=0,mit_list=[],mit_lists=[],mit_lista=[];
<?php
for ($k=0;$k<count($mit_part);$k++)
 {
  echo 'mit_list[',$k,']=',mit_g($mit_part[$k],p_id),";\n";
 }
for ($k=0;$k<count($mit_part);$k++)
 {
  echo 'mit_lists[',$k,']=[',$k // 0
       ,',',0+mit_g($mit_part[$k],p_id) // 1
       ,',0,"',0+mit_g($mit_part[$k],p_adult_num),"\"," // 3
       ,'"',0+mit_g($mit_part[$k],p_child_num),"\"," // 4
       ,'"',mit_g($mit_part[$k],p_paid),"\","        // 5
       ,'"',mit_g($mit_part[$k],p_paid_dt),"\","     // 6
       ,'"',mit_g($mit_part[$k],p_resp_dt),"\","     // 7
       ,'"',mit_g($mit_part[$k],p_waitlist),"\"];\n"; // 8
 }
?>
function mit_getv(fm,n) { fm=fm[n]; if (fm) return ''+fm.value; return ''; }
function mit_getc(fm,n) { fm=fm[n]; if (fm) if (fm.checked) return 1; return 0; }
function mit_setv(fm,n,v) { fm=fm[n]; if (fm) fm.value=''+v; }
function mit_setc(fm,n,v) { fm=fm[n]; if (fm) fm.checked=(v>0); }
function mit_cmp(f,a,b)
 {
  var n; if (f>2) {a=(''+a).toLowerCase(); b=(''+b).toLowerCase();}
  else {a=parseInt('0'+a,10);b=parseInt('0'+b,10);}
  if (f==5 || f==6)
   {
    n=a.length; if (n>=4) a=a.substring(n-4,n)+a;
    n=b.length; if (n>=4) b=b.substring(n-4,n)+b;
   }
  if (f==1 || f==3 || f==5) return a>b; return a<b;
 }

function mit_sort(f,field)
 {
  var fm,x,p,pt,ptc=0,i,j; if (mit_loadedB==0 || mit_loadedS==0) return;
  fm=document.forms['mit_form']; if (mit_lists.length<1) return;
  for(i=0;i<mit_lists.length;i++)
   {
    j=mit_lists[i][1];
    mit_lists[i][3]=parseInt('0'+mit_getv(fm,'p_adult_num__'+j),10);
    mit_lists[i][4]=parseInt('0'+mit_getv(fm,'p_child_num__'+j),10);
    mit_lists[i][5]=mit_getc(fm,'p_paid__'+j);
    mit_lists[i][8]=mit_getc(fm,'p_waitlist__'+j);
    mit_lists[i][11]=mit_getv(fm,'p_flextext_1__'+j);
    mit_lists[i][12]=mit_getv(fm,'p_flextext_2__'+j);
    mit_lists[i][13]=mit_getv(fm,'p_flextext_3__'+j);
    mit_lists[i][14]=mit_getv(fm,'p_flextext_4__'+j);
    mit_lists[i][15]=mit_getv(fm,'p_flextext_5__'+j);
    mit_lists[i][16]=mit_getc(fm,'p_flexcb_1__'+j);
    mit_lists[i][17]=mit_getc(fm,'p_flexcb_2__'+j);
    mit_lists[i][18]=mit_getc(fm,'p_flexcb_3__'+j);
    mit_lists[i][19]=mit_getc(fm,'p_flexcb_4__'+j);
    mit_lists[i][20]=mit_getc(fm,'p_flexcb_5__'+j);
    mit_lists[i][21]=mit_getv(fm,'p_atext_1__'+j);
    mit_lists[i][22]=mit_getv(fm,'p_atext_2__'+j);
    mit_lists[i][23]=mit_getv(fm,'p_atext_3__'+j);
    mit_lists[i][24]=mit_getv(fm,'p_atext_4__'+j);
    mit_lists[i][25]=mit_getv(fm,'p_atext_5__'+j);
    mit_lists[i][26]=mit_getc(fm,'p_abox_1__'+j);
    mit_lists[i][27]=mit_getc(fm,'p_abox_2__'+j);
    mit_lists[i][28]=mit_getc(fm,'p_abox_3__'+j);
    mit_lists[i][29]=mit_getc(fm,'p_abox_4__'+j);
    mit_lists[i][30]=mit_getc(fm,'p_abox_5__'+j);
   }
  for(i=0;i<mit_lists.length;i++)
   {
    pt=0;
    for(j=0;j<mit_lists.length-1;j++)
     {
      if (mit_cmp(f,mit_lists[j][field],mit_lists[j+1][field]))
       {
        x=mit_lists[j]; p=mit_lists[j+1];
        mit_lists[j]=[]; mit_lists[j+1]=[];
        mit_lists[j]=p; mit_lists[j+1]=x; pt=1; ptc=1; continue;
       }
     }
    if (pt==0) break;
   }
  if (ptc==0) return;
  for(i=0;i<mit_lists.length;i++)
   {
    x=document.getElementById('mit_row'+i);
    if (i==0) p=x.parentNode; mit_lista[i]=p.removeChild(x);
   }
  for(i=0;i<mit_lists.length;i++) p.appendChild(mit_lista[mit_lists[i][0]]);
  for(i=0;i<mit_lists.length;i++)
   {
    j=mit_lists[i][1];
    mit_setv(fm,'p_adult_num__'+j,mit_lists[i][3]);
    mit_setv(fm,'p_child_num__'+j,mit_lists[i][4]);
    mit_setc(fm,'p_paid__'+j,mit_lists[i][5]);
    mit_setc(fm,'p_waitlist__'+j,mit_lists[i][8]);
    mit_setv(fm,'p_flextext_1__'+j,mit_lists[i][11]);
    mit_setv(fm,'p_flextext_2__'+j,mit_lists[i][12]);
    mit_setv(fm,'p_flextext_3__'+j,mit_lists[i][13]);
    mit_setv(fm,'p_flextext_4__'+j,mit_lists[i][14]);
    mit_setv(fm,'p_flextext_5__'+j,mit_lists[i][15]);
    mit_setc(fm,'p_flexcb_1__'+j,mit_lists[i][16]);
    mit_setc(fm,'p_flexcb_2__'+j,mit_lists[i][17]);
    mit_setc(fm,'p_flexcb_3__'+j,mit_lists[i][18]);
    mit_setc(fm,'p_flexcb_4__'+j,mit_lists[i][19]);
    mit_setc(fm,'p_flexcb_5__'+j,mit_lists[i][20]);
    mit_setv(fm,'p_atext_1__'+j,mit_lists[i][21]);
    mit_setv(fm,'p_atext_2__'+j,mit_lists[i][22]);
    mit_setv(fm,'p_atext_3__'+j,mit_lists[i][23]);
    mit_setv(fm,'p_atext_4__'+j,mit_lists[i][24]);
    mit_setv(fm,'p_atext_5__'+j,mit_lists[i][25]);
    mit_setc(fm,'p_abox_1__'+j,mit_lists[i][26]);
    mit_setc(fm,'p_abox_2__'+j,mit_lists[i][27]);
    mit_setc(fm,'p_abox_3__'+j,mit_lists[i][28]);
    mit_setc(fm,'p_abox_4__'+j,mit_lists[i][29]);
    mit_setc(fm,'p_abox_5__'+j,mit_lists[i][30]);
   }
 }
function mit_del()
 {
  var i,x,f; if (mit_loadedB==0 || mit_loadedS==0) return false;
  f=document.forms['mit_form'];
  for(i=0;i<mit_list.length;i++)
   {
    x=f['p_delete__'+mit_list[i]];
    if (x) {} else continue;
    if (x.checked) return confirm('Are you sure you wish to delete these participants?');
   }
  return true;
 }
function mit_mail()
 {
  var i,x,y='',f=document.forms['mit_form'];
  for(i=0;i<mit_list.length;i++)
   {
    x=f['cb_email__'+mit_list[i]];
    if (x) {} else continue;
    if (x.checked) {} else continue;
    x=f['p_email__'+mit_list[i]];
    if (x) {} else continue;
    if (y=='') y=x.value; else y=y+' ; '+x.value;
   }
  f['all'].value=y;
 }
var mit_selflag=true;
function mit_select()
 {
  var i,x,y=0,f=document.forms['mit_form'];
  for(i=0;i<mit_list.length;i++)
   {
    x=f['cb_email__'+mit_list[i]];
    if (x) {if (x.checked!=mit_selflag) {x.checked=mit_selflag;y=1;}}
   }
  if (mit_selflag) mit_selflag=false; else mit_selflag=true;
  if (y==0) mit_select(); else mit_mail();
 }
</script>
</head>
<body onLoad="mit_loadedB=1;">
<!----------------------------------- start body ---------------------------------------->
<div class="container">

<ol class="breadcrumb">
<li><a href="http://westgate.mit.edu">Home</a></li>
<li><a href="event.php?t=<?=$mit_rand; ?>">Westgate Events</a></li>
<li><a href="event_view.php?t=<?=$mit_rand ?>&eid=<?=urlencode($mit_eid) ?>">Event</a></li>
<li class="active">Event Admin</li>
</ol>

<table border=0 cellpadding=0 cellspacing=0 class="table">
<tr><td style="font:10px arial; text-align:right;">
  <input type=button value="View All Events" onClick="location.href='event.php?t=<?php echo $mit_rand; ?>';">&nbsp;
  <input type=button value="Edit This Event" onClick="location.href='event_create.php?t=<?php echo $mit_rand; ?>&eid=<?php echo urlencode($mit_eid);?>';">&nbsp;
  <input type=button value="Copy This Event" onClick="location.href='event_create.php?t=<?php echo $mit_rand; ?>&eid=<?php echo urlencode($mit_eid);?>&'+'copy=y';">&nbsp;
  <input type=button value="Delete This Event" onClick="if (confirm('Are you sure you wish to delete this event?')) location.href='event_delete.php?t=<?php echo $mit_rand; ?>&eid=<?php echo urlencode($mit_eid);?>';">&nbsp;
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td bgcolor=#DD6600 style="padding:8px;font:bold 18px arial;text-align:left;width:75%;">
Participant Summary and Detail Listing for
<u><?php echo mit_g($mit_main,e_title); ?></u></td>
</tr></table><br>

<div class="row">
<div class="col-md-6">
<?php //=======================================================================

$mit_a=0; $mit_b=0; $mit_aa=0; $mit_bb=0; $mit_aaa=0; $mit_bbb=0; $mit_wa=0; $mit_wb=0;
for($i=0;$i<count($mit_part);$i++)
 {
  $mit_rec = $mit_part[$i];
  $mit_amt = 0;
  if (mit_g($mit_main,e_adult_friendly)!='') $mit_amt =           (mit_g($mit_rec,p_adult_num) * mit_g($mit_main,e_adult_fee));
  if (mit_g($mit_main,e_child_friendly)!='') $mit_amt = $mit_amt + (mit_g($mit_rec,p_child_num) * mit_g($mit_main,e_child_fee));
  if (mit_g($mit_rec,p_waitlist)!='')
   {
    if (mit_g($mit_main,e_adult_friendly)!='')
       $mit_wa = $mit_wa + mit_g($mit_rec,p_adult_num);
    if (mit_g($mit_main,e_child_friendly)!='')
       $mit_wb = $mit_wb + mit_g($mit_rec,p_child_num);
    if (mit_g($mit_rec,p_paid)!='') $mit_aaa=$mit_aaa+$mit_amt;
    else $mit_bbb=$mit_bbb+$mit_amt;
    continue;
   }
  if (mit_g($mit_main,e_adult_friendly)!='')
    $mit_a = $mit_a + mit_g($mit_rec,p_adult_num);
  if (mit_g($mit_main,e_child_friendly)!='')
    $mit_b = $mit_b + mit_g($mit_rec,p_child_num);
  if (mit_g($mit_rec,p_paid)!='') $mit_aa=$mit_aa+$mit_amt;
  else $mit_bb=$mit_bb+$mit_amt;
 }
if (mit_g($mit_main,e_adult_friendly)!='')
   echo 'Total # of Adults confirmed: ', $mit_a, "\n<br>";
if (mit_g($mit_main,e_child_friendly)!='')
   echo 'Total # of Children confirmed: ', $mit_b, "\n<br>";
if ($mit_wa>0 && mit_g($mit_main,e_adult_friendly)!='')
   echo 'Total # of Adults on Waiting List: ', $mit_wa, "\n<br>";
if ($mit_wb>0 && mit_g($mit_main,e_child_friendly)!='')
   echo 'Total # of Children on Waiting List: ', $mit_wb, "\n<br>";
echo '<p>';
echo 'Total Amount Paid (by people who are signed up): $', $mit_aa, "\n<br>";
if ($mit_wa>0 || $mit_wb>0) echo 'Total Amount Paid (by people who are on the waiting list): $', $mit_aaa, "\n<br>";
echo '<p>';
echo 'Total Amount Owed (by people who are signed up): $', $mit_bb, "\n<br>";
if ($mit_wa>0 || $mit_wb>0) echo 'Total Amount Owed (by people who are on the waiting list): $', $mit_bbb, "\n<br>";
echo '<p>';

    ?>
</div>

<div class="col-md-4">
<strong>Use this short URL and QR code for advertising the event: <a target="_blank" href="<?=mit_g($mit_main,e_shorturl) ?>"><?=mit_g($mit_main,e_shorturl) ?></a></strong>
</div>

<div class="col-md-2">
<img src="http://westgate.scripts.mit.edu/makeqr.py?s=<?=urlencode(mit_g($mit_main,e_shorturl)) ?>" />
</div>

</div>
<?php
    
if (count($mit_part)<1)
 {
  echo '<b>There are currently no participants in this event.</b></body></html>';
  exit;
 }

$pre = '<a href="event_people.php?t='.$mit_rand.'&eid='.urlencode($mit_eid);
echo '<form name="mit_form" method="post" action="event_people.php" ',"\n",
     'onSubmit="return mit_del();">',
     '<input type="submit" name="save" value="Save Changes">&nbsp;',
     '<input type="submit" name="export" value="Export Event">&nbsp;',"\n<p>",
     '<table class="table table-striped table-condensed"><thead>',
     '<tr>',
     '<th>Name</th>',"\n",
     '<th>Email</th>',
     '<th>Apt</th>';
if (mit_g($mit_main,e_adult_friendly)!='')
 {
  echo "<th># Adults"
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(1,3);">'
  ,'&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(2,3);">&uarr;</a></th>',"\n</td>\n";
 }
if (mit_g($mit_main,e_child_friendly)!='')
 {
  echo "<th># Children"
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(1,4);">'
  ,'&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(2,4);">&uarr;</a></th>',"\n";
 }
for($k=1;$k<=15;$k++)
 {
  if (mit_g($mit_main,e_flextext_1+($k-1))!='')
  echo '<th>',mit_gg($mit_main,e_flextext_1+($k-1))
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(3,'
  ,$k+10,');">&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(4,',$k+10,');">&uarr;</a></th>',"\n";
 }
for($k=1;$k<=5;$k++)
 {
  if (mit_g($mit_main,e_flexcb_1+($k-1))!='')
  echo '<th>',mit_gg($mit_main,e_flexcb_1+($k-1))
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(1,'
  ,$k+15,');">&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(2,',$k+15,');">&uarr;</a></th>',"\n";
 }
for($k=1;$k<=5;$k++)
 {
  if (mit_g($mit_main,e_atext_1+($k-1))!='')
  echo '<th>',mit_gg($mit_main,e_atext_1+($k-1))
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(3,'
  ,$k+20,');">&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(4,',$k+20,');">&uarr;</a></th>',"\n";
 }
for($k=1;$k<=5;$k++)
 {
  if (mit_g($mit_main,e_abox_1+($k-1))!='')
  echo '<th>',mit_gg($mit_main,e_abox_1+($k-1))
  ,'<br><a style="text-decoration:none;" href="javascript:mit_sort(1,'
  ,$k+25,');">&darr;</a>&nbsp;<a style="text-decoration:none;"'
  ,' href="javascript:mit_sort(2,',$k+25,');">&uarr;</a></th>',"\n";
 }
echo '<th>Paid<br><a style="text-decoration:none;" href="javascript:mit_sort(1,5);">&darr;</a>&nbsp;<a style="text-decoration:none;" href="javascript:mit_sort(2,5);">&uarr;</a></th>';
echo '<th>Paid Date<br><a style="text-decoration:none;" href="javascript:mit_sort(5,6);">&darr;</a>&nbsp;<a style="text-decoration:none;" href="javascript:mit_sort(6,6);">&uarr;</a></th>';
echo '<th>SignUp Date<br><a style="text-decoration:none;" href="javascript:mit_sort(1,1);">&darr;</a>&nbsp;<a style="text-decoration:none;" href="javascript:mit_sort(2,1);">&uarr;</a></th>';
echo '<th>On Waiting List?<br><a style="text-decoration:none;" href="javascript:mit_sort(1,8);">&darr;</a>&nbsp;<a style="text-decoration:none;" href="javascript:mit_sort(2,8);">&uarr;</a></th>';
echo '<th>Comments</th>',"\n";
echo '<th><a href="javascript:mit_select();">Send Email</a></th><th>Delete</th></tr></thead><tbody>',"\n";
for ($k=0;$k<count($mit_part);$k++) {print_participant($k,$mit_part[$k]);}
    
echo "\n\n<tr><td>Total</td><td>&nbsp;</td><td>&nbsp;</td>";
    for($i=0;$i<count($mit_sum);$i++) {
        echo "<td>".($mit_sum[$i])."</td>\n";
    }
echo "\n</tr>\n\n";
    
echo "\n\n",'</tbody></table><input type=hidden name=eid value="',$mit_eid,
 '"><p>',"\n",'<b>The email addresses of all selected participants is ',
 'listed below:</b><p>',"\n",
 '<textarea rows=10 cols=90 name=all></textarea><p>';

/*========================================================================*/ ?>

</form><script>mit_loadedS=1;</script>

</div> <!--container-->

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body></html>
