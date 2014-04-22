<?php require_once("includes/session.php"); 
 require_once("includes/connection.php"); 
 require_once("includes/functions.php");
require_once("includes/PasswordHash.php"); ?>
<?php
   include_once("includes/form_functions.php");
   // START FORM PROCESSING
   if (isset($_POST['submit'])) { // Form has been submitted.
            $_SESSION = array();
            if(isset($_COOKIE[session_name()])) {
               setcookie(session_name(), '', time()-42000, '/');
            }
            if(isset($_COOKIE['TKC'])) {
               setcookie('TKC', '', time()-31557600, "/", false, false, true); 
            }
            session_destroy();
            redirect_to("login.php");
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
      <form action="page10.php" method="POST">
		<div class="absolute">
			<p class="p1">Thats it!</p>
			<p class="p2">Click done to login and enjoy your new feeder.</p>
		</div>
      <div class="timeline">
         <div id="pager">
            <a href="#" class="">1</a>
            <a href="#" class="">2</a>
            <a href="#" class="">3</a>
            <a href="#" class="">4</a>
            <a href="#" class="">5</a>
            <a href="#" class="">6</a>
            <a href="#" class="">7</a>
            <a href="#" class="">8</a>
            <a href="#" class="">9</a>
            <a href="page9.php" class="">10</a>
            <a href="#" class="activeSlide">11</a>
         </div>
      </div>
      <div class="back">
          <a href="page9.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
      </div>
      <div class="next">
         <button class="button" type="submit" name="submit" class="btn btn-default btn-medium">DONE</button>
      </div> 
      </form> 
	</body>
</html>