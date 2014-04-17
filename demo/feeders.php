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
  <link href="css/panel.css" rel="stylesheet">
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons 
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">-->
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body class="home">
	<br><br>
	<div class="logo"></div>
  <h1><p class="text-center">Optional: Tell Us About Your Pet.</p></h1> <br>
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="jumbotron">
				        <form class="form-horizontal" method="POST" action="feeders.php">
  							<div class="control-group">
                  <p class='login'>Type: </p>
                  <div class="controls">
                    <select name='PetType'>
                    <option value=''>Select Pet Type</option>
                    <option value='Dog'>Dog</option>
                    <option value='Cat'>Cat</option>
                    <option value='Other'>Other</option>
                    </select>
                  </div>
                </div>s
                <div class="control-group">
                  <p class='login'>Password</p>
                  <div class="controls">
                      <input type="password" name="password" id="password" placeholder="password">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                      <p class='login'>
                        <input type="checkbox" name="remember" id="remember"> Remember me
                      </p>
                      <button type="submit" name="submit" id="submit" class="btn btn-darkgood">Log In »</button>
                      <a class="btn btn-darkgood" href="index.php">Return Home »</a>
                  </div>
                </div>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>
</html>