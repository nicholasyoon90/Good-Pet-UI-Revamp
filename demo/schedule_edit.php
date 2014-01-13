<?php require_once("includes/session.php"); 
 require_once("includes/connection.php"); 
 require_once("includes/functions.php"); 
 confirm_logged_in(); 
 //include("includes/header.php"); ?>
  <?php
$sID = $_SESSION['editSchedID'];
$sIDresult = mysqli_query($connection, "SELECT fID,scheduleName,Everyday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday,aTime,AMPM,amountFed FROM Schedules WHERE sID='".mysql_real_escape_string($sID)."'");
$sIDrow = mysqli_fetch_assoc($sIDresult);
$petName = mysqli_query($connection, "SELECT petName FROM Feeders WHERE fID='".mysql_real_escape_string($sIDrow['fID'])."'");
$frow = mysqli_fetch_assoc($petName);
$feederName = $frow['petName']."'s Feeder";
	if(isset($_POST['formSubmit']))
	{
		$userID = mysqli_query($connection, "SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
		$urow = mysqli_fetch_assoc($userID);
		if(isset($_POST['scheduleName'])){
			$scheduleName = htmlspecialchars(stripslashes($_POST['scheduleName']), ENT_QUOTES);
		}
		if(isset($_POST['Days'])){
			$aDay = $_POST['Days'];
			$N = count($aDay);
		}
		if(isset($_POST['Hour'])){
			$anHour = $_POST['Hour'];
		}
		if(isset($_POST['Minute'])){
			$aMinute = $_POST['Minute'];
		}
		$aTime = $anHour.":".$aMinute;
		if(isset($_POST['am_pm'])){
			$am_pm = $_POST['am_pm'];
		}
		$am = false;
		$pm = false;
		$ampm = false;
		if(isset($_POST['Amount'])){
			$amountFed = $_POST['Amount'];
		}
						
		$boolM = $boolT = $boolW = $boolTh = $boolF = $boolSa = $boolSu = $boolE = False;
		if(empty($aDay))
		{
			echo("You did not select any days.");
		}
		else if(($_POST['Amount'])=='')
		{
			echo("You did not enter an amount to feed.");
		}
		else if(empty($am_pm))
		{
			echo("You did not select A.M. or P.M.");
		}
		else
		{
			if($am_pm == 'AM')
			{
				$ampm = False;
			}
			else if($am_pm == 'PM')
			{
				$ampm = True;
			}
			for($i = 0; $i < $N; $i++)
			{
				if($aDay[$i] == 'M')
				{
					$boolM = 1;
				}
				else if($aDay[$i] == 'T')
				{
					$boolT = 1;
				}
				else if($aDay[$i] == 'W')
				{
					$boolW = 1;
				}
				else if($aDay[$i] == 'Th')
				{
					$boolTh = 1;
				}
				else if($aDay[$i] == 'F')
				{
					$boolF = 1;
				}
				else if($aDay[$i] == 'Sa')
				{
					$boolSa = 1;
				}
				else if($aDay[$i] == 'Su')
				{
					$boolSu = 1;
				}
				else if($aDay[$i] == 'E')
				{
					$boolE = 1;
					$boolM = $boolT = $boolW = $boolTh = $boolF = $boolSa = $boolSu = false;
				}
			}
			mysqli_query($connection,"UPDATE Schedules SET scheduleName='".$scheduleName."', Monday='".$boolM."', Tuesday='".$boolT."', Wednesday='".$boolW."', Thursday='".$boolTh."', Friday='".$boolF."', Saturday='".$boolSa."', Sunday='".$boolSu."', Everyday='".$boolE."', aTime='".$aTime."', AMPM='".$ampm."', amountFed='".$amountFed."' WHERE sID='".$sID."'");
			header('Refresh: 2; URL=/demo/logged_in.php');
			echo "<p>The schedule was updated successfully, you will be redirected to the managing page in a moment.</p>";
		}
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
 <h1><p class="text-center">Edit Schedule</p></h1> 
 </div>
<div class="row-fluid">
  <form class="form-horizontal" method="POST" action="schedule_edit.php">
  <div class="span6 offset4">
  <div class="control-group">
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFeeder : <?php echo $feederName; ?>
    <div class="controls">
    </div>
  </div>
  </div>
<div class="row-fluid">
 <div class="control-group">
 <div class="span6 offset4">
  <label class="control-label" for="scheduleName">Schedule Name :</label>
  <div class="controls">
   <input type="text" size="30" maxlength="30" name="scheduleName" value="<?php echo $sIDrow['scheduleName'];?>">
</div>
</div>
</div>
</div>
<div class="row-fluid">
  <div class="span6 offset4">
  <div class="control-group">
    <label class="control-label" >Select the New Amount to be Fed:</label>
    <div class="controls">
     <select name='Amount'>
	 <?php
			$oldAmount = $sIDrow['amountFed'];
			$amo = '';
					if($oldAmount == 0.25) {
						$amo = '1/4';
					}
					else if($oldAmount == 0.50) {
						$amo = '1/2';
					}
					else if($oldAmount == 0.75) {
						$amo = '3/4';
					}
					else if($oldAmount == 1.00) {
						$amo = '1';
					}
					else if($oldAmount == 1.25) {
						$amo = '1 1/4';
					}
					else if($oldAmount == 1.50) {
						$amo = '1 1/2';
					}
					else if($oldAmount == 1.75) {
						$amo = '1 3/4';
					}
					else if($oldAmount == 2.00) {
						$amo = '2';
					}
			$oldAmo = explode(" ", $amo);
			if ($oldAmo[0] != '1'){
				if ($oldAmo[0] == '1/4'){
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.5'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else if ($oldAmo[0] == '1/2'){
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else if ($oldAmo[0] == '3/4'){
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.5'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else if ($oldAmo[0] == '2'){
					echo "<option value='2.00'>2 Cups</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
				}
			}
			else if ($oldAmo[0] == '1'){
				if ($oldAmo[1] == '1/4'){
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else if ($oldAmo[1] == '1/2'){
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else if ($oldAmo[1] == '3/4'){
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
				else{
					echo "<option value='1.00'>1 Cup</option>";
					echo "<option value='0.25'>1/4 Cup</option>";
					echo "<option value='0.50'>1/2 Cup</option>";
					echo "<option value='0.75'>3/4 Cup</option>";
					echo "<option value='1.25'>1 1/4 Cups</option>";
					echo "<option value='1.50'>1 1/2 Cups</option>";
					echo "<option value='1.75'>1 3/4 Cups</option>";
					echo "<option value='2.00'>2 Cups</option>";
				}
			}
	 ?>
				
	</select>
    </div>
  </div>
  </div>
  </div>

<div class="row-fluid">

            <h4 ><p class="text-center" >Select the new days to schedule for.</p></h4>
            </div>
            </div>
<div class="row-fluid">
<div class="span6 offset5">

            <label class="checkbox">

                <input id="Eday" type="checkbox" name="Days[]" value="E" onclick="if (this.checked)
																			 { 
																				document.getElementById('Mday').disabled=true; 
																				document.getElementById('Tday').disabled=true;
																				document.getElementById('Wday').disabled=true;
																				document.getElementById('Thday').disabled=true;
																				document.getElementById('Fday').disabled=true;
																				document.getElementById('Saday').disabled=true;
																				document.getElementById('Suday').disabled=true;
																				
																			 } else 
																			 { 
																				document.getElementById('Mday').disabled = false;
																				document.getElementById('Tday').disabled = false;
																				document.getElementById('Wday').disabled = false;
																				document.getElementById('Thday').disabled = false;
																				document.getElementById('Fday').disabled = false;
																				document.getElementById('Saday').disabled = false;
																				document.getElementById('Suday').disabled = false;
																				
																			 }">Everyday

            </label>
----------------------
             <label class="checkbox ">

                <input id="Mday" type="checkbox" name="Days[]" value="M"> Monday
                </label>

            </label><label class="checkbox ">

                <input id="Tday" type="checkbox" name="Days[]" value="T"> Tuesday

            </label>

            <label class="checkbox ">

                <input id="Wday" type="checkbox" name="Days[]" value="W"> Wednesday

            </label>
            <label class="checkbox ">

                <input id="Thday" type="checkbox" name="Days[]" value="Th"> Thursday

            </label>
            <label class="checkbox ">

                <input id="Fday" type="checkbox" name="Days[]" value="F"> Friday

            </label>
            <label class="checkbox ">

                <input id="Saday" type="checkbox" name="Days[]" value="Sa"> Saturday

            </label>
            <label class="checkbox ">

                <input id="Suday" type="checkbox" name="Days[]" value="Su"> Sunday

            </label>
            </div>
         </div>
         </div>
        
<div class="row-fluid">
<br>
<div class="span6 offset4"> 
   Select a New Feeding Time:
 <select name="Hour">
 <?php
	$oldTime = $sIDrow['aTime'];
	$explTime = explode(":", $oldTime);
	if($explTime[0] == 1)
	{
		echo "<option value='1' selected='selected'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 2)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2" selected="selected">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 3)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3" selected="selected">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 4)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4" selected="selected">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 5)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5" selected="selected">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 6)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6" selected="selected">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 7)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7" selected="selected">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 8)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8" selected="selected">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 9)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9" selected="selected">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 10)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10" selected="selected">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 11)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11" selected="selected">11</option>';
		echo '<option value="12">12</option>';		
	}
	else if($explTime[0] == 12)
	{
		echo "<option value='1'>1</option>";
		echo '<option value="2">2</option>';
		echo '<option value="3">3</option>';
		echo '<option value="4">4</option>';
		echo '<option value="5">5</option>';
		echo '<option value="6">6</option>';
		echo '<option value="7">7</option>';
		echo '<option value="8">8</option>';
		echo '<option value="9">9</option>';
		echo '<option value="10">10</option>';
		echo '<option value="11">11</option>';
		echo '<option value="12" selected="selected">12</option>';		
	}
			
?>
<!--<option value="">Hour</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>-->
</select>

 :
<select name="Minute">
<!--<option value="">Minute</option>-->
<?php
	$oldMin = $explTime[1];
	for ($f=0; $f<10; $f++)
	{
		if($f == $oldMin)
		{
		?>
			<option value="<?php echo "0".$f;?>" selected="selected"><?php echo "0".$f;?></option>
		<?php
		}
		else
		{
		?>
			<option value="<?php echo "0".$f;?>"><?php echo "0".$f;?></option>
		<?php
		}
	}
	for ($f=10; $f<60; $f++)
	{
		if($f == $oldMin)
		{
		?>
            <option value="<?php echo $f;?>" selected="selected"><?php echo $f;?></option>
        <?php
		}
		else
		{
		?>
			<option value="<?php echo $f;?>"><?php echo $f;?></option>
		<?php
		}
	}
?>
	
</select>

 <label class="radio inline">
 <?php
  $oldAMPM = $sIDrow['AMPM'];
  if($oldAMPM == 0)
  {
	echo '<input type="radio" name="am_pm" value="AM" checked="checked">';
  }
  else
  {
	echo '<input type="radio" name="am_pm" value="AM">';
  }
 ?>
  AM
</label>
<label class="radio inline">
 <?php
  $oldAMPM = $sIDrow['AMPM'];
  if($oldAMPM == 1)
  {
	echo '<input type="radio" name="am_pm" value="PM" checked="checked">';
  }
  else
  {
	echo '<input type="radio" name="am_pm" value="PM">';
  }
 ?>
 PM
</label>
</div>
</div>
</div>
 <div class="row-fluid">
<div class="span6 offset5">
</div>
</div>
 <div class="row-fluid">
<div class="span6 offset5">
</div>
</div>
<div class="row-fluid">
<div class="span6 offset5">
<button class="btn btn-large btn-primary" type="submit" name="formSubmit">Update</button> 
<button class="btn btn-large btn-primary" type="submit" name="formCancel">Cancel</button>
</div>
</div>
</form>


<script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
 <script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
</body>
</html>
<?php 	echo "<br><div class='span6 offset4'>";
		include("includes/footer.php");
		echo "</div>";
?>