<?php header("Content-Type: text/html; charset=UTF-8"); ?>

<?php $r=date('Y.m.d.H.i.s.').rand(); ?>

<div style="border:solid;border-color:#000000;background:#ffd0d0;margin:2px;padding:10px;">

Thank you for casting your vote!<p>

On September 13, 2007, we will review the results of the election and begin to purchase the new movies.
<br>Each video will be announced on the <a href="javascript:location.href='vote.php?t=<?php echo $r;?>';">Voting Page</a>.
<p>To vote again (each apartment gets 10 votes), go back to the <a href="javascript:location.href='vote.php?t=<?php echo $r;?>';">Voting Page</a>.

<p>
To return to the Westgate website,
please click <a target="_top" href="http://web.mit.edu/westgate/">HERE</a>.

</div>
