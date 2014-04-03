<?php require_once("includes/session.php");
 require_once("includes/connection.php");
 require_once("includes/functions.php");
 require_once("includes/PasswordHash.php");
 confirm_logged_in();
 ob_start();

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

<!DOCTYPE
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />
  <meta charset="utf-8" />

  <title>GOOD, Inc.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
  <link href="css/custom.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery.js" type="text/javascript"></script>
  <style type="text/css">
/*<![CDATA[*/
  div.c5 {text-align: center}
  div.c4 {margin: auto;}
  button.c3 {float: right;}
  span.c2 {float: right;}
  div.c1 {padding: 15px; padding-bottom: 0px;}
  /*]]>*/
  </style>
</head>

<body>
  <script type='text/javascript' language='javascript'>
//<![CDATA[
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
  //]]>
  </script>

  <div class="hero-unit">
    <h1 class="text-center">Manage your Schedule</h1>
  </div>

  <div class="container-fluid row-fluid">
    <div class="span3">
      <div class="row-fluid span10 offset2">
        <a class="btn btn-large btn-block btn-primary dropdown dropdown-toggle" href="#" data-toggle="dropdown">Add Feeder <strong class="caret"></strong></a>

        <div class="dropdown-menu c1">
          <!-- Login form here -->

          <form class="form-horizontal" method="post" action="logged_in.php">
            <div class="control-group">
              <label class="control-label" for="fID">Feeder ID</label>

              <div class="controls">
                <input type="id" name="fID" id="fID" placeholder="Feeder ID" />
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="petName">Pet Name</label>

              <div class="controls">
                <input type="text" name="petName" id="petName" placeholder="Pet Name" />
              </div>
            </div>

            <div class="control-group controls">
              <button type="submit" class="btn btn-info" name="addFeeder">Add Feeder</button>
            </div>
          </form>
        </div>
      </div>

      <div class="row-fluid span10 offset2"></div>

      <div class="row-fluid span10 offset2"></div>

      <div class="row-fluid span 10 offset2">
        <a href='schedules.php'><button class="btn btn-large btn-primary" type='button'><a href='schedules.php'>Add Schedule</a></button></a>
      </div>

      <div class="row-fluid span10 offset2"></div>

      <div class="row-fluid span10 offset2"></div>

      <div class="row-fluid span10 offset2">
        <a href="logout.php"><button class="btn btn-large btn-block btn-primary" type="button"><a href="logout.php">Logout</a></button></a>
      </div>
    </div>

    <div class="span9">
      <div class="row-fluid">
        <form method="post" action="logged_in.php" id="scheduleForm">
          <input type='hidden' name='sIDs' value='' /><input type='hidden' name='sIDs' value='' />

          <table class='table table-bordered' id='table0'>
            <thead>
              <tr>
                <th class='lead'><strong>Banner's Feeder</strong></th>

                <td>
                  <div class='c4'>
                    <button class='btn btn-success' type='button' name='spinAuger1' onclick='javascript:pushCommand("1", "auger")'>Spin Auger</button> <button class='btn btn-info' type='button' name='openBowl1' onclick='javascript:pushCommand("1", "open")'>Open Bowl</button> <button class='btn btn-warning' type='button' name='closeBowl1' onclick='javascript:pushCommand("1", "close")'>Close Bowl</button> <span class='c2'><button class='btn btn-inverse c3' type='button' align='right' name='snack1' onclick='javascript:pushCommand("1", "snack")'><span class='c2'> Snack</span></button></span>
                  </div>
                </td>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th>Schedule Name</th>

                <th>Day(s)</th>

                <th>Time</th>

                <th>Cup(s)</th>

                <th></th>
              </tr>

              <tr class='success'>
                <td>Breakfast</td>

                <td>Everyday</td>

                <td>9:00 AM</td>

                <td>1 1/4</td>

                <td><button class='btn btn-success' type='submit' name='editSchedule2'>Edit</button> &nbsp;&nbsp; <button class='btn btn-danger' type='submit' id='deleteSchedule' name='deleteSchedule2'>Delete</button></td>
              </tr>

              <tr class='success'>
                <td>Dinner</td>

                <td>Everyday</td>

                <td>5:00 PM</td>

                <td>1 1/4</td>

                <td><button class='btn btn-success' type='submit' name='editSchedule3'>Edit</button> &nbsp;&nbsp; <button class='btn btn-danger' type='submit' id='deleteSchedule' name='deleteSchedule3'>Delete</button></td>
              </tr>
            </tbody>
          </table>

          <div class='row c5' id='commandOutput1'></div><br />
          <br />
        </form>
      </div><script src="js/bootstrap.min.js" type="text/javascript">
</script>
    </div>
  </div>
</body>
</html>