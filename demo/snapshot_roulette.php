<?php

$sn = $_GET['sn']

?>


<html>

<head>
<meta charset="utf-8">
<title>GOOD, Inc.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="css/bootstrap_new.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap_new.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/bootstrap_new.js"></script>

<link href="css/bootstrap-lightbox.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-lightbox.min.css" rel="stylesheet" type="text/css" />
<script src="js/bootstrap-lightbox.js"></script>
<script src="js/bootstrap-lightbox.min.js"></script>

<style>
.carousel-inner>.item>img {
margin: 0 auto;
height: 240px;
}
</style>
</head>

<body>

<div id="carousel-example-generic"  style="width: 320px" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
<?php

$i = 0;
foreach(glob('petpics/'.$sn.'_*') as $filename) {
	//echo  "<li data-target='#carousel-example-generic' data-slide-to='".$i."'></li>";
}

// i is now the number of photos available

?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
<?php

$j = 0;
foreach(glob('petpics/'.$sn.'_*') as $filename) {
	if ($j == 0) {
		echo  "<div class='item active'>
      <img src='".$filename."' alt='".$filename."'>
      <div class='carousel-caption'>
        caption here
      </div>
    </div>";
	} else {
		echo  "<div class='item'>
      <img src='".$filename."' alt='".$filename."'>
      <div class='carousel-caption'>
        caption here
      </div>
    </div>";
	}
	$j++;
}

?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>

<script language='javascript' type='text/javascript'>
$('.carousel').carousel();
</script>

<br>

<div id="demoLightbox" class="lightbox"  tabindex="-1" role="dialog" aria-hidden="true">
	<div class='lightbox-content'>
		<img src="petpics/default.jpg">
		<div class="lightbox-caption"><p>Your caption here</p></div>
	</div>
</div>

</body>

</html>
