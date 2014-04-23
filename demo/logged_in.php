<?php require_once("includes/session.php");
 require_once("includes/connection.php");
 require_once("includes/functions.php");
 require_once("includes/PasswordHash.php");
 require_once("includes/makeThumb.php");
 confirm_logged_in();
 ob_start();
 //include("includes/header.php"); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GOOD, Inc.</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/panel.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/setup.css" rel="stylesheet">

</head>

<body>
    <?php
                //grab all data relevant to schedules that needs to be displayed, and dynamically add it into table format on the webpage
                $numSchedules = 0;
                //$userID = mysqli_query($connection,"SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
                $userID = $connection->prepare("SELECT userID FROM Users WHERE email=?");
                $userID->execute(array($_SESSION['email']));
                //$arow = mysqli_fetch_array($userID);
                $arow = $userID->fetchAll(PDO::FETCH_ASSOC);
                //$feederName = mysqli_query($connection,"SELECT petName,fID FROM Feeders WHERE userID='".mysql_real_escape_string($arow['userID'])."'");
                //$numFeeders = mysqli_num_rows($feederName);
                $feederName = $connection->prepare("SELECT petName,fID,petType,petFoodBrand,petHealth,petAgeYears,petWeightLbs,petBreed,petGender FROM Feeders WHERE userID=?");
                $feederName->execute(array($arow[0]['userID']));
                $numFeeders = $feederName->rowCount();
                //echo $numFeeders;
                $feeders = array();
                $petTypes = array();
                $petBreeds = array();
                $petGenders = array();
                $petAges = array();
                $petWeights = array();
                $petHealths = array();
                $petFoods = array();
                $i = $j = $k = $x = $l = $q = 0;
                $feederID1 = array();
                $feederID2 = array();
                $snames = array();
                //$scheduleID = mysqli_query($connection,"SELECT sID,scheduleName,fID,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday,Everyday,aTime,AMPM,amountFed FROM Schedules WHERE userID ='".mysql_real_escape_string($arow['userID'])."'");
                $scheduleID = $connection->prepare("SELECT sID,scheduleName,fID,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday,Everyday,aTime,AMPM,amountFed FROM Schedules WHERE userID=?");
                $scheduleID->execute(array($arow[0]['userID']));
                if($scheduleID != False){
                    //$numSchedules = mysqli_num_rows($scheduleID);
                    $numSchedules = $scheduleID->rowCount();
                    //echo $numSchedules;
                }
                $days = array();
                $ampm = array();
                $am_and_pm = array();
                $times = array();
                $petNames = array();
                $amountFed = array();
                $row1 = $feederName->fetchAll(PDO::FETCH_ASSOC);
                  foreach($row1 as $row11){//while($row1 = $feederName->fetch(PDO::FETCH_ASSOC)/*mysqli_fetch_array($feederName)*/){
                    $capName = strtoupper(stripslashes($row11['petName']));
                    $petNames[$i] = $capName;
                    $feeders[$i] = stripslashes($row11['petName'] . "'s Feeder");
                    $feederID1[$i] = $row11['fID'];
                    $petTypes[$i] = $row11['petType'];
                    $petBreeds[$i] = $row11['petBreed'];
                    $petGenders[$i] = $row11['petGender'];
                    $petAges[$i] = $row11['petAgeYears'];
                    $petWeights[$i] = $row11['petWeightLbs'];
                    $petHealths[$i] = $row11['petHealth'];
                    $petFoods[$i] = $row11['petFoodBrand'];
                    $i++;
                  }
                  //might have to do for loops instead of whiles. or for each. seems to be an issue with numfeeders/numschedules and lines in error.
                  if($numSchedules != 0){
                  $row2 = $scheduleID->fetchAll(PDO::FETCH_ASSOC);
                  foreach($row2 as $row22){//while($row2 = $scheduleID->fetch(PDO::FETCH_ASSOC)/*mysqli_fetch_array($scheduleID)*/){
                    //echo $row2['scheduleName'];
                    $snames[$j] = stripslashes($row22['scheduleName']);
                    $sIDs[$j] = $row22['sID'];
                    $feederID2[$j] = $row22['fID'];
                    //echo $feederID2[0];
                    $am_and_pm[$j] = $row22['AMPM'];
                    //$pm = $row2['PM'];
                    $amount = $row22['amountFed'];
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
                    $time = $row22['aTime'];
                    if($row22['Monday'] == 1) {
                        if($row22['Tuesday'] == 1 || $row22['Wednesday'] == 1 || $row22['Thursday'] == 1 || $row22['Friday'] == 1 || $row22['Saturday'] == 1 || $row22['Sunday'] == 1 ){
                            $dayString .= 'Monday, ';
                        }
                        else{
                            $dayString .= 'Monday';
                        }
                    }

                    if($row22['Tuesday'] == 1) {
                        if($row22['Wednesday'] == 1 || $row22['Thursday'] == 1 || $row22['Friday'] == 1 || $row22['Saturday'] == 1 || $row22['Sunday'] == 1 ){
                            $dayString .= 'Tuesday, ';
                        }
                        else{
                            $dayString .= 'Tuesday';
                        }
                    }
                    if($row22['Wednesday'] == 1) {
                        if($row22['Thursday'] == 1 || $row22['Friday'] == 1 || $row22['Saturday'] == 1 || $row22['Sunday'] == 1 ){
                            $dayString .= 'Wednesday, ';
                        }
                        else{
                            $dayString .= 'Wednesday';
                        }
                    }
                    if($row22['Thursday'] == 1) {
                        if($row22['Friday'] == 1 || $row22['Saturday'] == 1 || $row22['Sunday'] == 1 ){
                            $dayString .= 'Thursday, ';
                        }
                        else{
                            $dayString .= 'Thursday';
                        }
                    }
                    if($row22['Friday'] == 1) {
                        if($row22['Saturday'] == 1 || $row22['Sunday'] == 1 ){
                            $dayString .= 'Friday, ';
                        }
                        else{
                            $dayString .= 'Friday';
                        }
                    }
                    if($row22['Saturday'] == 1) {
                        if($row22['Sunday'] == 1 ){
                            $dayString .= 'Saturday, ';
                        }
                        else{
                            $dayString .= 'Saturday';
                        }
                    }
                    if($row22['Sunday'] == 1) {
                        $dayString .= 'Sunday';
                    }
                    if($row22["Everyday"] == 1) {
                        $dayString .= 'Everyday ';
                    }
                    $times[$j] = $time;
                    if($am_and_pm[$j] == 1){
                        $ampm[$j] = "PM";
                    }
                    else if($am_and_pm[$j] == 0){
                        $ampm[$j] = "AM";
                    }
                    $days[$j] = $dayString;
                    $explodedDays = explode(" ", $dayString);
                    $amountFed[$j] = $amo;
                    $j++;
                  }
                 }
