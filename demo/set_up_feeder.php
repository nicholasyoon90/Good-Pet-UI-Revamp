<?php require_once("includes/session.php"); 
 require_once("includes/connection.php"); 
 require_once("includes/functions.php");
require_once("includes/PasswordHash.php"); ?>
<?php
	include_once("includes/form_functions.php");
	$message = '';
	$hasher = new PasswordHash(8, false);
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('password', 'email', 'fname');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('email' => 32, 'password' => 72);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		//$username = trim(mysql_prep($_POST['username']));
		$password = trim($_POST['password']);
		$password2 = trim($_POST['password2']);
		$email = trim($_POST['email']);
		$fname = trim($_POST['fname']);
		$hash = $hasher->HashPassword($password);
		//$hashed_password = create_hash($password);
		//$_SESSION['goodHash'] = create_hash(
		//$message = '';

		if ( empty($errors) && ($password == $password2) ) {
		// insert the account info into the DB
			/*$query = "INSERT INTO Users (
							email, hashed_password, fname
						) VALUES (
							'{$email}', '{$hash}', '{$fname}'
						)";
			$result = mysqli_query($connection, $query);*/
			$query = $connection->prepare("INSERT INTO Users(email, hashed_password, fname) VALUES(:email, :hash, :fname)");
			$result = $query->execute(array(':email' => $email, ':hash' => $hash, ':fname' => $fname));
			//if the insert was successful, store this message to be displayed
			if ($result) {
				$message = "The account was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else if (count($errors) == 0){
				$message = "Passwords did not match, please try again.";
			} else{
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
	} else { // Form has not been submitted.
		$password = "";
		$email = "";
		$fname = "";
	}
?>
<?php
		if (logged_in()) {
			redirect_to("logged_in.php");
		}
	
		include_once("includes/form_functions.php");

		if (isset($_POST['login'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('email2', 'password2');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('email2' => 32, 'password2' => 72);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$email2 = trim(($_POST['email2']));
		$password2 = trim(($_POST['password2']));
		$stored_hash="*";
		//$storage = mysqli_query($connection,"SELECT email, hashed_password FROM Users WHERE email='".$email2."'");
		$storage = $connection->prepare("SELECT email, hashed_password FROM Users WHERE email=?");
		$storage->execute(array($email2));
		//$prow = mysqli_fetch_array($storage);
		$prow = $storage->fetchAll(PDO::FETCH_ASSOC);
		$stored_hash = $prow[0]['hashed_password'];
		
		$check = $hasher->CheckPassword($password2,$stored_hash);
		//$good_hash = create_hash($password2);
		//$hashed_password = validate_password($password, $good_hash);
		if($check) {
			$_SESSION['email'] = $prow[0]['email'];
			redirect_to("logged_in.php");
		}
		else {
			$message = "Email/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
		}
//old stuff below
		/*if ( empty($errors) && $check ) {
			// Check database to see if email and the hashed password exist there.
			$query = "SELECT email ";
			$query .= "FROM Users ";
			$query .= "WHERE email = '{$email2}' ";
			//$query .= "AND hashed_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$result_set = mysqli_query($connection, $query);
			confirm_query($result_set);
			if (mysqli_num_rows($result_set) == 1) {
				// email/password authenticated
				// and only 1 match
				$found_user = mysqli_fetch_array($result_set);
				$_SESSION['email'] = $found_user['email'];
				
				redirect_to("default_schedule.php");
			} else {
				// email/password combo was not found in the database
				$message = "Email/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
					
			}
		} *
		else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
			
		}*/
		
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		$email2 = "";
		$password2 = "";
		
	}
?>
<html>
<head>
<meta charset="utf-8">
<title>GOOD, Inc.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="css/custom.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>
<!--
var WiFiConnectWindow=null;
function WiFiConnect(mypage,myname,w,h,pos,infocus){

if (pos == 'random')
{LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
else
{LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
settings='width='+ w + ',height='+ h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';WiFiConnectWindow=window.open('',myname,settings);
if(infocus=='front'){WiFiConnectWindow.focus();WiFiConnectWindow.location=mypage;}
if(infocus=='back'){WiFiConnectWindow.blur();WiFiConnectWindow.location=mypage;WiFiConnectWindow.blur();}

}
// -->
</script>
</head>
<body>
<div class="hero-unit">
<h1 class="text-center">Welcome!<h1>
<h2 class="text-center">Please follow the steps below</h2>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="span6 offset4">
<h2 class="text-info"><strong>1. Plugin Feeder</strong></h2>
</div>
</div>
<div class="row-fluid">
<div class="span6 offset4">
<h2 class="text-info">2.<btn class="dropdown">
            <a class="btn btn-large btn-info dropdown-toggle" href="#" data-toggle="dropdown">Create Account &nbsp<strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding:15px; padding-bottom: 0px;">
              <!-- Login form here -->
            
         <form class="form-horizontal" method="POST" action="set_up_feeder.php">
  <div class="control-group">
    <label class="control-label" for="email">Email</label>
    <div class="controls">
      <input type="email" name="email" id="email" placeholder="user@domain.com">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password">Password</label>
    <div class="controls">
      <input type="password" name="password" id="password" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password2">Confirm Password</label>
    <div class="controls">
      <input type="password" name="password2" id="password2" placeholder="Confirm Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="fname">First Name</label>
    <div class="controls">
      <input type="text" name="fname" id="fname" placeholder="First Name">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="submit" id="submit" class="btn btn-info">Create Account</button>
    </div>
  </div>
</form>
</div>
</btn> </h1>
</div>
</div>
<div class="row-fluid">
<div class="span6 offset4">
<h2 class="text-info">3. Connect to WooFi</h2>
</div>
</div>
<script>
function RpiConnect {
 if(loc=="new") {
  document.getElementById('aForm').target="_blank";
 } else {
  document.getElementById('aForm').target="";
 }
}
</script>
<form target="" action="" method="post" id="aForm">
<div class="row-fluid">
<div class="span6 offset4">
<h2 class="text-info"> 4. <input type="button" class="btn btn-large btn-info" name="B1" value="Choose Your WiFi" onClick="WiFiConnect('http://192.168.42.2','WiFi','640','480','center','front');">
</h2>
</div>
</div>
</form>
<div class="row-fluid">
<div class="span4 offset4">
<h2 class="text-info"> 5. <btn class="dropdown">
            <a class="btn btn-large btn-info dropdown-toggle" href="#" data-toggle="dropdown"><strong>Manage  Feeder &nbsp</strong><strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
              <!-- Login form here -->
            
         <form class="form-horizontal" method="POST" action="set_up_feeder.php">
  <div class="control-group">
    <label class="control-label" for="email2">Email</label>
    <div class="controls">
      <input type="email" name="email2" id="email2" placeholder="user@domain.com">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password2">Password</label>
    <div class="controls">
      <input type="password" name="password2" id="password2" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Remember me
      </label>
      <button type="submit" name="login" id="login" class="btn btn-primary">Login</button>
    </div>
  </div>
</form>
</div>
</btn> 
</div>
</div>

</div>
<br>
<br>
<div class="row-fluid">
<div class="span6 offset4">
<a href="index.php"><button class="btn btn-large btn-success"><strong>Return to Home Page</strong></button></a>
</div>
</div>

 <script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
</body>
</html>
<?php if($message!='') echo $message; ?>