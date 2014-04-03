<?php require_once("includes/connection.php"); 
 require_once("includes/session.php"); 
 require_once("includes/functions.php"); 
 require_once("includes/PasswordHash.php");
 confirm_logged_in(); 
?>
 <?php
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
			if(isset($_POST['Feeders'])){
				$aFeeder = stripslashes(trim(mysql_prep($_POST['Feeders'])));
				$aNameExplode = explode("'", $aFeeder);
				$feederID = mysqli_query($connection,"SELECT fID,feederIP FROM Feeders WHERE petName ='".mysql_real_escape_string($aNameExplode[0])."' AND userID='".$urow['userID']."'");
				$crow = mysqli_fetch_array($feederID);
				//echo $aFeeder;
			}
			if(isset($_POST['Amount'])){
				$amountFed = $_POST['Amount'];
			}
						
			$boolM = $boolT = $boolW = $boolTh = $boolF = $boolSa = $boolSu = $boolE = False;
			if(empty($aDay))
			{
				echo("You did not select any days.");
			}
			else if(($_POST['Feeders'])=='')
			{
				echo("You did not select a feeder.");
			}
			else if(($_POST['Amount'])=='0')
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
					$am = True;
					$ampm = False;
				}
				else if($am_pm == 'PM')
				{
					$pm = True;
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
				mysqli_query($connection,"INSERT INTO Schedules(scheduleName, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Everyday, aTime, AMPM, fID, amountFed, userID) VALUES('".$scheduleName."','".$boolM."','".$boolT."','".$boolW."','".$boolTh."','".$boolF."','".$boolSa."','".$boolSu."','".$boolE."','".$aTime."','".$ampm."','".$crow['fID']."','".$amountFed."','".$urow['userID']."')");
				header('Refresh: 2; URL=logged_in.php');
				echo "<p>The schedule was created successfully, you will be redirected to the managing page in a moment.</p>";
				//exec('pushSchedule.py '.$crow['feederIP'], $output);
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
 <h1><p class="text-center">New Schedule</p></h1> 
 </div>
<div class="row-fluid">
  <form class="form-horizontal" method="POST" action="schedules.php">
  <div class="span6 offset4">
  <div class="control-group">
    <label class="control-label" >Feeder :</label>
    <div class="controls">
     <select name='Feeders'>
  <?php	//grants the user an option to select their feeder - this is being changed soon.
			$userID = mysqli_query($connection, "SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
				  $arow = mysqli_fetch_assoc($userID);
				  $feederName = mysqli_query($connection, "SELECT petName FROM Feeders WHERE userID='".mysql_real_escape_string($arow['userID'])."'");
				  $num = mysqli_num_rows($feederName);
				  while($row = mysqli_fetch_array($feederName)){
					echo "<option value='".htmlspecialchars(stripslashes($row['petName'] . "'s Feeder"), ENT_QUOTES)."'>".stripslashes($row['petName'] . "'s Feeder")."</option>";
				  }
  ?>
</select>
    </div>
  </div>
  </div>
<div class="row-fluid">
 <div class="control-group">
 <div class="span6 offset4">
  <label class="control-label" for="scheduleName">Schedule Name:</label>
  <div class="controls">
   <input type="text" size="30" maxlength="30" name="scheduleName" placeholder="Schedule Name">
</div>
</div>
</div>
</div>
<div class="row-fluid">
  <div class="span6 offset4">
  <div class="control-group">
    <label class="control-label" >Amount to be Fed:</label>
    <div class="controls">
     <select name='Amount'>
			<option value='0'>Select Amount</option>
			<option value='.25'>1/4 Cup</option>
			<option value='.5'>1/2 Cup</option>
			<option value='.75'>3/4 Cup</option>
			<option value='1'>1 Cup</option>
			<option value='1.25'>1 1/4 Cups</option>
			<option value='1.5'>1 1/2 Cups</option>
			<option value='1.75'>1 3/4 Cups</option>
			<option value='2'>2 Cups</option>
	</select>
    </div>
  </div>
  </div>
  </div>

<div class="row-fluid">

            <h4 ><p class="text-center" >Which days would you like to schedule for?</p></h4>
            </div>
            </div>
<div class="row-fluid">
<div class="span6 offset5">
            <label class="checkbox">
				<!--if everyday is checked, disable the other check boxes, and re enable when everyday is unchecked.-->
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
   Select a Feeding Time:
 <select name="Hour">
<option value="">Hour</option>
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
<option value="12">12</option>
</select>

 :
<select name="Minute">
<option value="">Minute</option>
<?php
	for ($f=0; $f<10; $f++)
	{
		?>
			<option value="<?php echo "0".$f;?>"><?php echo "0".$f;?></option>
		<?php
	}
	for ($f=10; $f<60; $f++)
	{
		?>
            <option value="<?php echo $f;?>"><?php echo $f;?></option>
        <?php
	}
?>
	
</select>

 <label class="radio inline">
  <input type="radio" name="am_pm" value="AM">
  AM
</label>
<label class="radio inline">
  <input type="radio" name="am_pm" value="PM">
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
<button class="btn btn-large btn-primary" type="submit" name="formSubmit">Save</button> 
<button class="btn btn-large btn-primary" type="submit" name="formCancel">Cancel</button>
</div>
</div>
</form>


<script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
 <script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
</body>
</html>
<?php 	//include our footer for now, will be changed.

		echo "<br><div class='span6 offset4'>";
		include("includes/footer.php");
		echo "</div>";
?>