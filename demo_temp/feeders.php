<?php require_once("includes/connection.php"); 
 require_once("includes/session.php"); 
 require_once("includes/functions.php"); 
 confirm_logged_in(); 
?>
 <?php

		if(isset($_POST['formSubmit']))
		{
			//$userID = mysqli_query($connection, "SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
			$userID = $connection->prepare("SELECT userID FROM Users WHERE email=?");
			$userID->bindValue(1, $_SESSION['email'], PDO::PARAM_STR);
			$userID->execute();
			//$urow = mysqli_fetch_assoc($userID);
			$urow = $userID->fetchALL(PDO::FETCH_ASSOC);
			$feederID = $_SESSION['petFeedID'];
			//echo $feederID;
			//echo $_POST['PetHealth'];
			$petType = $petBreed = $petGender = $petFoodBrand = $petHealth = "";
			$petAge = $petWeight = 0;
			if(isset($_POST['PetType'])){
				$petType = stripslashes(trim(mysql_prep($_POST['PetType'])));
			}
			if(isset($_POST['PetBreed'])){
				$petBreed = stripslashes(trim(mysql_prep($_POST['PetBreed'])));
			}
			if(isset($_POST['PetGender'])){
				$petGender = stripslashes(trim(mysql_prep($_POST['PetGender'])));
			}
			if(isset($_POST['PetAge'])){
				$petAge = $_POST['PetAge'];
			}
			if(isset($_POST['PetWeight'])){
				$petWeight = $_POST['PetWeight'];
			}
			$anAge = $petAge." years";
			$aWeight = $petWeight." lbs";
			if(isset($_POST['PetFoodBrand'])){
				$petFoodBrand = stripslashes(trim(mysql_prep($_POST['PetFoodBrand'])));
			}
			if(isset($_POST['PetHealth'])){
				$petHealth = stripslashes(trim(mysql_prep($_POST['PetHealth'])));
			}
			//echo $petType;
			//echo $petHealth;
			//echo $petGender; echo $petAge; echo $petWeight; echo $petFoodBrand; echo $petHealth; echo $petFunFact;
			//mysqli_query($connection, "UPDATE Feeders SET petType='".mysql_real_escape_string($petType)."', petBreed='".mysql_real_escape_string($petBreed)."', petGender='".mysql_real_escape_string($petGender)."', petAgeYears='".$petAge."', petWeightLbs='".$petWeight."', petFoodBrand='".mysql_real_escape_string($petFoodBrand)."', petFunFact='".mysql_real_escape_string($petFunFact)."' WHERE fID='".$feederID."'");
			mysqli_query($connection, "UPDATE Feeders SET petType='".mysql_real_escape_string($petType)."', petBreed='".mysql_real_escape_string($petBreed)."', petGender='".mysql_real_escape_string($petGender)."', petAgeYears='".$petAge."', petWeightLbs='".$petWeight."', petFoodBrand='".mysql_real_escape_string($petFoodBrand)."', petHealth='".mysql_real_escape_string($petHealth)."' WHERE fID='".$feederID."'");
			$stmt = $connection->prepare("UPDATE Feeders SET petType=?, petBreed=?, petGender=?, petAgeYears=?, petWeightLbs=?, petFoodBrand=?, petHealth=? WHERE fID=?");		
			$stmt->execute(array($petType, $petBreed, $petGender, $petAge, $petWeight, $petFoodBrand, $petHealth, $fID));
			//mysqli_query($connection,"INSERT INTO Schedules(scheduleName, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Everyday, aTime, AMPM, fID, amountFed, userID) VALUES('".$scheduleName."','".$boolM."','".$boolT."','".$boolW."','".$boolTh."','".$boolF."','".$boolSa."','".$boolSu."','".$boolE."','".$aTime."','".$ampm."','".$crow['fID']."','".$amountFed."','".$urow['userID']."')");
			header('Refresh: 2; URL=logged_in.php');
			echo "<p>Pet Info saved successfully, you will be redirected to the managing page in a moment.</p>";
			//exec('pushSchedule.py '.$crow['feederIP'], $output);
		}
					
		if(isset($_POST['formCancel'])){
			redirect_to('logged_in.php');
		}
?>
<html>
  <head>
    <title>GOOD, Inc.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
       
        <link type="text/css" href="css/bootstrap.min.css" />
        <link type="text/css" href="css/bootstrap-timepicker.min.css" />
      </head>  
       

<body>
 <div class="container-fluid">
 <div class="row-fluid">
 <h1><p class="text-center">Optional: Tell Us About Your Pet.</p></h1> <br>
 </div>
<div class="row-fluid">
  <form class="form-horizontal" method="POST" action="feeders.php">
<div class="row-fluid">
 <div class="control-group">
 <div class="span6 offset4">
  <label class="control-label">Type: </label>
  <div class="controls">
   <select name='PetType'>
   <option value=''>Select Pet Type</option>
   <option value='Dog'>Dog</option>
   <option value='Cat'>Cat</option>
   <option value='Other'>Other</option>
   </select>
</div>
</div>
</div>
</div>
<div class="row-fluid">
  <div class="span6 offset4">
  <div class="control-group">
    <label class="control-label" >Breed: </label>
    <div class="controls">
	<input type='text' name='PetBreed' placeholder='Pet Breed'>
    </div>
  </div>
  </div>
  </div>
		
<div class="row-fluid">
  <div class="span6 offset4">
  <div class="control-group">
 <label class="control-label">Gender: </label>
 <div class="controls">
  <input type="radio" name="PetGender" value="Male">
  Male
&nbsp
  <input type="radio" name="PetGender" value="Female">
 Female
</div>
</div>
</div>
</div>
 <div class="row-fluid">
<div class="span6 offset4">
<label class="control-label">Age: </label>
<div class="controls">
<input type="text" name="PetAge" placeholder="Pet Age">
</div>
</div>
</div>
<br>
 <div class="row-fluid">
<div class="span6 offset4">
<label class="control-label">Weight: </label>
<div class="controls">
<input type="text" name="PetWeight" placeholder="Pet Weight">
</div>
</div>
</div>
<br>
 <div class="row-fluid">
<div class="span6 offset4">
<label class="control-label">Food Brand: </label>
<div class="controls">
<input type="text" name="PetFoodBrand" placeholder="Pet Food Brand">
</div>
</div>
</div>
<br>
 <div class="row-fluid">
<div class="span6 offset4">
<label class="control-label">Health: </label>
<div class="controls">
<input type="radio" name="PetHealth" value="Underweight"> Underweight
<input type="radio" name="PetHealth" value="Normal"> Normal
<input type="radio" name="PetHealth" value="Overweight"> Overweight
</div>
</div>
</div>
<br>

<div class="row-fluid">
<div class="span6 offset5">
<button class="btn btn-large btn-primary" type="submit" name="formCancel">Skip</button>
<button class="btn btn-large btn-primary" type="submit" name="formSubmit">Submit</button>
</div>
</div>
</form>


<script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
 <script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
</body>
</html>
