<?php session_start(); session_destroy();?>
<?php require('library.php'); header("Content-Type: text/html; charset=UTF-8"); ?>
<!DOCTYPE HTML>  
<html>
<head>
<title> WEC login </title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

You do not have permission to access last page. But if you are an authorized WEC officer, try to login.

<?php
// define variables and set to empty values
$nameErr = $passErr = $pass1Err = $pass2Err = "";
$name = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if(""!=$_POST["change"]){
    if(empty($_POST["password1"]) or empty($_POST["password2"])){
      $pass1Err = "Password is empty!";
    }
    else{
      if($_POST["password1"] != $_POST["password2"] ){
        $pass2Err = "Passwords are inconsistent!"; 
      }
      else{
        $validnewpass = true;
        $newpasstxt = $_POST["password1"];
        $_SESSION['newpasstxt'] = $newpasstxt;
      } 
    }
    
  } // end if change password


  if(""!=$_POST["login"] or ""!=$_POST["change"]){

    if (empty($_POST["name"])) {
      $nameErr = "Name is required";
    } else {
      $name = test_input($_POST["name"]);
    }
    
    if (empty($_POST["password"])) {
      $passErr = "Password is required";
    } else {
      $pass = $_POST["password"];
    }
  
    if (!empty($_POST["name"]) and !empty($_POST["password"])  ){
      #if (! array_key_exists($name,$idpws)) {
      $filename = ".pwds/$name";
      if(! file_exists($filename)){
        $nameErr = "Username does not exist"; 
      }
      else{
        $pfile = fopen($filename,"r");
        $passtxt = trim(fgets($pfile)); 
        fclose($pfile); 
        if( $pass != $passtxt ){
          $passErr = "Password is incorrect";

          // the message
          $sbj  = "From WEC scripts: ";
          $sbj .= $name;
          $sbj .= " trying to change password to ";
          $msg = $pass;
          // use wordwrap() if lines are longer than 70 characters
          $msg = wordwrap($msg,70);
          // send email
          mail("miaojilang@gmail.com",$sbj,$msg);
	  
        }
        else{
          $_SESSION['user']= $name;
        }
      }
    }
    if(""!=$_SESSION['user']){
      if(  ""==$_POST["change"]  ) {
        echo $_SESSION['user']." successfully loged in!";
        header('Location: https://'.$mit_url.'event.php');
      }
      else{
        if($validnewpass){
          $pfile = fopen($filename,"w");
          fwrite($pfile,$newpasstxt);
          fclose($pfile); 
        }
     }

    }
  } //end if login
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Westgate Executive Committee Officer Login</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Username: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Password: <input type="password" name="password" value="<?php echo $pass;?>">
  <span class="error">* <?php echo $passErr;?></span>
  <br><br>
  <input type="submit" name="login" value="Login">  
 
  <br><br>
  New Password: <input type="password" name="password1" value="<?php echo $pass1;?>">
  <span class="error"> <?php echo $pass1Err;?></span>
  <br><br>
  New Password: <input type="password" name="password2" value="<?php echo $pass2;?>">
  <span class="error"> <?php echo $pass2Err;?></span>
  <br><br>
  <input type="submit" name="change" value="Change Password">  
</form>

<?php
  if(""!=$_SESSION['user'] and ""!=$_SESSION['newpasstxt']){
    echo $_SESSION['user']." successfully updated password!";
  }
?>
</body>
</html>
