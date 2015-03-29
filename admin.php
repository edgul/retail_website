<!-- sitemap.html 
     Displays all visitable web pages on the website
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>EnterpriseHardware.com - Sitemap</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />
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
                    <li><a href="login.php">Login</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li class="active"><a href="sitemap.html">Sitemap</a></li>
                    <li><a href="review.html">Review</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="checkout.php">Check out </a> </li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><form action="logout.php" method="post">
                             <input type="submit" value="Logout" >
                    </li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">


        <h1>Admin: Edit Users</h1>

        <form name="admin">
        <table>
            
            <thead>
            <tr><th>Delete</th>
            <th>Username</th>
            <th>Password</th>
            </tr></thead>
            
            <tr>
                <td><input type="checkbox" name="delete"></td>
                <td contenteditable>Musharraf </td>
                <td contenteditable>password </td></tr>

            <tr>

                <td><input type="checkbox" name="delete"></td>
                <td contenteditable>Musharraf2 </td>
                <td contenteditable>password2 </td>

                <? 

                        //$statement = $databaseConnection->prepare("SELECT * from users");
                        //$statement->execute();

                        //if($statement->error)
                        //{
                        //    die("Database query failed: " . $statement->error);
                        //}

                        //$statement->bind_result($username, $password);
                        //while($statement->fetch())
                        //{
                        //    //
                        //}

                        ?>
 
            </tr>


        </table>
        </form>
    </div>
</body>

	
</html>


