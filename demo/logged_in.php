<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GOOD, Inc.</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/panel.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/setup.css" rel="stylesheet">

    <!--<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            
            <ul class="sidebar-nav">
                
                <div class="side-logo"></div>

                <li class="active">
                    <a href="#">KONA</a>
                </li>
                <li>
                    <a href="page1.html">ADD NEW PET    <span class="glyphicon glyphicon-plus"></span></a>  <!--Need to change the plus sign to inside a circle-->
                </li>

                <!--Sidebar bottom justification-->
                <div id="sidebar-bottom">
                    <li><a href="http://buygood.us/contact.php">GIVE FEEDBACK</a>
                    </li>
                    <li><a href="#">ACCOUNT</a>  
                    </li>
                    <li><a href="logout.php">LOG OUT</a>
                    </li>
                </div>

            </ul>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <!--<div class="content-header">
                    <a id="menu-toggle" href="#" class="btn btn-default"><i clas="icon-reorder"></i></a>
                    <center><img src="/template/img/photo.jpg"></center>
            </div>-->
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">
                <a id="menu-toggle" href="#" class="btn btn-default">Menu<i class="icon-reorder"></i></a>
                <div class="row">
                    <div class="col-md-12">
                        <p class="snack">I've been good! Could I have a snack?     <img src="img/pet_pic.png"></p>
                        <!--<button class="btn">lol</button>-->
                    </div>
                    <!--<div class="col-md-6">
                        <p class="well">The template still uses the default Bootstrap rows and columns.</p>
                    </div>-->
                </div>
                <div class="col-md-12">
            <div class="panel panel-good">
                <div class="panel-heading">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="pull-left"><a href="#tab1" data-toggle="tab">SCHEDULE</a></li>
                        <li class="active pull-right"><a href="#tab2" data-toggle="tab">SETTINGS     <span class="glyphicon glyphicon-cog"></span></a></li>
                    </ul>
                </div>
				

                <div class="panel-body">
                    <div class="tab-content">


                        <!--form input for settings-->
                        <div class="tab-pane" id="tab1">
                              HELLO MY NAME IS BLAH
                        </div>

          

                        <!--form input for schedules-->
                        <div class="tab-pane active" id="tab2">
                            <!--start the form class for input fields-->
                            <div class="col-md-7">
    							<div class="pet_info">
    							<!--PET INFO-->
    								<p> PET INFO </p>			
    								<!--NAME-->
    								<input class = "input inputIn" type="text" placeholder="NAME" />
    								   
    								<!--TYPE-->
    								<div class="styled-select inputIn">
    	            					<select> 
    						            	<option value="" disabled selected>TYPE</option>
    						                <option>Dog</option>
    						                <option>Cat</option>
    	            					</select>
             						</div>
             						<br>
    									
    								<!--BREED-->
    								<div class="styled-select inputIn">
    	            					<select> 
    						            	<option value="" disabled selected>BREED</option>
    						                <option>Pomeranian</option>
    						                <option>Beagle</option>
    						                <option>Maltese</option>
    	            					</select>
             						</div>
             						<br>
    									
    								<!--GENDER-->
    								<div class="styled-select inputIn">
    	            					<select> 
    						            	<option value="" disabled selected>GENDER</option>
    						                <option>Male</option>
    						                <option>Female</option>
    	            					</select>
             						</div>
    								<br>
    									
    								<!--AGE-->
    								<input class = "input inputIn" type="number" placeholder="AGE (in years)" />
    									
    								<!--WEIGHT-->
    								<input class = "input inputIn" type="number" placeholder="WEIGHT (in lbs)" />
    									
    								<!--FOOD BRAND-->
    								<div class="styled-select inputIn">
                						<select> 
    						                <option value="" disabled selected>FOOD BRAND</option>
    						                <option>All Brand</option>
    						                <option>Acana</option>
    						                <option>Advance Pet Diets - Select Choice All Natural</option>
    						                <option>Alpo</option>
    						                <option>Annamaet</option>
    				            		</select>
             						</div>
    								<br>
    									
    								<!--HEALTH-->
    								<div class="styled-select inputIn">
                						<select> 
    						                <option value="" disabled selected>HEALTH</option>
    						                <option>Overweight</option>
    						                <option>Underweight</option>
    						                <option>Healthy</option>
    				            		</select>
             						</div>
    								<br>
    									
    							</div>
                            </div>
							
							<div class="col-md-5">
    							
    							<div class="gen_pref">
    							<!--General Preferences-->
    							<p>WHEN DOES KONA EAT?<p>
    							
    							
    							<!--TIME1-->
    							<input class = "input inputIn" type="time" />
             					<input class = "input inputIn" type="text" placeholder="1.5 CUPS" /> <br>
             					<a href="#"><button class="button inputIn" type="button" class="btn btn-default btn-small">ADD NEW</button></a>			
    							</div>
                            </div>
							
                            <div class="col-md-5">	
    							<div class="pet_portrait">
    							<!--Pet Portrait-->
									<form action="/playground/ajax_upload" id="newHotnessForm">
										<label>Upload a Picture of Your Pet</label>
										<input type="file" size="20" id="imageUpload" class=" ">
										<button class="button" type="submit">SAVE</button>
									</form>
    							</div>
                            </div>
							
                     

                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
</body>

</html>
