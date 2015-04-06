
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
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li><a href='viewreview.php'>Reviews</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="purchaseconfirm.php">Your purchases</a></li>
					<li><a href="checkout.php"> Check Out </a></li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><a href='logout.php'>Logout</a>
					</li>
					<li><a href="admin.php">Admin</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <?php
            
            require_once("Includes/session.php");
            if (confirm_is_admin_and_alert_otherwise()): ?>
        <h1>Admin Actions</h1>

        <ul>
            <li><a href="admin_users.php">User Administration</a></li>
            <li><a href="admin_inventory.php">Inventory Administration</a></li>
        </ul>
        <?php endif; ?>                
    </div>

</body>

	
</html>