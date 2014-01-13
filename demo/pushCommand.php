<?php
$command = $_POST['command'];
$SN = $_POST['SN'];

$connection=mysqli_connect('localhost', 'projectpet', 'good&$3(uR3', 'good_petdb');
if (!$connection) {
	echo 'error connecting to database';
}

$userAction = mysqli_query($connection, "SELECT open,command FROM Feeders WHERE fID='".mysql_real_escape_string($SN)."'");
$actionRow = mysqli_fetch_array($userAction);

$actionSuccess = '';
$actionError = '';

if($command == 'open'){ //if open bowl is pressed
	if($actionRow['open'] == 0){ //if bowl is not open
		mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($SN)."'");	// set open to 1(true)		
		if($actionRow['command'] != 1){ // if command is not 1(open)
			mysqli_query($connection, "UPDATE Feeders SET command=1 WHERE fID='".mysql_real_escape_string($SN)."'"); //set command to 1(open)
		}
		$actionSuccess = 'Bowl is opening.'; //if the bowl is closed, we can open it
	} else{
		$actionError = 'Bowl is already open!'; //if open is already 1, bowl is still in process of opening, don't try again.
	}
} elseif($command == 'close'){ //if close bowl is pressed
	if($actionRow['command'] != 4){
		mysqli_query($connection, "UPDATE Feeders SET command=4 WHERE fID='".mysql_real_escape_string($SN)."'"); //if command is not 4(close) we set it to close.
		$actionSuccess = 'Bowl is closing.'; //bowl will now close.
	} else{
		$actionError = 'Bowl is already closing, calm down!'; //if command = 4, bowl is closing and will be set to 0 again by server when it is done.
	}
} elseif($command == 'snack'){ //if snack is pressed
	if($actionRow['open'] == 0){ //if the bowl is closed(0)
		//mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($SN)."'"); //we open bowl (set open to 1);
		if($actionRow['command'] != 3){ //if command is not 2(snack)
			mysqli_query($connection, "UPDATE Feeders SET command=3 WHERE fID='".mysql_real_escape_string($SN)."'"); // set command to snack(begin snack dispensing.
			mysqli_query($connection, "UPDATE Feeders SET open=1 WHERE fID='".mysql_real_escape_string($SN)."'"); // set command to open bowl.
			$actionSuccess = 'Brace yourself; noms are coming.'; // both commands successful, snack will dispense
		}
	} else if($actionRow['open'] == 1){
		$actionError = 'Close the bowl if you wanna snack, man!';
	} else if($actionRow['command'] == 3){
		$actionError = 'Snack is already on it\'s way!  Geez';
	}
} elseif($command == 'auger'){
	if($actionRow['open'] == 0){
		if($actionRow['command'] != 2){
			mysqli_query($connection, "UPDATE Feeders SET command=2 WHERE fID='".mysql_real_escape_string($SN)."'");
			$actionSuccess = 'Food is on it\'s way!';
		}
	} elseif($actionRow['open'] == 1){
		$actionError = 'Do you want food all over the floor?  This is how you get food all over the floor.  Close the bowl and try again! :)';
	} elseif($actionRow['command'] == 2){
		$actionError = 'Whoa nelly!  We\'re already on that, chief!';
	}
}

mysqli_close($connection);
echo $actionSuccess;
echo $actionError;

?>
