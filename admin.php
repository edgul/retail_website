<!-- sitemap.html 
     Displays all visitable web pages on the website
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>EnterpriseHardware.com - Sitemap</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />
    <style>
        .dataChanged {
            border:  1px solid red;
        }
    </style>
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
                    <li><a href="catalog.html">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li><a href="review.html">Review</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><form action="logout.php" method="post">
                             <input type="submit" value="Logout" ></form>
                    </li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">


        <h1>Admin: Edit Users</h1>

        <form name="admin">
        <table class="table table-striped">
            
            <thead><tr>
                <th>Delete</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            <th>Phone #</th>
            <th>Street #</th>
            <th>Street Name</th>
            <th>Unit #</th>
            <th>City</th>
            <th>Province</th>
            <th>Postal Code</th>

                <th>Password</th>
            </tr></thead>
            
          <tbody>

            <?php

                require_once ("Includes/var_init.php"); 
                require_once  ("Includes/connectDB.php");
                require_once  ("Includes/session.php");
                                    //echo "Hello";
                
                    $query = "SELECT * FROM users";
                    $result = $databaseConnection->query($query);
                    if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo '<td><input type="checkbox" name="delete"></td>';
				            echo "<td contenteditable>" . $row["username"] . "</td>";
                            echo "<td contenteditable>" . $row["fname"] . "</td>";
                            echo "<td contenteditable>" . $row["lname"] . "</td>";
                            echo "<td contenteditable>" . $row["email"] . "</td>";
                            echo "<td contenteditable>" . $row["phone_num"] . "</td>";
                            echo "<td contenteditable>" . $row["street_num"] . "</td>";
                            echo "<td contenteditable>" . $row["street_name"] . "</td>";
                            echo "<td contenteditable>" . $row["unit_num"] . "</td>";
                            echo "<td contenteditable>" . $row["city"] . "</td>";
                            echo "<td contenteditable>" . $row["province"] . "</td>";
                            echo "<td contenteditable>" . $row["postalcode"] . "</td>";
                            echo "<td contenteditable>" . $row["password"] . "</td>";
				            echo "</tr>";
			            }
                    } else {
                        echo "no resulsts";
                    }


                ?>
        </tbody></table>
        </form>
                        
    </div>
    <script>
        var tds = document.querySelectorAll("form td");
        for (var i = 0; i < tds.length; i++) {
            tds[i].addEventListener("DOMSubtreeModified", function (ev) {
                //tds[i].style = "border: 10px solid red;";
                //tds[i].parentElement.className = "dataChanged";
            });
        }
    </script>
</body>

	
</html>


