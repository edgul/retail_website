
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
        .actionBtn {
            height: 1.5em;
            width: auto;
        }
    </style>
</head>

<body>
    <!-- Nav bar code -->
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
                    <li class="active"><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li><a href="review.html">Review</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="purchaseconfirm.php">Your purchases</a></li>
					<li><a href="checkout.php"> Check Out </a></li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><form action="logout.php" name="form1" method="post">
                             <input type="submit" value="Logout" ></form>
					</li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <h1>Admin Actions</h1>

        <ul>
            <li><a href="admin_users.php">User Administration</a></li>
            <li><a href="admin_inventory.php">Inventory Administration</a></li>
        </ul>
                        
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


<!--
        

        <h1>Admin: Edit Purchase</h1>

        <form name="adminPurchase">
        <table class="table table-striped">
            
            <thead><tr>
                <th>Delete</th>
                <th>Order Id</th>
                <th>Username</th>
                <th>Product Id</th>
                <th>Qty</th>
            <th>Unit Price</th>
            <th>Order Date</th>
            </tr></thead>
            
          <tbody>

            <?php

                require_once ("Includes/var_init.php"); 
                require_once  ("Includes/connectDB.php");
                require_once  ("Includes/session.php");

                    $query = "SELECT * FROM purchase";
                    $result = $databaseConnection->query($query);
                    if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo '<td><input type="checkbox" name="delete"></td>';
				            echo "<td contenteditable>" . $row["o_id"] . "</td>";
                            echo "<td contenteditable>" . $row["username"] . "</td>";
                            echo "<td contenteditable>" . $row["p_id"] . "</td>";
                            echo "<td contenteditable>" . $row["qty"] . "</td>";
                            echo "<td contenteditable>" . $row["unitprice"] . "</td>";
                            echo "<td contenteditable>" . $row["orderdate"] . "</td>";
				            echo "</tr>";
			            }
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


-->