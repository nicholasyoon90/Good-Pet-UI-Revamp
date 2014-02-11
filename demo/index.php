<?php require_once("includes/session.php"); 
require_once("includes/connection.php"); 
require_once("includes/functions.php");
require_once("includes/PasswordHash.php"); ?>
<?php
	$message = '';
	$tk = '';
	$hasher = new PasswordHash(8, false);
	/*if (logged_in()) {
		redirect_to("logged_in.php");
	}
	*/
	//if(isset($_SESSION['email'])){
	//$remd = mysqli_query($connection, "SELECT remid,email FROM Users");
	$remd = $connection->query("SELECT remid,email FROM Users");
	//while($remrow = $remd->fetchAll(PDO::FETCH_ASSOC)/*mysqli_fetch_array($remd)*/){
	foreach ($remd as $remrow) {
		if (isset($_COOKIE['TKC'])) {
			if ($_COOKIE['TKC'] == $remrow['remid'])
			{
				//echo $_COOKIE["TKC"];
				$tk = uniqid($remrow['email'],true);
				//mysqli_query($connection,"UPDATE Users SET remid ='".$tk."' WHERE email ='".$remrow['email']."'");
				$updateRem = $connection->prepare("UPDATE Users SET remid=? WHERE email=?");
				$updateRem->execute(array($tk, $remrow['email']));
				setcookie("TKC", $tk, time()+31557600, "/", false, false, true); 
				$_SESSION['email'] = $remrow['email'];
				redirect_to("logged_in.php");
			}
		}
	}
	//}
	include_once("includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data, make sure that the fields meet the length requirements, etc.
		$required_fields = array('email', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('email' => 32, 'password' => 72);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
		// we are using an email and password for login verification, password goes through hashing algorithms as seen in PasswordHash.php
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$stored_hash="*";
		//$storage = mysqli_query($connection,"SELECT email, hashed_password FROM Users WHERE email='".$email."'");
		$storage = $connection->prepare("SELECT email, hashed_password FROM Users WHERE email=?");
		$storage->execute(array($email));
		//$prow = mysqli_fetch_array($storage);
		$prow = $storage->fetchAll(PDO::FETCH_ASSOC);
		if($prow != false)
			$stored_hash = $prow[0]['hashed_password'];
		//echo $stored_hash;
		$check = $hasher->CheckPassword($password,$stored_hash);
		
		
		//$good_hash = create_hash($password);
		//$hashed_password = validate_password($password, $good_hash);
		
		
		if($check) {
			if(isset($_POST['remember'])) {
				$tk = uniqid($email,true);
				//echo $tk;
				//insert into users, $tk.
				//mysqli_query($connection,"UPDATE Users SET remid ='".$tk."' WHERE email ='".$email."'");
				$updateC = $connection->prepare("UPDATE Users SET remid=? WHERE email=?");
				$updateC->execute(array($tk, $email));
				setcookie("TKC", $tk, time()+31557600, "/", false, false, true); 
			}
			$_SESSION['email'] = $prow[0]['email'];
			redirect_to("logged_in.php");
		}
		else {
			$message = "Email/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
		}
//old stuff below		
		/*if ( empty($errors) ) {
			// Check database to see if email exists there if there are no form errors and the password entered is correct.
			$query = "SELECT email ";
			$query .= "FROM Users ";
			$query .= "WHERE email = '{$email}' ";
			$query .= "AND hashed_password = '{$good_hash}' ";
			$query .= "LIMIT 1";
			$result_set = mysqli_query($connection, $query);
			confirm_query($result_set);
			if (mysqli_num_rows($result_set) == 1) {
				// email/password authenticated
				// and only 1 match
				$found_user = mysqli_fetch_array($result_set);
				$_SESSION['email'] = $found_user['email'];
				
				redirect_to("logged_in.php");
			} else {
				// email/password combo was not found in the database
				$message = "Email/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
					
			}
		} else {
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
		$email = "";
		$password = "";
		
	}
?>
<html>
  <head>
    <title>GOOD, Inc.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="container-fluid">
 <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
      <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
 <h1><p class="text-center">Good Pet Feeder</p></h1>
 </div>
  <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
      <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
    
    <div class="row-fluid">
    <div class="span6 offset3">
    <button class="btn btn-large btn-block btn-primary" type="button">Buy A Feeder</button>
    </div>
    <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
      <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
    <div class="row-fluid">
    <div class="span6 offset3">
    <a href="set_up_feeder.php"><button class="btn btn-large btn-block btn-primary" type="button">Set Up Feeder</button></a>
    </div>
     <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
      <div class="row-fluid">
    <div class="span6 offset3">
     </div>
     </div>
    <div class="row-fluid">
    <div class="span6 offset3">
  <btn class="dropdown">
            <a class="btn btn-large btn-block btn-primary dropdown-toggle" href="#" data-toggle="dropdown">Manage  Feeder <strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
              <!-- Login form here -->
            
         <form class="form-horizontal" method="POST" action="index.php">
  <div class="control-group">
    <label class="control-label" for="email">Email</label>
    <div class="controls">
      <input type="email" name="email" id="email" placeholder="email@domain.com">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password">Password</label>
    <div class="controls">
      <input type="password" name="password" id="password" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="remember" id="remember"> Remember me
      </label>
      <button type="submit" name="submit" id="submit" class="btn btn-primary">Login</button>
    </div>
  </div>
</form>
</div>
</btn> 
</div>
</div>
    
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php //display error messages if there are any.
if($message!='') echo $message; 
?>