?>
<form action="logged_in.php" method="POST">
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            
            <ul class="sidebar-nav">
                
                <div class="side-logo"></div>

                <li class="active">
                    <a href="#"><?php echo $petNames[0]; ?></a>
                </li>
<?php
for($q=0; $q<$numFeeders; $q++){
    $q++;
    echo "<li><a href='#'>".$petNames[$q]."</a></li>";
}
?>
                <li>
                    <a href="page1.php">ADD NEW PET &nbsp &nbsp &nbsp &nbsp <img src = "img/circlePlus.png"/> </a> 
                </li>

                <!--Sidebar bottom justification-->
                <div id="sidebar-bottom">
                    <li><a href="http://buygood.us/contact.php">GIVE FEEDBACK</a>
                    </li>
                    <li><a href="#">ACCOUNT</a>  
                    </li>
                    <li><a href="logout.php">LOG OUT</a>
                    </li>
                </div>

            </ul>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <!--<div class="content-header">
                    <a id="menu-toggle" href="#" class="btn btn-default"><i clas="icon-reorder"></i></a>
                    <center><img src="/template/img/photo.jpg"></center>
            </div>-->
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
                <a id="menu-toggle" href="#" class="btn btn-default">Menu<i class="icon-reorder"></i></a>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pic"><img src="img/pet_pic.png"></div>
                        <p class="p1 snack">I've been good! Could I have a snack?</p>
                        <br> 
                        <div class="snack">
                            <button class="button b" type="submit" name="formSubmit">GIVE SNACK NOW</button>
                            <button class="button b" type="submit" name="formSubmit">OPEN FEEDER</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
            <div class="panel panel-good">
                <div class="panel-heading">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="pull-left"><a href="#tab1" data-toggle="tab" class="p6">SCHEDULE</a></li>
                        <li class="active pull-right"><a href="#tab2" data-toggle="tab" class="p6">SETTINGS <span class="glyphicon glyphicon-cog"></span></a></li>
                    </ul>
                </div>
				

                <div class="panel-body">
                    <div class="tab-content">


                        <!--form input for settings-->
                        <div class="tab-pane" id="tab1">
                            <div class="col-md-4">
                                <p class="p5">MONDAY-THURSDAY, FRIDAY</p>
                                <div class="scheduler">
                                    <p class="p6"><b>9 AM</b>: 1.5 CUPS</p>
                                    <p class="p6"><b>6:30 PM</b>: 1 CUP</p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <p class="p5">NOTIFICATIONS</p>
                                <div class="notifs">
                                    <p class="p5">The Feeder Jammed</p>
                                    <p class="p5">Kona didn't eat his breakfast!</p>
                                    <p class="p5">Kona ate his dinner</p>
                                </div>
                            </div>

                        </div>

          

                        <!--form input for schedules-->
                        <div class="tab-pane active" id="tab2">
                            <!--start the form class for input fields-->
                            <div class="col-md-6">
                                <p class="p5">PET INFO</p>
    							<div class="pet_info">
                                    <form name="petInfo" action="logged_in.php" method="POST">
                <?php //for($q=0; $q<$numFeeders; $q++){
                            //
                        //}
                ?>
    							<!--PET INFO-->			
    								<!--NAME-->
    								<?php echo '<input class = "input inputIn" type="text" value="'.$petNames[0].'" placeholder="NAME" />'; ?>
    								   
    								<!--TYPE-->
    								<div class="styled-select inputIn">
    	            					<?php if($petTypes[0] == "Dog") { 
                                            echo '
                                            <select> 
    						            	 <option value="Dog" selected>'.$petTypes[0].'</option>
    						                 <option value="Cat">Cat</option>
    	            					    </select>';
                                            }
                                            else if($petTypes[0] == "Cat") {
                                                echo '
                                                <select>
                                                <option value="Cat" selected>'.$petTypes[0].'<option>
                                                <option value="Dog">Dog</option>
                                                </select>';
                                            }
                                            else {
                                                echo '
                                                <select>
                                                    <option value="" disabled selected>TYPE</option>
                                                    <option value="Dog">Dog</option>
                                                    <option value="Cat">Cat</option>
                                                </select>';
                                            }
                                        ?>
             						</div>
    									
    								<!--BREED-->
    								<div class="styled-select inputIn">
                                        <?php if($petBreeds[0] == "") {
                                            echo '
    	            					<select> 
    						            	<option value="" disabled selected>BREED</option>
    						                <option>Pomeranian</option>
    						                <option>Beagle</option>
    						                <option>Maltese</option>
    	            					</select>';
                                            }
                                            else if($petBreeds[0] == "Pomeranian"){
                                                echo '
                                                <select>
                                                    <option selected>'.$petBreeds[0].'</option>
                                                    <option>Beagle</option>
                                                    <option>Maltese</option>
                                                </select>';
                                            }
                                            else if($petBreeds[0] == "Beagle"){
                                                echo '
                                                <select>
                                                    <option selected>'.$petBreeds[0].'</option>
                                                    <option>Pomeranian</option>
                                                    <option>Maltese</option>
                                                </select>';
                                            }
                                            else if($petBreeds[0] == "Maltese"){
                                                echo '
                                                <select>
                                                    <option selected>'.$petBreeds[0].'</option>
                                                    <option>Pomeranian</option>
                                                    <option>Beagle</option>
                                                </select>';
                                            }
                                        ?>
             						</div>
    									
    								<!--GENDER-->
    								<div class="styled-select inputIn">
                                        <?php if($petGenders[0] == "") {
                                            echo '
    	            					<select> 
    						            	<option value="" disabled selected>GENDER</option>
    						                <option>Male</option>
    						                <option>Female</option>
    	            					</select>';
                                        }
                                        else if($petGenders[0] == "Male") {
                                            echo '
                                        <select>
                                            <option selected>'.$petGenders[0].'</option>
                                            <option>Female</option>
                                        </select>';
                                        }
                                        else if($petGenders[0] == "Female") {
                                            echo '
                                            <select>
                                                <option selected>'.$petGenders[0].'</option>
                                                <option>Male</option>
                                            </select>';
                                        }
                                    ?>
             						</div>
    									
    								<!--AGE-->
    								<?php echo '<input class = "input inputIn" type="number" value="'.$petAges[0].' Years" placeholder="AGE (in years)" />'; ?>
    									
    								<!--WEIGHT-->
    								<?php echo '<input class = "input inputIn" type="number" value="'.$petWeights[0].' Lbs" placeholder="WEIGHT (in lbs)" />'; ?>
    									
    								<!--FOOD BRAND-->
    								<div class="styled-select inputIn">
                                        <?php if($petFoods[0] == "") {
                                            echo '
                						<select> 
    						                <option value="" disabled selected>FOOD BRAND</option>
    						                <option>All Brand</option>
    						                <option>Acana</option>
    						                <option>Advance Pet Diets - Select Choice All Natural</option>
    						                <option>Alpo</option>
    						                <option>Annamaet</option>
    				            		</select>';
                                        }
                                        else if($petFoods[0] == "All Brand") {
                                            echo '
                                        <select> 
                                            <option selected>All Brand</option>
                                            <option>Acana</option>
                                            <option>Advance Pet Diets - Select Choice All Natural</option>
                                            <option>Alpo</option>
                                            <option>Annamaet</option>
                                        </select>';
                                        }
                                        else if($petFoods[0] == "Acana") {
                                            echo '
                                        <select> 
                                            <option>All Brand</option>
                                            <option selected>Acana</option>
                                            <option>Advance Pet Diets - Select Choice All Natural</option>
                                            <option>Alpo</option>
                                            <option>Annamaet</option>
                                        </select>';
                                        }
                                        else if($petFoods[0] == "Advance Pet Diets - Select Choice All Natural") {
                                            echo '
                                        <select> 
                                            <option>All Brand</option>
                                            <option>Acana</option>
                                            <option selected>Advance Pet Diets - Select Choice All Natural</option>
                                            <option>Alpo</option>
                                            <option>Annamaet</option>
                                        </select>';
                                        }
                                        else if($petFoods[0] == "Alpo") {
                                            echo '
                                        <select> 
                                            <option>All Brand</option>
                                            <option>Acana</option>
                                            <option>Advance Pet Diets - Select Choice All Natural</option>
                                            <option selected>Alpo</option>
                                            <option>Annamaet</option>
                                        </select>';
                                        }
                                        else if($petFoods[0] == "Annamaet") {
                                            echo '
                                        <select> 
                                            <option>All Brand</option>
                                            <option>Acana</option>
                                            <option>Advance Pet Diets - Select Choice All Natural</option>
                                            <option>Alpo</option>
                                            <option selected>Annamaet</option>
                                        </select>';
                                        }
                                    ?>
             						</div>
    									
    								<!--HEALTH-->
    								<div class="styled-select inputIn">
                                    <?php if($petHealths[0] == "") {
                                        echo '
                						<select> 
    						                <option value="" disabled selected>HEALTH</option>
    						                <option>Overweight</option>
    						                <option>Underweight</option>
    						                <option>Healthy</option>
    				            		</select>';
                                        }
                                        else if($petHealths[0] == "Overweight") {
                                            echo '
                                        <select> 
                                            <option selected>Overweight</option>
                                            <option>Underweight</option>
                                            <option>Healthy</option>
                                        </select>';
                                        }
                                        else if($petHealths[0] == "Underweight") {
                                            echo '
                                        <select> 
                                            <option>Overweight</option>
                                            <option selected>Underweight</option>
                                            <option>Healthy</option>
                                        </select>';
                                        }
                                        else if($petHealths[0] == "Healthy") {
                                            echo '
                                        <select> 
                                            <option>Overweight</option>
                                            <option>Underweight</option>
                                            <option selected>Healthy</option>
                                        </select>';
                                        }
                                    ?>
             						</div>
    							 <button class="button" type="submit" name="petInfo" class="btn btn-default btn-small">UPDATE PET INFO</button>
    							</form>
                                </div>
                            </div>
							
							<div class="col-md-6">
    							<?php
                                      $message = "Awesome! Let's setup a feeding schedule.";
                                      $message2 = "We'll use a simple everyday schedule for now, but you can customize it later.";
                                      
                                      if(isset($_POST['addSchedule']))
                                      {
                                         //$userID = mysqli_query($connection, "SELECT userID FROM Users WHERE email='".mysql_real_escape_string($_SESSION['email'])."'");
                                         $userID = $connection->prepare("SELECT userID FROM Users WHERE email=?");
                                         $userID->execute(array($_SESSION['email']));
                                         //$urow = mysqli_fetch_assoc($userID);
                                         $urow = $userID->fetchAll(PDO::FETCH_ASSOC);
                                         $am = false;
                                         $pm = false;
                                         $ampm;
                                         $feederID = $_SESSION['petFeedID'];
                                         if(isset($_POST['Hour'])){
                                            $anHour = $_POST['Hour'];
                                         }
                                         if(isset($_POST['Minute'])){
                                            $aMinute = $_POST['Minute'];
                                         }
                                         $aTime = $anHour.":".$aMinute;
                                         if(isset($_POST['Amount'])){
                                            $amountFed = $_POST['Amount'];
                                         }
                                         if(isset($_POST['am_pm'])){
                                            $am_pm = $_POST['am_pm'];
                                         }
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
                                            //mysqli_query($connection,"INSERT INTO Schedules(scheduleName, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Everyday, aTime, AMPM, fID, amountFed, userID) VALUES('".$scheduleName."','".$boolM."','".$boolT."','".$boolW."','".$boolTh."','".$boolF."','".$boolSa."','".$boolSu."','".$boolE."','".$aTime."','".$ampm."','".$crow[$i]['fID']."','".$amountFed."','".$urow['userID']."')");
                                         $schIns = $connection->prepare("INSERT INTO Schedules(scheduleName, Everyday, aTime, AMPM, fID, amountFed, userID) VALUES(:scheduleName, :boolE, :aTime, :ampm, :fID, :amountFed, :userID)");
                                         $schIns->execute(array(':scheduleName' => "Default", ':boolE' => 1, ':aTime' => $aTime, ':ampm' => $ampm, ':fID' => $feederID, ':amountFed' => $amountFed, ':userID' => $urow[0]['userID']));
                                         if($schIns){
                                            $message = 'Schedule created successfully.';
                                            $message2 = 'click Next.';
                                         }
                                            //eader('Refresh: 2; URL=logged_in.php');
                                            //echo "<p>The schedule was created successfully, you will be redirected to the managing page in a moment.</p>";
                                            //exec('pushSchedule.py '.$crow['feederIP'], $output);
                                      }            
                                ?>
                                <p class ="p5">GENERAL PREFERENCES</p>
    							<div class="gen_pref clearfix">
                                    <form action="logged_in.php" method="POST" name="addSchedule">
    							<!--General Preferences-->
                                    <?php echo '<p class = "p5">WHEN DOES '.$petNames[0].' EAT?<p>'; ?>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                    <option value="" disabled selected>HOUR</option>
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
                                        </div>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                 <option value="" disabled selected>MINUTE</option>
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
                                        </div>
                                        <div class="styled-select inputIn">
                                           <select>
                                           <option value="" disabled selected>AM/PM</option>
                                           <option value="AM">AM</option>
                                           <option value="PM">PM</option>
                                           </select>
                                        </div>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                    <option value="" disabled selected>SELECT AMOUNT</option>
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
                                        <button class="button" type="submit" name="addSchedule">ADD SCHEDULE</button>

    							</form>
    						    </div>
                            </div>
							
                            <div class="col-md-6">
                                <p class ="p5">PET PORTRAIT</p>	
                                <div class="pet_portrait">
                                   <input class = "input inputIn" type="file" />
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>
</form>

    <!-- JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/flowtype.js"></script>
    <script>
        jQuery(document).ready(function(){
        jQuery('body').flowtype();
        });
    </script>
</body>

</html>
