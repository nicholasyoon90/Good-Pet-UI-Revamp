<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 9</title>
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
		<div class="absolute">
			<p class="p1">Connect to WiFi</p>
			<p class="p4">We need to tell your new pet feeder how to get online. Please bare with us and follow these simple steps:</p>
			<p class="p3"><strong>1.</strong> Switch your device to the network "WooFi"</p><br>
			<p class="p3"><strong>2.</strong> Return here and click the link below to choose your network</p><br>
			<p class="p3"><strong>3.</strong> Re-connect to your normal WiFi network</p>
		</div>
      <div class="connect">
         <a href="doesntwork"><button class="button" type="button" class="btn btn-default btn-extralarge">CONNECT TO WIFI</button></a>
      </div>
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
            <a href="#" class="">11</a>
         </div>
      </div>
      <div class="back">
         <a href="page8.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
      </div>
      <div class="next">
         <a href="page10.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
      </div> 
	</body>
</html>