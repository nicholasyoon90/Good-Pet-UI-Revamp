<?php require_once("includes/session.php");
 require_once("includes/connection.php");
 require_once("includes/functions.php");
 require_once("includes/PasswordHash.php");
 require_once("includes/makeThumb.php");
 confirm_logged_in();
 ob_start();
 //include("includes/header.php"); ?>

 <?php
 include_once("includes/form_functions.php");
    $testVar = 0;
    $message = '';
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
            echo $result;
            if ($result) {
                $message = "The feeder was successfully created.";
                $_SESSION['petFeedID'] = $fID;
                redirect_to("feeders.php");
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
<html>
<head>
  <meta charset="utf-8">
  <title>GOOD, Inc.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body class="home">
	<br><br>
	<div class="logo"></div>
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="jumbotron">
				        <form class="form-horizontal" method="POST" action="add_feeder.php">
  							<div class="control-group">
    							<p class='login'>Pet Name</p>
    							<div class="controls">
      								<input type="text" name="petName" id="petName" placeholder="Pet Name">
    							</div>
  							</div>
  							<div class="control-group">
    							<p class='login'>Feeder ID</p>
    							<div class="controls">
      								<input type="number" name="fID" id="fID" placeholder="Feeder ID">
    							</div>
  							</div>
  							<div class="control-group">
    							<div class="controls">
      								<button type="submit" name="addFeeder" id="addFeeder" class="btn btn-darkgood">Add Feeder »</button>
      								<a class="btn btn-darkgood" href="logged_in.php">Return To Scheduling »</a>
    							</div>
  							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>
</html>