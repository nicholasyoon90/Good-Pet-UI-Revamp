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
                    <a href="page1.html">ADD NEW PET &nbsp &nbsp &nbsp &nbsp <img src = "img/circlePlus.png"/> </a> 
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
                        <div class="pic"><img src="img/pet_pic.png"></div>
                        <p class="p1 snack">I've been good! Could I have a snack?</p>
                        <br> 
                        <div class="snack">
                            <button class="button b" type="submit" name="formSubmit">GIVE SNACK NOW</button>
                            <button class="button b" type="submit" name="formSubmit">OPEN FEEDER</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
            <div class="panel panel-good">
                <div class="panel-heading">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="pull-left"><a href="#tab1" data-toggle="tab" class="p6">SCHEDULE</a></li>
                        <li class="active pull-right"><a href="#tab2" data-toggle="tab" class="p6">SETTINGS <span class="glyphicon glyphicon-cog"></span></a></li>
                    </ul>
                </div>
				

                <div class="panel-body">
                    <div class="tab-content">


                        <!--form input for settings-->
                        <div class="tab-pane" id="tab1">
                            <div class="col-md-4">
                                <p class="p5">MONDAY-THURSDAY, FRIDAY</p>
                                <div class="scheduler">
                                    <p class="p6"><b>9 AM</b>: 1.5 CUPS</p>
                                    <p class="p6"><b>6:30 PM</b>: 1 CUP</p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <p class="p5">NOTIFICATIONS</p>
                                <div class="notifs">
                                    <p class="p5">The Feeder Jammed</p>
                                    <p class="p5">Kona didn't eat his breakfast!</p>
                                    <p class="p5">Kona ate his dinner</p>
                                </div>
                            </div>

                        </div>

          

                        <!--form input for schedules-->
                        <div class="tab-pane active" id="tab2">
                            <!--start the form class for input fields-->
                            <div class="col-md-6">
                                <p class="p5">PET INFO</p>
    							<div class="pet_info">
    							<!--PET INFO-->			
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
    									
    								<!--BREED-->
    								<div class="styled-select inputIn">
    	            					<select> 
    						            	<option value="" disabled selected>BREED</option>
    						                <option>Pomeranian</option>
    						                <option>Beagle</option>
    						                <option>Maltese</option>
    	            					</select>
             						</div>
    									
    								<!--GENDER-->
    								<div class="styled-select inputIn">
    	            					<select> 
    						            	<option value="" disabled selected>GENDER</option>
    						                <option>Male</option>
    						                <option>Female</option>
    	            					</select>
             						</div>
    									
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
    									
    								<!--HEALTH-->
    								<div class="styled-select inputIn">
                						<select> 
    						                <option value="" disabled selected>HEALTH</option>
    						                <option>Overweight</option>
    						                <option>Underweight</option>
    						                <option>Healthy</option>
    				            		</select>
             						</div>
    									
    							</div>
                            </div>
							
							<div class="col-md-6">
    							
                                <p class ="p5">GENERAL PREFERENCES</p>
    							<div class="gen_pref clearfix">
    							<!--General Preferences-->
                                    <p class = "p5">WHEN DOES KONA EAT?<p>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                    <option value="" disabled selected>HOUR</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                 </select>
                                        </div>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                 <option value="" disabled selected>MINUTE</option>
                                                 <?php
                                                    for ($f=0; $f<10; $f++)
                                                    {
                                                       ?>
                                                          <option value="<?php echo "0".$f;?>"><?php echo "0".$f;?></option>
                                                       <?php
                                                    }
                                                    for ($f=10; $f<60; $f++)
                                                    {
                                                       ?>
                                                             <option value="<?php echo $f;?>"><?php echo $f;?></option>
                                                         <?php
                                                    }
                                                 ?>
                                                    
                                                 </select>
                                        </div>
                                        <div class="styled-select inputIn">
                                           <select>
                                           <option value="" disabled selected>AM/PM</option>
                                           <option value="AM">AM</option>
                                           <option value="PM">PM</option>
                                           </select>
                                        </div>
                                        <div class="styled-select inputIn">
                                                 <select>
                                                    <option value="" disabled selected>SELECT AMOUNT</option>
                                                    <option value='.25'>1/4 Cup</option>
                                                    <option value='.5'>1/2 Cup</option>
                                                    <option value='.75'>3/4 Cup</option>
                                                    <option value='1'>1 Cup</option>
                                                    <option value='1.25'>1 1/4 Cups</option>
                                                    <option value='1.5'>1 1/2 Cups</option>
                                                    <option value='1.75'>1 3/4 Cups</option>
                                                    <option value='2'>2 Cups</option>
                                                 </select>
                                        </div>
                                        <button class="button" type="submit" name="formSubmit">ADD SCHEDULE</button>


    							
    						    </div>
                            </div>
							
                            <div class="col-md-6">
                                <p class ="p5">PET PORTRAIT</p>	
                                <div class="pet_portrait">
                                   <input class = "input inputIn" type="file" />
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
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/flowtype.js"></script>
    <script>
        jQuery(document).ready(function(){
        jQuery('body').flowtype();
        });
    </script>
</body>

</html>
