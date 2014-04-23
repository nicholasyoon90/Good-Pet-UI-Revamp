<?php require_once("includes/connection.php"); 
 require_once("includes/session.php"); 
 require_once("includes/functions.php"); 
 require_once("includes/PasswordHash.php");
 if(!logged_in()) {
   redirect_to("login.php");
 }
?>
<?php

      $message = "Awesome! Let's setup a feeding schedule.";
      $message2 = "We'll use a simple everyday schedule for now, but you can customize it later.";
      
      if(isset($_POST['formSubmit']))
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
      <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

	</head>
	<body>
      <form action="page9.php" method="POST">
      <div class="wrapper">
   		<div class="absolute">
   			<p class="p1"><?php echo $message; ?></p>
   			<p class="p4"><?php echo $message2; ?></p>			
   		</div>
         <div class="con_container clearfix">
      		<div class="inputfields">
               <div id="addinput">
                  <p>
                  <!--<a href="#" id="addNew"><button class="button buttonScale" type="button" class="btn btn-default btn-small">ADD NEW</button></a> <br>
                  <input class = "input inputIn input100" type="time" name="time" id="p_new" name="p_new"/>
                  <input class = "input inputIn input10" type="text" name="Amount" id="p_new" name="p_new" placeholder="1.5 CUPS" />
                  <a href="#" id="remNew"><button class="button X" type="button" class="btn btn-default btn-medium">X</button></a>
                  <button class="button" type="submit" name="formSubmit" class="btn btn-default btn-small">CREATE SCHEDULE</button>
                  -->
                     <div class="styled-select inputIn">
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
                     </div>
                     <div class="styled-select inputIn">
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
                     </div>
                     <div class="styled-select inputIn">
                        <select name="am_pm">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                        </select>
                     </div>
                     <div class="styled-select inputIn">
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
                     <button class="button" type="submit" name="formSubmit" class="btn btn-default btn-small">ADD SCHEDULE</button>
                  </p>
               </div>
            </div>
         </div>
      </form>

      <div class="footer">
         <div class="nav_container clearfix">
            <div class="timeline">
               <div id="pager">
                  <a href="#" class="">1</a>
                  <a href="#" class="">2</a>
                  <a href="#" class="">3</a>
                  <a href="#" class="">4</a>
                  <a href="#" class="">5</a>
                  <a href="#" class="">6</a>
                  <a href="#" class="">7</a>
                  <a href="page8.php" class="">8</a>
                  <a href="#" class="activeSlide">9</a>
                  <a href="page10.php" class="">10</a>
                 
               </div>
            </div>
         </div>

         <div class="but_container clearfix">
            <div class="back">
               <a href="page8.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
            </div>
            <div class="next">
               <a href="page10.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
            </div> 
         </div>
      </div>
   </div>
	</body>

    <script type="text/javascript">
      $(function() {
            var addDiv = $('#addinput');
            var i = $('#addinput p').size() + 1;
         $('#addNew').live('click', function() {
            $('<p><input class = "input inputIn input100" type="time" id="p_new" name="p_new_' + i +'" value="" /> <input class = "input inputIn input10" type="text" id="p_new" name="p_new_' + i +'" value="" placeholder="1.5 CUPS" /> <a href="#" id="remNew"><button class="button X" type="button" class="btn btn-default btn-medium">X</button></a> </p>').appendTo(addDiv);
            i++;

            return false;
         });

         $('#remNew').live('click', function() {
            if( i > 2 ) {
               $(this).parents('p').remove();
               i--;
            }
            return false;
         });
      });
      </script>

      <script src="js/flowtype.js"></script>
      <script>
         jQuery(document).ready(function(){
         jQuery('body').flowtype();
         });
      </script>
</html>