<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 8</title>
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
			<p class="p1">Now, lets get WiFi setup.</p>
			<p class="p4">Read everything before starting this step!</p><br>
			<p class="p3"><strong>1.</strong> Switch your WiFi to "WooFi"</p><br>
			<p class="p3"><strong>2.</strong> Come back here</p><br>
			<p class="p3"><strong>3.</strong> Click the button below and enter your home WiFi information</p><br>
		</div>
      <div class="connect">
         <a href="#"><button class="button" type="button" class="btn btn-default btn-extralarge">CONNECT TO WIFI</button></a>
      </div>
      <div class="timeline">
         <div id="pager">
            <a href="#" class="">1</a>
            <a href="#" class="">2</a>
            <a href="#" class="">3</a>
            <a href="#" class="">4</a>
            <a href="#" class="">5</a>
            <a href="#" class="">6</a>
            <a href="page7.php" class="">7</a>
            <a href="#" class="activeSlide">8</a>
            <a href="page9.php" class="">9</a>
            <a href="#" class="">10</a>
            <a href="#" class="">11</a>
         </div>
      </div>
      <div class="back">
         <a href="page7.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
      </div>
      <div class="next">
         <a href="page9.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
      </div>  
	</body>
</html>