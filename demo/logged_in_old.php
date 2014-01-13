<?php require_once("includes/session.php"); 
 require_once("includes/connection.php"); 
 require_once("includes/functions.php"); 
 require_once("includes/PasswordHash.php");
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

		$fID = trim(mysql_prep($_POST['fID']));
		$Name = trim(mysql_prep($_POST['petName']));
		$feederAttach = "'s Feeder";
		$petName = $Name . $feederAttach;
		echo $petName;
		$userID = mysqli_query($connection, "SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
		$arow = mysqli_fetch_assoc($userID);
		if ( empty($errors) ) {
			$query = "INSERT INTO Feeders (fID, petName, userID) VALUES ('".$fID."','".mysql_real_escape_string($Name)."','".$arow['userID']."')";
			$result = mysqli_query($connection, $query);
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
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="hero-unit">
<h1 class="text-center">Manage your Schedule</h1>
</div>
<div class="container-fluid">
<div class="row-fluid">
  <div class="span3">
  <div class="row-fluid">
  <div class="span10 offset2">
  <btn class="dropdown">
            <a class="btn btn-large   btn-block btn-primary dropdown-toggle" href="#" data-toggle="dropdown">Add Feeder <strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
              <!-- Login form here -->
            
    <form class="form-horizontal" method="POST" action="logged_in.php">
  <div class="control-group">
    <label class="control-label" for="fID">Feeder ID</label>
    <div class="controls">
      <input type="id" name="fID" id="fID" placeholder="Feeder ID">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="petName">Pet Name</label>
    <div class="controls">
      <input type="text" name="petName" id="petName" placeholder="Pet Name">
    </div>
  </div>
 
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn  btn-info" name="addFeeder">Add Feeder</button>
    </div>
  </div>
</form>
</div>
</btn> 
 </div>
 </div>
 
 <div class="row-fluid">
  <div class="span10 offset2">
  </div>
  </div>
 
 <div class="row-fluid">
  <div class="span10 offset2">
  </div>
  </div>
 
 <div class="row-fluid">
  <div class="span 10 offset2">
  <a href='schedules.php'><button class="btn btn-large btn-primary" type='button'>Add Schedule</button></a>
  </div>
  </div>

<div class="row-fluid">
  <div class="span10 offset2">
  </div>
  </div>
  
  <div class="row-fluid">
  <div class="span10 offset2">
  </div>
  </div>
  
  
  <div class="row-fluid">
   <div class="span10 offset2">
  <a href="logout.php"><button class="btn btn-large btn-block btn-primary" type="button">Logout</button></a>
</div>
</div>
</div>    
<div class="span9">
    <div class="row-fluid">         
        <form method="POST" action="logged_in.php" id="scheduleForm">
			<?php 
				//grab all data relevant to schedules that needs to be displayed, and dynamically add it into table format on the webpage
				$numSchedules = 0;
				$userID = mysqli_query($connection,"SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
				$arow = mysqli_fetch_array($userID);
				$feederName = mysqli_query($connection,"SELECT petName,fID FROM Feeders WHERE userID='".mysql_real_escape_string($arow['userID'])."'");
				$numFeeders = mysqli_num_rows($feederName);
				$feeders = array();
				$i = $j = $k = $x = $l = 0;
				$feederID1 = array();
				$feederID2 = array();
				$snames = array();
				$scheduleID = mysqli_query($connection,"SELECT sID,scheduleName,fID,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday,Everyday,aTime,AMPM,amountFed FROM Schedules WHERE userID ='".mysql_real_escape_string($arow['userID'])."'");
				if($scheduleID != False){
					$numSchedules = mysqli_num_rows($scheduleID);
				}
				$days = array();
				$ampm = array();
				$times = array();
				$amountFed = array();
				  while($row1 = mysqli_fetch_array($feederName)){
					$feeders[$i] = stripslashes($row1['petName'] . "'s Feeder");
					$feederID1[$i] = $row1['fID'];
					$i++;
				  }
				  if($numSchedules != 0){
				  while($row2 = mysqli_fetch_array($scheduleID)){
					$snames[$j] = stripslashes($row2['scheduleName']);
					$sIDs[$j] = $row2['sID'];
					$feederID2[$j] = $row2['fID'];
					$am_and_pm = $row2['AMPM'];
					//$pm = $row2['PM'];
					$amount = $row2['amountFed'];
					$amo = '';
					if($amount == 0.25) {
						$amo = '1/4';
					}
					else if($amount == 0.50) {
						$amo = '1/2';
					}
					else if($amount == 0.75) {
						$amo = '3/4';
					}
					else if($amount == 1.00) {
						$amo = '1';
					}
					else if($amount == 1.25) {
						$amo = '1 1/4';
					}
					else if($amount == 1.50) {
						$amo = '1 1/2';
					}
					else if($amount == 1.75) {
						$amo = '1 3/4';
					}
					else if($amount == 2.00) {
						$amo = '2';
					}
					$dayString = '';
					$time = $row2['aTime'];
					if($row2['Monday'] == 1) {
						if($row2['Tuesday'] == 1 || $row2['Wednesday'] == 1 || $row2['Thursday'] == 1 || $row2['Friday'] == 1 || $row2['Saturday'] == 1 || $row2['Sunday'] == 1 ){
							$dayString .= 'Monday, ';
						}
						else{
							$dayString .= 'Monday';
						}
					}
					
					if($row2['Tuesday'] == 1) {
						if($row2['Wednesday'] == 1 || $row2['Thursday'] == 1 || $row2['Friday'] == 1 || $row2['Saturday'] == 1 || $row2['Sunday'] == 1 ){
							$dayString .= 'Tuesday, ';
						}
						else{
							$dayString .= 'Tuesday';
						}
					}
					if($row2['Wednesday'] == 1) {
						if($row2['Thursday'] == 1 || $row2['Friday'] == 1 || $row2['Saturday'] == 1 || $row2['Sunday'] == 1 ){
							$dayString .= 'Wednesday, ';
						}
						else{
							$dayString .= 'Wednesday';
						}
					}
					if($row2['Thursday'] == 1) {
						if($row2['Friday'] == 1 || $row2['Saturday'] == 1 || $row2['Sunday'] == 1 ){
							$dayString .= 'Thursday, ';
						}
						else{
							$dayString .= 'Thursday';
						}
					}
					if($row2['Friday'] == 1) {
						if($row2['Saturday'] == 1 || $row2['Sunday'] == 1 ){
							$dayString .= 'Friday, ';
						}
						else{
							$dayString .= 'Friday';
						}
					}
					if($row2['Saturday'] == 1) {
						if($row2['Sunday'] == 1 ){
							$dayString .= 'Saturday, ';
						}
						else{
							$dayString .= 'Saturday';
						}
					}
					if($row2['Sunday'] == 1) {
						$dayString .= 'Sunday';
					}
					if($row2["Everyday"] == 1) {
						$dayString .= 'Everyday ';
					}
					$times[$j] = $time;
					if($am_and_pm == 1){
						$ampm[$j] = "PM";
					}
					else if($am_and_pm == 0){
						$ampm[$j] = "AM";
					}
					$days[$j] = $dayString;
					$explodedDays = explode(" ", $dayString);
					$amountFed[$j] = $amo;
					$j++;
				  }
				 }
				  
				for($q=0; $q<$numFeeders; $q++){
					echo "<table class='table table-bordered' id='table".$q."'>
						  <thead>
						  <tr> 
						  <th class='lead'><strong>".stripslashes($feeders[$q])."</strong></th>
						  <td> <button class='btn btn-primary' type='submit' name='openBowl".$feederID1[$q]."'>Open Bowl</button>
						  <button class='btn btn-primary' type='submit' name='closeBowl".$feederID1[$q]."'>Close Bowl</button>
						  <button class='btn btn-primary' type='submit' name='snack".$feederID1[$q]."'>Dispense Snack</button>
						  <button class='btn btn-primary' type='submit' name='spinAuger".$feederID1[$q]."'>Spin Auger</button></td>
						  </td>
						  </tr>
						  </thead>" ;
					echo "<tbody>
						  <tr>
						  <th>Schedule Name</th>
						  <th>Day(s)</th>
						  <th>Time</th>
						  <th>Cup(s)</th>
						  <th></th>
						  </tr>"  ;
					for($w=0; $w<$numSchedules; $w++){
						if($feederID2[$w] == $feederID1[$q]){
							echo "<tr class='success'>
								  <td>".$snames[$w]."</td> 
								  <td>".$days[$w]."</td>              
								  <td>".$times[$w]." ".$ampm[$w]."</td>
								  <td>".$amountFed[$w]."</td>
								  <td> <button class='btn btn-success' type='submit' name='editSchedule".$sIDs[$w]."'>Edit</button> &nbsp&nbsp
								  <button class='btn btn-danger' type='submit' id='deleteSchedule' name='deleteSchedule".$sIDs[$w]."'>Delete</button></td>
								  <input type='hidden' name='sIDs' value=''>
								  </tr>";
						}
					}
				}
			?>	       
</tbody>
</table>
</div>
</form>
<?php
	// if edit is chosen, this grabs which schedule that is and passes the info on to the schedule editing page.
	$action = '';
	//$numScheds = count($sIDs);
	for($g=0; $g<$numSchedules; $g++){
		if(isset($_POST['editSchedule'.$sIDs[$g]])){
			$_SESSION['editSchedID'] = $sIDs[$g];
			redirect_to("schedule_edit.php");
		}
		
		if(isset($_POST['deleteSchedule'.$sIDs[$g]])){
			/*echo " <div id='demolayer style='position:fixed;top:100px;width:55%;left:auto;right:auto;z-index:100;text-align:center;'>
			Are you sure you want to delete this schedule?<br>
			<button>Yes</button>&nbsp&nbsp<button>No</button>
			 ";*/
			mysqli_query($connection, "DELETE FROM Schedules WHERE sID='".mysql_real_escape_string($sIDs[$g])."'");
/* CHANGE THIS AS NEEDED */header("Location: http://pet.buygood.us/demo/logged_in.php");
			?>
			<script>
			/*
			// variable to hold request
var request;
// bind to the submit event of our form
$("#foo").submit(function(event){
    // abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);
    // let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    // serialize the data in the form
    var serializedData = $form.serialize();

    // let's disable the inputs for the duration of the ajax request
    $inputs.prop("disabled", true);

    // fire off the request to /form.php
    request = $.ajax({
        url: "/processes.php",
        type: "post",
        data: serializedData
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // log a message to the console
        console.log("Hooray, it worked!");
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // log the error to the console
        console.error(
            "The following error occured: "+
            textStatus, errorThrown
        );
    });

    // callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // reenable the inputs
        $inputs.prop("disabled", false);
    });

    // prevent default posting of form
    event.preventDefault();
});
*/
</script>
			<!--<script>
				function confirmDelete(sID) {
					var scheduleID = sID;
					var conf = confirm('Are you sure you want to delete this schedule?');
					if(conf){
						$.ajax({
							type: "POST",
							url: "http://localhost:8080/masterservertest/processes.php",
							data: { sIDs: scheduleID }
							});
						//$.post("processes.php", { action: "delete", sID: scheduleID } );
						location.reload();
					}
				}
			</script>-->
			<?php
					//echo '<script type="text/javascript">','confirmDelete('.$sIDs[$g].');','</script>';
			
		}
	}
	$actionError = '';
	$actionSuccess = '';
	for($p=0; $p<$numFeeders; $p++){
		$userAction = mysqli_query($connection, "SELECT open,command FROM Feeders WHERE fID='".mysql_real_escape_string($feederID1[$p])."'");
		$actionRow = mysqli_fetch_array($userAction);
		if(isset($_POST['openBowl'.$feederID1[$p]])){ //if open bowl is pressed
			//echo $feederID1[$p];
			if($actionRow['open'] == 0){ //if bowl is not open
				mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'");	// set open to 1(true)		
				if($actionRow['command'] != 1){ // if command is not 1(open)
					mysqli_query($connection, "UPDATE Feeders SET command=1 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'"); //set command to 1(open)
				}
				$actionSuccess = 'Success: Bowl is opening.'; //if the bowl is closed, we can open it
			}
			else{
				$actionError = 'Error: Bowl is already opening, wait a moment and try again.'; //if open is already 1, bowl is still in process of opening, don't try again.
			}
		}
		if(isset($_POST['closeBowl'.$feederID1[$p]])){ //if close bowl is pressed
			if($actionRow['command'] != 4){
				mysqli_query($connection, "UPDATE Feeders SET command=4 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'"); //if command is not 4(close) we set it to close.
				$actionSuccess = 'Success: Bowl is Closing.'; //bowl will now close.
			}
			else{
				$actionError = 'Error: Bowl is already closing.'; //if command = 4, bowl is closing and will be set to 0 again by server when it is done.
			}
		}
		if(isset($_POST['snack'.$feederID1[$p]])){ //if snack is pressed
			if($actionRow['open'] == 0){ //if the bowl is closed(0)
				//mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'"); //we open bowl (set open to 1);
				if($actionRow['command'] != 3){ //if command is not 2(snack)
					mysqli_query($connection, "UPDATE Feeders SET command=3 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'"); // set command to snack(begin snack dispensing.
					mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'"); // set command to open bowl.
					$actionSuccess = 'Success: Snack is dispensing and bowl is opening.'; // both commands successful, snack will dispense
				}
			}
			else if($actionRow['open'] == 1){
				$actionError = 'Error: The bowl is opening, cannot dispense snack.';
			}
			else if($actionRow['command'] == 3){
				$actionError = 'Error: A snack is already being dispensed.';
			}
		}
		if(isset($_POST['spinAuger'.$feederID1[$p]])){
			if($actionRow['open'] == 0){
				if($actionRow['command'] != 2){
					mysqli_query($connection, "UPDATE Feeders SET command=2 WHERE fID='".mysql_real_escape_string($feederID1[$p])."'");
					$actionSuccess = 'Success: Auger is spinning!.';
				}
			}
			else if($actionRow['open'] == 1){
				$actionError = 'Error: The bowl is opening cannot spin auger.';
			}
			else if($actionRow['command'] == 2){
				$actionError = 'Error: The auger is already spinning.';
			}
		}
	}
?>
<script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<?php echo $message; 
	  echo $actionError;
	  echo $actionSuccess;
?>
</body>
</html>