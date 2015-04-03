<!-- logout.html 

-->
<?php
	require_once("Includes/session.php");

   

	$username = $_SESSION['username'];	

   	//clears cart values attached to username and returns to inventory 
    $result = $databaseConnection->query( "SELECT * FROM cart ");
	while ( $temp = $result->fetch_assoc() ){
    	//remove from cart
    	$qtyincart = $temp['qty'];
		$pidincart = $temp['p_id'];
        $databaseConnection->query( "DELETE FROM cart WHERE p_id='" . $pidincart . "' AND username='" . $username . "'");
    
        //return to inv
        $result2 = $databaseConnection->query( "SELECT qty FROM inventory WHERE p_id='" . $pidincart . "'");
        $temp2 = $result2->fetch_assoc();
        $qtyininv = $temp2['qty'];
        $updateqty = $qtyininv + $qtyincart;
        $databaseConnection->query( "UPDATE inventory SET qty='" . $updateqty . "' WHERE p_id='" . $pidincart . "'"); 
	}

	//clear session variables
	//$_SESSION = array();
   	if(isset($_COOKIE[session_name()])) {
       	setcookie(session_name(), '', time()-300, '/');
   	}   
   	session_unset();
   	session_destroy();
	session_start();

	//login
	if (isset($_POST['submit'])){
		echo "posted";
		$username = $_POST['username'];
        $password = $_POST['password1'];

		$query = "select username, password from users where username='" . $username . "' and password='" . $password . "'";
		$result = $databaseConnection->query($query);

		if ($result->num_rows > 0) {
			$row = $result-> fetch_assoc();
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
		}
		else
			include("Includes/logout.php");	
				
		print_r($_SESSION);
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
                    <li><a href="review.html">Review</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="checkout.php">Check out </a> </li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li>
						<form action="logout.php" method="post">
							<input type="submit" value="Logout" > 
						</form>
					</li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!-- container for form and fields -->
    <div class="container ">
    <h1> You have been successfully Logged out.</h1>
        <div class="col-sm-4">
			<h1> Login Again? </h1>

            <form action="login.php" method="post" name="form" id="form">
                <fieldset>
                    <!--class="col-sm-4"-->
                    <div class="form-group">
                        <label for="username" class="control-label">
                            Username
                        </label>
                        <input type="text" name="username" id="username" class="form-control">

                    </div>

                    <div class="form-group">
                        <label for="password1" class="control-label">
                            Password
                        </label>
                        <input type="password" name="password1" id="password1" class="form-control">

                    </div>

                </fieldset>
                <!--<div class="form-group">-->
                <input type="reset" value="Reset" class="btn btn-default">
                <input type="submit" name="submit" formaction="login.php" formmethod="post" value="Login" class="btn btn-default pull-right">
                <!--</div>--> <!--onclick="getUserInfo()"-->
            </form>
        </div>
    </div>
</body>
</html>

