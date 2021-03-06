﻿<!-- login.html 
     Displays fields for user and password entry to login to the website.
    Only most recently registered username will be be able to enter. (currently)
-->
<?php

	
	require_once ("Includes/session.php");

	//username and password have been entered
	if (isset($_POST['submit'])){

		$username = $_POST['username'];
        $password = $_POST['password1'];

		$query = "select username, password from users where username='" . $username . "' and password='" . $password . "'";
		$result = $databaseConnection->query($query);

		if ($result->num_rows > 0) {
			$loginerror = False;
			$row = $result-> fetch_assoc();
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
		
			$databaseConnection->query( "UPDATE cart SET username='" . $username . "' WHERE username='" . session_id() . "'");
		}
		else{
			$loginerror = True;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>EnterpriseHardware.com - Login</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />

    <script>
        //searches cookies for existing one containing arg name
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }


        //login doesn't support multiple logins. Only the most recently registered.
        // gets field info and makes cookie with it
        function getUserInfo() {
            username = document.getElementById("username").value;
            password = document.getElementById("password1").value;
            var userCookie = getCookie("username");
            if (userCookie != "") {
                if (username == getCookie("username")) {
                    if (username != "") {
                        if (password == getCookie("password1")) {
                            alert("Successful login");
                        }
                        else {
                            alert("Login Failed: Please check your login information and try again.");
                        }
                    }
                }
            }
            else {
                alert("Login Failed: Please check your login information and try again.");
            }

        }

    </script>
</head>

<body>
    <!-- nav bar code -->
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img alt="Enterprise Hardware Logo" src="images/logo.svg.png" width="20" height="20"></a>
                <a class="navbar-brand" href="index.html">Enterprise Hardware</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li class="active"><a href="login.php">Login</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li><a href='viewreview.php'>Reviews</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="purchaseconfirm.php">Your purchases</a></li>
                    <li><a href="checkout.php">Check out </a> </li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li>
<a href='logout.php'>Logout</a>
					</li>
                    <li><a href="admin.php">Admin</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

<?php

	if ( isset($_SESSION['username'])){


		echo "	
        	<div class=\"container\">
           	 	<h1> Welcome, " . $_SESSION['username'] . " </h1>
				<h4> Here are some things you can do: </h4>
				<a href=\"catalog.php\"> Proceed to Catalog </a> </br>
				<a href=\"checkout.php\"> View your cart </a> </br>
				<a href=\"purchseconfirm.php\"> View your purchases. </a> </br>
				<a href=\"userupdate.php\"> Change your account info. </a> </br></br>
				<p> To log in as another user you must first logout. </p>
			</div>
		";
	}
	else{
		echo "
    	<!-- container for form and fields -->
    	<div class=\"container \">
        	<div class=\"col-sm-4\">
            	<h1>Login</h1>
		";

		if ($loginerror){
			echo "
				<h3> Whoops. There was an error in your username or password. Try again. </h3> </br>
			";
		}
		
		echo "
            	<form action=\"login.php\" method=\"post\" name=\"form\" id=\"form\">
                	<fieldset>
                    	<!--class=\"col-sm-4\"-->
                    	<div class=\"form-group\">
                        	<label for=\"username\" class=\"control-label\">
                            	Username
                        	</label>
                        	<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control\">
	
                    	</div>
	
                    	<div class=\"form-group\">
                        	<label for=\"password1\" class=\"control-label\">
                            	Password
                        	</label>
                        <input type=\"password\" name=\"password1\" id=\"password1\" class=\"form-control\">
	
                    	</div>
	
                	</fieldset>
                	<!--<div class=\"form-group\">-->
                	<input type=\"reset\" value=\"Reset\" class=\"btn btn-default\">
                	<input type=\"submit\" name=\"submit\" formaction=\"login.php\" formmethod=\"post\" value=\"Login\" class=\"btn btn-default pull-right\">
                	<!--</div>--> 
            	</form>
        	</div>
    	</div>
		";
	}

?>
</body>
</html>

