<?php

			//THIS CODE CONNECTS YOU TO THE DATABASE

			$message = '';
			
			// 1. Create a database connection
			/*$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
			if (!$connection) {
				die("Database connection failed: " . mysql_error());
			}

			// 2. Select a database to use 
			$db_select = mysql_select_db(DB_NAME,$connection);
			if (!$db_select) {
				die("Database selection failed: " . mysql_error());
			}
			

			try{
				$dbh = new PDO("mysql:host=localhost;dbname=feederWifi", DB_USER, DB_PASS);
			}
			catch(PDOException $e){
				echo $e->getMessage();
			}
			*/
			if (isset($_POST['submit'])) {
					
				/*THIS IS THE CODE FOR WRITING TO A MYSQL DATABASE (ASSUMING THERE IS A BLANK ENTRY ALREADY INSERTED WHICH IS IN THE .SQL FILE)
				
				if(($_POST['SSID'] == '')){
					if(($_POST['password'] == '')){
						$message = 'Error: Please select an SSID and enter a password';
					}
					else{
						$message = 'Error: Please select an SSID.';
					}
				}
				else if(!empty($_POST['SSID']) && isset($_POST['password'])){
					if(($_POST['password'] == '')){
						$message = 'Error: Please enter a password.';
					}
					else{
						$query = $dbh->prepare("UPDATE Wifi SET SSID = :SSID, password = :password");
						$query->bindParam(":SSID", $SSID);
						$query->bindParam(":password", $password);
						$password = ($_POST["password"]);
						$someRows = explode(",",($_POST["SSID"]));
						$SSID = $someRows[0];
						$query->execute();
						$message = 'Success';
					}
				}
				else if(!isset($_POST['password'])){
						$query = $dbh->prepare("UPDATE Wifi SET SSID = :SSID, password = '' ");
						$query->bindParam(":SSID", $SSID);
						$someRows = explode(",",($_POST["SSID"]));
						$SSID = $someRows[0];
						$query->execute();
						$message = 'Success';
				}
			
			}
				*/
				//THIS IS THE CODE FOR WRITING TO A TEXT FILE IF YOU WANT TO DO THAT INSTEAD
				$file = "wifi.txt";
				$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
				$SSID_TO_TEXT = $_POST['SSID'];
				$SSID = explode(",",$SSID_TO_TEXT);
				$SSID0 = $SSID[1].PHP_EOL;
				$PW_TO_TEXT = "";
				if(isset($_POST['password']))
				{
					$PW_TO_TEXT = $_POST['password'];
				}
				fwrite($handle, $SSID0);
				fwrite($handle, $PW_TO_TEXT);
				fclose($handle);
				?>
				<?php
				//echo "<h4 class='text-success'>If connection was successful, the LED light on the feeder will be green, and you can close this window, refresh the setup page and continue to step 5.</h4>";
				//echo "<br><h4 class='text-error'>If connection was unsuccessful, the LED light on the feeder will be red, and you can close this window, refresh the setup page and return to step 3.</h4>";
				//$message .= 'Success';
				echo "<h4 class='text-success'> Connecting... please wait.</h4>";
				?>
				<script language="JavaScript" type="text/javascript">
				setTimeout("opener.location.reload(true);",10000);
				setTimeout("self.close();",10000);
				</script>
				<?php
			}
?>	
<html>
<head>
<meta charset="utf-8">
<title>GOOD, Inc.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<!--<link href="css/custom.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<div class="row-fluid">
 <h1><p class="text-center" id="network">Choose Your Network</p></h1><br>
 </div>
 <form class="form-horizontal" action="Rpindex.php" method="post" name="SSIDS">
  <div class="row-fluid">
  <div class="span6 offset5">Name :
     <select id='SSID' name='SSID' method="post">
	 <option value=''>Select your SSID</option>
	<?php
		$i = 0;
		$j = 0;
		$select = file_get_contents('SSID.txt');
		$lines = explode("\n", $select);
		$strength = array();
		$num = count($lines);
		foreach($lines as $abc)
		{
			if(strlen(trim($abc)) > 0 )
			{
				$x = 0;
				$rows = (explode(",", $abc));
				$cleanSSID = str_replace(array('"'), '', $rows[0]);
				$strength[$i][$j][$x] = $cleanSSID;
				$x++;
				$strength[$i][$j][$x] = $rows[2];
				$x++;
				$strength[$i][$j][$x] = $rows[1];
				$i++;
			}
		}
		$tmp = array();
		$numStrength = count($strength);
		foreach($strength as &$ma)
		{
			$tmp[] = &$ma[0][1];
			array_multisort($tmp, $strength);
		}	
		for($m=($i-1); $m>=0; $m--)
		{
			echo "<option value='".$strength[$m][0][2].",".htmlspecialchars(stripslashes($strength[$m][0][0]), ENT_QUOTES)."'>".$strength[$m][0][0]."</option>";
		}
?>
</select>
</div>
</div>
<div id="area">
			<script src="jquery.js"></script>
			<script>
			$(document).ready(function(){
				$("#SSID").change(function(){
				$("#area").find(".field").remove();
				$("#area").find("h4").remove();
				$("#area").find("br").remove();
				$("#area").find("submit").remove();
				var security = $("#SSID").val();
				var on = 'on';
				var off = 'off';
				var matchOn = security.match(on);
				var matchOff = security.match(off);
				if( matchOn )
				{
					//$("#area").append($('<p>Security Detected: Enter the password for your wifi network and press Connect to continue.</p>').fadeIn('slow'));
					$("#area").append("<br><div class='field'><div class='row-fluid'><div class='span6 offset5'>&nbspPassword : <input type='password' name='password' id='inputPassword' placeholder='Password'></div></div></div>");
					$("#area").append("<br><div class='field'><div class='text-center'><a href='#' ><input class='btn btn-large btn-primary' type='submit' name='submit' value='Connect'></a></div></div>");
				}
				else if( matchOff )
				{
					//$("#area").append($('<h4>Press Connect to continue.</h4>').fadeIn('slow'));
					$("#area").append("<br><div class='field'><div class='text-center'><a href='#' ><input class='btn btn-large btn-primary' type='submit' name='submit' value='Connect'></a></div></div>");
				}
				});
			});
			</script>
    </div>
  </div>
  </div>
 </form>
 <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>

<script src="js/jquery-1.10.0.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
</body>
</html>