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
$nameErr = $passErr = "";
$name = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      }
      else{
        $_SESSION['user']= $name;
      }
    }
  }
    

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
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Password: <input type="password" name="password" value="<?php echo $pass;?>">
  <span class="error">* <?php echo $passErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php    
if(""!=$_SESSION['user']){
  echo $_SESSION['user']." successfully loged in!";
  header('Location: https://'.$mit_url.'event.php');
}
?>
</body>
</html>
