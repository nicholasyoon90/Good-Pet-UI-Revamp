<!DOCTYPE html>
<html>
	<head>
		<title>Setup Page 5</title>
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
  			<p class="p1">Let's get some info about your pet.</p>
  			<p class="p4">(click next to skip)</p>
  		</div>
       <div class="con_container clearfix">
          <div class="inputfields">
    			<div class="styled-select inputIn">
              <select> 
                 <option value="" disabled selected>TYPE</option>
                  <option>Dog</option>
                  <option>Cat</option>
              </select>
           </div>
           <div class="styled-select inputIn">
              <select> 
                 <option value="" disabled selected>BREED</option>
                  <option>Pomeranian</option>
                  <option>Beagle</option>
                  <option>Maltese</option>
              </select>
           </div>

             <input class = "input inputIn" type="number" placeholder="AGE" />
             <input class = "input inputIn" type="number" placeholder="WEIGHT" />
          </div>
      </div>
      <div class="nav_container clearfix">
      		<div class="timeline">
             <div id="pager">
                <a href="#" class="">1</a>
                <a href="#" class="">2</a>
                <a href="#" class="">3</a>
                <a href="page4.php" class="">4</a>
                <a href="#" class="activeSlide">5</a>
                <a href="page6.php" class="">6</a>
                <a href="#" class="">7</a>
                <a href="#" class="">8</a>
                <a href="#" class="">9</a>
                <a href="#" class="">10</a>
                <a href="#" class="">11</a>
             </div>
          </div>
      </div>
      <div class="but_container clearfix">
    		<div class="back">
          	<a href="page4.php"><button class="button" type="button" class="btn btn-default btn-medium">BACK</button></a>
       	</div>
          <div class="next">
             <a href="page6.php"><button class="button" type="button" class="btn btn-default btn-medium">NEXT</button></a>
          </div> 
      </div>
    </div>
	</body>
</html>