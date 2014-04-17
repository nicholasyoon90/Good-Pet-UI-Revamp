<?php require_once("includes/session.php"); 
require_once("includes/connection.php"); 
require_once("includes/functions.php");
require_once("includes/PasswordHash.php"); ?>
<?php
  $message = '';
  $tk = '';
  $hasher = new PasswordHash(8, false);
  if (logged_in()) {
    redirect_to("logged_in.php");
  }
  
  $remd = $connection->query("SELECT remid,email FROM Users");
  foreach ($remd as $remrow) {
    if (isset($_COOKIE['TKC'])) {
      if ($_COOKIE['TKC'] == $remrow['remid'])
      {
        $tk = uniqid($remrow['email'],true);
        $updateRem = $connection->prepare("UPDATE Users SET remid=? WHERE email=?");
        $updateRem->execute(array($tk, $remrow['email']));
        setcookie("TKC", $tk, time()+31557600, "/", false, false, true); 
        $_SESSION['email'] = $remrow['email'];
        redirect_to("logged_in.php");
      }
    }
  }
  //}
  include_once("includes/form_functions.php");
  
  // START FORM PROCESSING
  if (isset($_POST['submit'])) { // Form has been submitted.
    $errors = array();

    // perform validations on the form data, make sure that the fields meet the length requirements, etc.
    $required_fields = array('email', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

    $fields_with_lengths = array('email' => 32, 'password' => 72);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
    // we are using an email and password for login verification, password goes through hashing algorithms as seen in PasswordHash.php
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stored_hash="*";
    $storage = $connection->prepare("SELECT email, hashed_password FROM Users WHERE email=?");
    $storage->execute(array($email));
    $prow = $storage->fetchAll(PDO::FETCH_ASSOC);
    if($prow != false)
      $stored_hash = $prow[0]['hashed_password'];
    $check = $hasher->CheckPassword($password,$stored_hash);
    
    
    if($check) {
      if(isset($_POST['remember'])) {
        $tk = uniqid($email,true);
        //insert into users, $tk.
        $updateC = $connection->prepare("UPDATE Users SET remid=? WHERE email=?");
        $updateC->execute(array($tk, $email));
        setcookie("TKC", $tk, time()+31557600, "/", false, false, true); 
      }
      $_SESSION['email'] = $prow[0]['email'];
      redirect_to("logged_in.php");
    }
    else {
      $message = "Email/password combination incorrect.<br />
          Please make sure your caps lock key is off and try again.";
    }
    
  } else { // Form has not been submitted.
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
      $message = "You are now logged out.";
    } 
    $email = "";
    $password = "";
    
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <title>GOOD, Inc.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons 
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">-->
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body class="home">
	<br><br>
	<div class="logo"></div>
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="jumbotron">
				        <form class="form-horizontal" method="POST" action="login.php">
  							<div class="control-group">
    							<p class='login'>Email</p>
    							<div class="controls">
      								<input type="email" name="email" id="email" placeholder="email@domain.com">
    							</div>
  							</div>
  							<div class="control-group">
    							<p class='login'>Password</p>
    							<div class="controls">
      								<input type="password" name="password" id="password" placeholder="password">
    							</div>
  							</div>
  							<div class="control-group">
    							<div class="controls">
      								<p class='login'>
        								<input type="checkbox" name="remember" id="remember"> Remember me
      								</p>
      								<button type="submit" name="submit" id="submit" class="btn btn-darkgood">Log In »</button>
      								<a class="btn btn-darkgood" href="index.php">Return Home »</a>
    							</div>
  							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
</body>
</html>