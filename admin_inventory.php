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
                    <li><a href='logout.php'>Logout</a>
					</li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">

                   <?php

                require_once ("Includes/var_init.php"); 
                require_once  ("Includes/connectDB.php");
                require_once  ("Includes/session.php");

            if (confirm_is_admin_and_alert_otherwise()): ?>

        <?php
                if (isset($_GET['action']) && $_GET['action'] == "delete") {
                    $query = "DELETE FROM inventory WHERE p_id = {$_GET['pid']};";
                    $result = $databaseConnection->query($query);
                    if ($result) {
                        echo '<div class="alert alert-success" role="alert">User successfully deleted! Return to <a href="admin_inventory.php">Inventory Administration</a></div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">User deletion failed.</div>';
                    }
                }

                ?>

        <p><a href="admin.php">Admin Home</a> >> <a href="admin_inventory.php">Inventory Administration</a> </p>
        <h1>Admin: Edit Inventory</h1>

        <form name="adminInventory">
        <table class="table table-striped">
            
            <thead><tr>
                <th>Actions</th>
                <th>Product Id</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
            <th>Type</th>
            <th>Proc</th>
            <th>space</th>
            <th>s_type</th>
            <th>Screen</th>
            </tr></thead>
            
          <tbody>

            <?php

                require_once ("Includes/var_init.php"); 
                require_once  ("Includes/connectDB.php");
                require_once  ("Includes/session.php");
                                    //echo "Hello";
                
                    $query = "SELECT * FROM inventory";
                    $result = $databaseConnection->query($query);
                    if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            //echo '<td><input type="checkbox" name="delete"></td>';
                            echo "<td>
                            <a href='?action=delete&pid={$row['p_id']}'><img class='actionBtn' src='images/delete.png'></a>
                            <a href='admin_inventory_update.php?pid={$row['p_id']}'><img class='actionBtn' src='images/page_edit.png'></a>
                                </td>";
				            echo "<td contenteditable>" . $row["p_id"] . "</td>";
                            echo "<td contenteditable>" . $row["name"] . "</td>";
                            echo "<td contenteditable>" . $row["qty"] . "</td>";
                            echo "<td contenteditable>" . $row["unitprice"] . "</td>";
                            echo "<td contenteditable>" . $row["type"] . "</td>";
                            echo "<td contenteditable>" . $row["proc"] . "</td>";
                            echo "<td contenteditable>" . $row["space"] . "</td>";
                            echo "<td contenteditable>" . $row["s_type"] . "</td>";
                            echo "<td contenteditable>" . $row["screen"] . "</td>";
				            echo "</tr>";
			            }
                    }

                    echo "<tr><td colspan='10' style='text-align:center;'><a href='admin_inventory_create.php'><img class='actionBtn' src='images/add.png'></a></td></tr>"


                ?>
        </tbody></table>
        </form>

        <?php endif; ?>
                        
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


