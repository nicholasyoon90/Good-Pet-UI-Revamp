<?php require_once("includes/session.php");
 require_once("includes/connection.php");
 require_once("includes/functions.php");
 require_once("includes/PasswordHash.php");
 require_once("includes/makeThumb.php");
 //include("includes/header.php"); 
 if(!logged_in()) {
   redirect_to("login.php");
 }
?>
 <?php
 include_once("includes/form_functions.php");
    $message = "Let's get some info about your feeder.";
    // START FORM PROCESSING
    if (isset($_POST['addFeeder'])) { // Form has been submitted.
        $errors = array();

        // perform validations on the form data
        $required_fields = array('fID', 'petName');
        $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

        $fields_with_lengths = array('fID' => 30, 'petName' => 30);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

        $fID = trim(($_POST['fID']));
        $Name = trim(($_POST['petName']));
        $feederAttach = "'s Feeder";
        $petName = $Name . $feederAttach;
        $userID = $connection->prepare("SELECT userID FROM Users WHERE email=?");
        $userID->execute(array($_SESSION['email']));
        $arow = $userID->fetchAll(PDO::FETCH_ASSOC);
        
        if ( empty($errors) ) {
            $query = $connection->prepare("INSERT INTO Feeders (fID, petName, userID) VALUES(:fID, :petName, :userID)");
            $result = $query->execute(array(':fID' => $fID, ':petName' => $Name, ':userID' => $arow[0]['userID']));
            if ($result) {
                $message = "The feeder was successfully created, click Next.";
                $_SESSION['petFeedID'] = $fID;
            } else {
                $message = "The feeder could not be created.";
                $message .= "<br />" . mysql_error();
            }
        } else {
            if (count($errors) == 1) {
                $message = "There was 1 error in the form.";
            } else {
                $message = "There were " . count($errors) . " errors in the form.";
            }
        }
    } else { // Form has not been submitted.
        $fID = "";
        $petName = "";
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
    <div class ="wrapper">
      <form action="page4.php" method="POST">
  		  <div class="absolute">
  			  <p class="p1"><?php echo $message; ?></p>
  		  </div>

        <div class="con_container clearfix">
          <div class="inputfields">
             <input class = "input inputIn" type="text" name="petName" placeholder="PET NAME" /> <br>
             <input class = "input inputIn" type="number" name="fID" placeholder="FEEDER ID" />
             <button class="button" type="submit" name="addFeeder" class="btn btn-default btn-small">ADD FEEDER</button>
          </div>
        </div>

        <div class="footer">
          <div class="nav_container clearfix">
            <div class="timeline">
               <div id="pager">
                  <a href="#" class="">1</a>
                  <a href="#" class="">2</a>
                  <a href="page3.php" class="">3</a>
                  <a href="#" class="activeSlide">4</a>
                  <a href="page5.php" class="">5</a>
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
               <a href="page3.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
            </div>
            <div class="next">
               <a href="page5.php"><button class="button" type="button" name="next" class="btn btn-default btn-medium">NEXT</button></a>
            </div> 
          </div>
        </div>
    </div>
   </form>
	</body>
</html>