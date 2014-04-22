<!DOCTYPE html>
<html>
   <head>
      <title>Setup Page 1</title>
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
      <div class="wrapper">
         <div class="absolute">
            <p class="p1">Welcome to your new automated pet feeder!</p><br>
            <p class="p2">Let's get everything set up.</p>
         </div>

         <div style="height:315px; width:100%; clear:both;"></div>

         <div class="nav_container clearfix">
            <div class="timeline">
               <div id="pager">
                  <a href="#" class="activeSlide">1</a>
                  <a href="page2.php" class="">2</a>
                  <a href="#" class="">3</a>
                  <a href="#" class="">4</a>
                  <a href="#" class="">5</a>
                  <a href="#" class="">6</a>
                  <a href="#" class="">7</a>
                  <a href="#" class="">8</a>
                  <a href="#" class="">9</a>
                  <a href="#" class="">10</a>
                  <a href="#" class="">11</a>
               </div>
            </div>
         </div>

         <div class="but_container clearfix">
            <div class="next">
               <a href="page2.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
            </div>
         </div>
      </div>

   </body>
</html>