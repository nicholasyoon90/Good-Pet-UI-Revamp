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
   $message = 'Now lets get your account set up!';
   $hasher = new PasswordHash(8, false);
   // START FORM PROCESSING
   if (isset($_POST['createAccount'])) { // Form has been submitted.
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
         $query = $connection->prepare("INSERT INTO Users(email, hashed_password, fname) VALUES(:email, :hash, :fname)");
         $result = $query->execute(array(':email' => $email, ':hash' => $hash, ':fname' => $fname));
         //if the insert was successful, store this message to be displayed
         if ($result) {
            $message = "The account was successfully created, click Next.";
            $_SESSION['email'] = $email;
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
      $password2 = "";
      $email = "";
      $fname = "";
   }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GOOD, Inc.</title>
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
      <div class="wrapper">
         <form method="POST" action="page3.php">
      		<div class="absolute">
      			<p class="p1" id="msg"><?php echo $message; ?></p><br> 
      		</div>


            <div class="con_container clearfix">
               <div class="inputfields">
                  <input class = "input inputIn" type="text" name="fname" placeholder="NAME" />
                  <input class = "input inputIn" type="email"  name="email" placeholder="EMAIL" />
                  <input class = "input inputIn" type="password" name="password" placeholder="PASSWORD" /> 
                  <input class = "input inputIn" type="password" name="password2" placeholder="REPEAT PASSWORD" />
                  <button class="button" type="submit" name="createAccount">CREATE ACCOUNT</button>
               </div>
            </div>

            <div class="footer">
               <div class="nav_container clearfix">
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
                   
                     </div>
                  </div>
               </div>
               <div class="but_container clearfix">
                  <div class="back">
                     <a href="page2.php"><button class="button" type="button" name="back" class="btn btn-default btn-medium">BACK</button></a>
                  </div>
                  <div class="next">
                     <a href="page4.php"><button class="button" type="button" name="next" class="btn btn-default btn-medium">NEXT</button></a>
                  </div>
               </div>
            </div>
   
         </form>
      </div>
	</body>
</html>