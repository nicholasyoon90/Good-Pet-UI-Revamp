<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 2</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.css" rel="stylesheet" media="screen">
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
      <div class ="wrapper">
   		<div class="absolute">
   			<p class="p1">First things first:</p><br>
   			<p class="p2">Plug in your feeder.</p><br>
   			<p class="p1">A blue light will come on.</p><br>
   		</div>
         <div class="con_container clearfix">
            <div class="picture">
               <img src = "../Setup/img/inst.JPG"><br>
            </div>
         </div>

         <div class="footer clearfix">

            <div class="nav_container clearfix">
               <div class="timeline">
                  <div id="pager">
                     <a href="page1.php" class="">1</a>
                     <a href="#" class="activeSlide">2</a>
                     <a href="page3.php" class="">3</a>
                     <a href="#" class="">4</a>
                     <a href="#" class="">5</a>
                     <a href="#" class="">6</a>
                     <a href="#" class="">7</a>
                     <a href="#" class="">8</a>
                     <a href="#" class="">9</a>
                     <a href="#" class="">10</a>
                  </div>
               </div>
            </div>

            <div class="but_container clearfix">
               <div class="back">
         			<a href="page1.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
         		</div>
               <div class="next">
                  <a href="page3.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
               </div> 
            </div>

         </div>

      </div>
	</body>
</html>