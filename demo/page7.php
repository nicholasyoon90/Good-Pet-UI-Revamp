<?php require_once("includes/connection.php"); 
 require_once("includes/session.php"); 
 require_once("includes/functions.php"); 
  if(!logged_in()) {
   redirect_to("login.php");
 }
?>
<?php
    $message = "Let's get some info about your pet.";
    $message2 = "(click next to skip)";
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
      $petFoodBrand = "";
      if(isset($_POST['petFoodBrand'])){
            $petFoodBrand = stripslashes(trim(mysql_prep($_POST['petFoodBrand'])));
         }
      $anAge = $petAge." years";
      $aWeight = $petWeight." lbs";
      //echo $petType;
      //echo $petHealth;
      //echo $petGender; echo $petAge; echo $petWeight; echo $petFoodBrand; echo $petHealth; echo $petFunFact;
      //mysqli_query($connection, "UPDATE Feeders SET petType='".mysql_real_escape_string($petType)."', petBreed='".mysql_real_escape_string($petBreed)."', petGender='".mysql_real_escape_string($petGender)."', petAgeYears='".$petAge."', petWeightLbs='".$petWeight."', petFoodBrand='".mysql_real_escape_string($petFoodBrand)."', petFunFact='".mysql_real_escape_string($petFunFact)."' WHERE fID='".$feederID."'");
      //mysqli_query($connection, "UPDATE Feeders SET petType='".mysql_real_escape_string($petType)."', petBreed='".mysql_real_escape_string($petBreed)."', petGender='".mysql_real_escape_string($petGender)."', petAgeYears='".$petAge."', petWeightLbs='".$petWeight."', petFoodBrand='".mysql_real_escape_string($petFoodBrand)."', petHealth='".mysql_real_escape_string($petHealth)."' WHERE fID='".$feederID."'");
      $stmt = $connection->prepare("UPDATE Feeders SET petFoodBrand=? WHERE fID=?");    
      $stmt->execute(array($petFoodBrand, $feederID));
      if($stmt){
        $message = 'Pet information updated successfully.';
        $message2 = '(click next to continue)';
      }
      //mysqli_query($connection,"INSERT INTO Schedules(scheduleName, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Everyday, aTime, AMPM, fID, amountFed, userID) VALUES('".$scheduleName."','".$boolM."','".$boolT."','".$boolW."','".$boolTh."','".$boolF."','".$boolSa."','".$boolSu."','".$boolE."','".$aTime."','".$ampm."','".$crow['fID']."','".$amountFed."','".$urow['userID']."')");
      //header('Refresh: 2; URL=logged_in.php');
      //echo "<p>Pet Info saved successfully, you will be redirected to the managing page in a moment.</p>";
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
		<script src="js/flowtype.js"></script>
      <script>
         jQuery(document).ready(function(){
         jQuery('body').flowtype();
         });
      </script>
	</head>
	<body>
<div class="wrapper">
		<div class="absolute">
         <p class="p1"><?php echo $message; ?></p>
         <p class="p4"><?php echo $message2; ?></p>
		</div>
      <form action="page7.php" method="POST">
		<div class="inputfields">
         <div class="styled-select inputIn">
            <select name="petFoodBrand"> 
               <option value="" disabled selected>FOOD BRAND</option>
               <option>All Brand</option>
               <option>Acana</option>
               <option>Advance Pet Diets - Select Choice All Natural</option>
               <option>Alpo</option>
               <option>Annamaet</option>
            </select>
         </div>
         <input class = "input inputIn" name="petFoodFormula" type="search" placeholder="FORMULA" />
         <button class="button" type="submit" name="formSubmit" class="btn btn-default btn-small">UPDATE PET INFO</button>
      </form>
      </div>
        <div class="timeline">
            <div id="pager">
               <a href="#" class="">1</a>
               <a href="#" class="">2</a>
               <a href="#" class="">3</a>
               <a href="#" class="">4</a>
               <a href="#" class="">5</a>
               <a href="page6.php" class="">6</a>
               <a href="#" class="activeSlide">7</a>
               <a href="page8.php" class="">8</a>
               <a href="#" class="">9</a>
               <a href="#" class="">10</a>
               <a href="#" class="">11</a>
            </div>
            <input class = "input inputIn" type="search" placeholder="FORMULA" />

         </div>
           <div class="timeline">
               <div id="pager">
                  <a href="#" class="">1</a>
                  <a href="#" class="">2</a>
                  <a href="#" class="">3</a>
                  <a href="#" class="">4</a>
                  <a href="#" class="">5</a>
                  <a href="page6.php" class="">6</a>
                  <a href="#" class="activeSlide">7</a>
                  <a href="page8.php" class="">8</a>
                  <a href="#" class="">9</a>
                  <a href="#" class="">10</a>
                  <a href="#" class="">11</a>
               </div>
           </div> 
   		<div class="back">
         		<a href="page6.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
       	</div>
         <div class="next">
            <a href="page8.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
         </div>
      </div>  
	</body>
</html>