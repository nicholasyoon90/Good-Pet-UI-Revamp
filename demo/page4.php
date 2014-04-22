<?php require_once("includes/session.php");
 require_once("includes/connection.php");
 require_once("includes/functions.php");
 require_once("includes/PasswordHash.php");
 require_once("includes/makeThumb.php");
 //include("includes/header.php"); ?>

 <?php
 include_once("includes/form_functions.php");
    $testVar = 0;
    $message = '';
    // START FORM PROCESSING
    if (isset($_POST['next'])) { // Form has been submitted.
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
        
        if ( empty($errors) ) {
            $query = $connection->prepare("INSERT INTO tempF (fID, petName) VALUES(:fID, :petName)");
            $result = $query->execute(array(':fID' => $fID, ':petName' => $Name));
            if ($result) {
                $message = "The feeder was successfully created.";
                $_SESSION['petFeedID'] = $fID;
                redirect_to("page5.php");
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
		<title>Setup Page 4</title>
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
			<p class="p1">Let's get some info about your feeder.</p>
		</div>
      <div class="inputfields">
         <input class = "input inputIn" type="text" name="petName" placeholder="PET NAME" /> <br>
         <input class = "input inputIn" type="number" name="fID" placeholder="FEEDER ID" />
      </div>

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
            <a href="#" class="">11</a>
         </div>
      </div>
      <div class="back">
         <a href="page3.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
      </div>
      <div class="next">
         <button class="button" type="submit" name="next" class="btn btn-default btn-medium">NEXT</button>
      </div> 
    </div>
   </form>
	</body>
</html>