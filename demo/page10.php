<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 10</title>
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
      <div class="wrapper">
   		<div class="absolute">
   			<p class="p1">Awesome! Let's setup a feeding schedule.</p>
   			<p class="p4">We'll use a simple everyday schedule for now, but you can customize it later.</p>			
   		</div>
   		<div class="inputfields">
            <div id="addinput">
               <p>
                  <a href="#" id="addNew"><button class="button buttonScale" type="button" class="btn btn-default btn-small">ADD NEW</button></a> <br>
                  <input class = "input inputIn input100" type="time" id="p_new" name="p_new"/>
                  <input class = "input inputIn input10" type="text" id="p_new" name="p_new" placeholder="1.5 CUPS" />
                  <a href="#" id="remNew"><button class="button X" type="button" class="btn btn-default btn-medium">X</button></a>
               </p>
            </div>
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
               <a href="#" class="">8</a>
               <a href="page9.php" class="">9</a>
               <a href="#" class="activeSlide">10</a>
               <a href="page11.php" class="">11</a>
            </div>
         </div>
   	   <div class="back">
            <a href="page9.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
         </div>
         <div class="next">
            <a href="page11.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
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