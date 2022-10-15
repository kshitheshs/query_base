<?php
	require_once('functions.php');
	if(loggedin())
		header("Location: index.php");
	else if(isset($_POST['action'])) {
		$userid = array_key_exists('userid', $_POST) ? pg_escape_string($db,trim($_POST['userid'])) : "";
    $password = array_key_exists('password', $_POST) ? pg_escape_string($db,trim($_POST['password'])) : "";
    // echo $userid."".$password;
		if($_POST['action']=='login') {
			if(trim($userid) == "" or trim($_POST['password']) == "") {
				header("Location: login.php?derror=1"); // empty entry
			} else {
				// code to login the user and start a session
				// connectdb();
				$query = "SELECT * FROM users WHERE userid = '$userid' and password = '$password'";
				$result = pg_query($db,$query);
        if (!$result) {
          # code...
          echo "something is wrong";
        }
				$fields = pg_fetch_array($result);
        $count = pg_num_rows($result);
        // echo $count;
				if($count == 1) {
					$_SESSION['userid'] = $userid;
          $_SESSION['username'] = $fields['firstname']." ".$fields['lastname'];
					header("Location: index.php");
				} else
					header("Location: login.php?error=1");
			}
		} else if($_POST['action']=='register') {
			// register the user
			$firstname = array_key_exists('firstname', $_POST) ? pg_escape_string($db,trim($_POST['firstname'])) : "";
			$lastname = array_key_exists('lastname', $_POST) ? pg_escape_string($db,trim($_POST['lastname'])) : "";
      		$email = array_key_exists('email', $_POST) ? pg_escape_string($db,trim($_POST['email'])) : "";
			if(trim($firstname) == "" and trim($lastname) == "" and trim($userid) == "" and trim($_POST['password']) == "" and trim($email) == "") {
				header("Location: login.php?derror=1"); // empty entry
			} else {
				// create the entry in the users table
				connectdb();
				$query = "SELECT * FROM users WHERE user_id='".$userid."'";
				$result = pg_query($db,$query);
				if(pg_num_rows($result)!=0) {
					header("Location: login.php?exists=1");
				} else {
					$sql="INSERT INTO `users` ( `user_id` , `firstname` , `lastname` , `email`, `status` ) VALUES ('".$userid."', '".$firstname."', '".$lastname."', '".$email."', '1')";
					pg_query($db,$sql);
					header("Location: login.php?registered=1");
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login</title>
    <!-- <?php
     // echo(getName());
    ?> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }

      .footer {
        text-align: center;
        font-size: 11px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <!-- <a class="brand" href="#"></a> -->
          <!-- <?php
     // echo(getName());
    ?> -->
        </div>
      </div>
    </div>

    <div class="container">

      <?php
        if(isset($_GET['logout']))
          echo("<div class=\"alert alert-info\">\nYou have logged out successfully!\n</div>");
        else if(isset($_GET['error']))
          echo("<div class=\"alert alert-error\">\nIncorrect userid or password!\n</div>");
        else if(isset($_GET['registered']))
          echo("<div class=\"alert alert-success\">\nYou have been registered successfully! Login to continue.\n</div>");
        else if(isset($_GET['exists']))
          echo("<div class=\"alert alert-error\">\nUser already exists! Please select a different user-id.\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
      <h1><small>Login</small></h1>
      <p>Please login to continue.</p><br/>
      <form method="post" action="login.php">
        <input type="hidden" name="action" value="login"/>
        User-ID: <input type="text" name="userid"/><br/>
        Password: <input type="password" name="password"/><br/><br/>
        <input class="btn" type="submit" name="submit" value="Login"/>
      </form>
      <hr/>
      <form method="post" action="login.php">
        <input type="hidden" name="action" value="register"/>
        <h1><small>New User? Register now</small></h1>
        <table>
		  <tr>
		    <td>First Name: <input type="text" name="firstname"/></td>
		    <td>Last Name: <input type="text" name="lastname"/></td>
		  </tr>
		</table>
        User-ID: <input type="text" name="userid"/><br/>
        Password: <input type="password" name="password"/><br/>
        Email: <input type="email" name="email"/><br/><br/>
        <input class="btn btn-primary" type="submit" name="submit" value="Register"/>
    </div> <!-- /container -->

<?php
	include('footer.php');
?>
