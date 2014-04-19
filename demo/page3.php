<?php require_once("includes/session.php"); 
 require_once("includes/connection.php"); 
 require_once("includes/functions.php");
require_once("includes/PasswordHash.php"); 
if(logged_in()) {
   redirect_to('page4.php');
}
?>
<?php
   include_once("includes/form_functions.php");
   $message = '';
   $hasher = new PasswordHash(8, false);
   // START FORM PROCESSING
   if (isset($_POST['next'])) { // Form has been submitted.
      echo 'posted';
      $errors = array();

      // perform validations on the form data
      $required_fields = array('password', 'email', 'fname');
      $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

      $fields_with_lengths = array('email' => 32, 'password' => 72);
      $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

      $password = trim($_POST['password']);
      $password2 = trim($_POST['password2']);
      $email = trim($_POST['email']);
      $fname = trim($_POST['fname']);
      $hash = $hasher->HashPassword($password);

      if ( empty($errors) && ($password == $password2) ) {
         $query = $connection->prepare("INSERT INTO tempU(email, fname, hashed_password, done) VALUES(:email, :fname, :hash, :done)");
         $result = $query->execute(array(':email' => $email, ':fname' => $fname, ':hash' => $hash, ':done' => 0));
         //if the insert was successful, store this message to be displayed
         if ($result) {
            $message = "The info was stored successfully.";
            $_SESSION['email'] = $email;
            redirect_to('page4.php');
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
<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 3</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/setup.css" rel="stylesheet" media="screen">
      <link href="css/device-styles.css" rel="stylesheet" media="screen">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
      <script src="js/flowtype.js"></script>
      <script>
         jQuery(document).ready(function(){
         jQuery('body').flowtype();
         });
      </script>
	</head>
	<body>
      <form method="POST" action="page3.php">
		<div class="absolute">
			<p class="p1">Now lets get your account set up!</p><br> 
		</div>
      <div class="inputfields">
         <input class = "input inputIn" type="text" name="fname" placeholder="FIRST NAME" />
         <input class = "input inputIn" type="email"  name="email" placeholder="EMAIL" />
         <input class = "input inputIn" type="password" name="password" placeholder="PASSWORD" /> 
         <input class = "input inputIn" type="password" name="password2" placeholder="REPEAT PASSWORD" />
      </div>
      <div class="timeline">
         <div id="pager">
            <a href="#" class="">1</a>
            <a href="page2.php" class="">2</a>
            <a href="#" class="activeSlide">3</a>
            <a href="page4.php" class="">4</a>
            <a href="#" class="">5</a>
            <a href="#" class="">6</a>
            <a href="#" class="">7</a>
            <a href="#" class="">8</a>
            <a href="#" class="">9</a>
            <a href="#" class="">10</a>
            <a href="#" class="">11</a>
         </div>
      </div>
      <div class="back">
         <a href="page2.php"><button class="button" type="button" name="back" class="btn btn-default btn-medium">BACK</button></a>
      </div>
      <div class="next">
         <button class="button" type="submit" name="next" class="btn btn-default btn-medium">NEXT</button>
      </div> 
      </form>
	</body>
</html>