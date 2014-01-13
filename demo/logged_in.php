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

		$fID = trim(mysql_prep($_POST['fID']));
		$Name = trim(mysql_prep($_POST['petName']));
		$feederAttach = "'s Feeder";
		$petName = $Name . $feederAttach;
		//echo $petName;
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
<script src="js/jquery.js"></script>
</head>

<body>
<script type='text/javascript' language='javascript'>
function pushCommand(fID, commandF) {
	$.ajax ({
   		type: 'POST',
   		url:'pushCommand.php',
   		data: {SN:fID, command:commandF},
		success: function(data) {
      			document.getElementById('commandOutput'+fID).innerHTML = data;
   		}
	});
}
</script>

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


echo "<span style='width:100px; height:100px; border:grey 2px solid; display: table-cell; text-align: center; vertical-align: middle;'> 
<a href='snapshot_roulette.php?sn=".$feederID1[$q]."'><img src='". getThumb("petpics/", $feederID1[$q]) . "'> </a>
</span>";
					echo "<table class='table table-bordered' style='display:inline-block' id='table".$q."'>
						  <thead>
						  <tr>
						  <th class='lead'><strong>".stripslashes($feeders[$q])."</strong></th>
						  <td>
							<div style='margin: auto;'><button class='btn btn-success' type='button' name='spinAuger".$feederID1[$q]."' onclick='javascript:pushCommand(\"".$feederID1[$q]."\", \"auger\")'>Spin Auger</button>
							<button class='btn btn-info' type='button' name='openBowl".$feederID1[$q]."' onclick='javascript:pushCommand(\"".$feederID1[$q]."\", \"open\")'>Open Bowl</button>
						  	<button class='btn btn-warning' type='button' name='closeBowl".$feederID1[$q]."' onclick='javascript:pushCommand(\"".$feederID1[$q]."\", \"close\")'>Close Bowl</button>
						  	<span style='float: right;'><button class='btn btn-inverse' type='button' style='float: right;' align='right' name='snack".$feederID1[$q]."' onclick='javascript:pushCommand(\"".$feederID1[$q]."\", \"snack\")'><i class='icon-white icon-gift'></i> Snack</button>
						  </span></div>
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
					echo "</tbody></table>";
					
					echo "<div class='row' style='text-align: center' id='commandOutput".$feederID1[$q]."'></div><br><br>";
				}
			?>

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
/* CHANGE THIS AS NEEDED */header("Location: logged_in.php");
		}
	}
?>

<script src="js/bootstrap.min.js"></script>
<?php echo $message; ?>

</body>
</html>
