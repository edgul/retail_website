<!-- sitemap.html 
     Displays all visitable web pages on the website
-->
<?php 
    require_once  ("Includes/session.php");
?>
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

<!--  Contains form and fields for text entry -->
    <div class="container">

        <?php 

    if (isset($_POST['submit'])){
    	require_once ("Includes/var_init.php"); 
    	require_once  ("Includes/connectDB.php");
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        $type = $_POST['type']; 
        $proc = $_POST['proc']; 
        $space = $_POST['space'];
        $s_type = $_POST['s_type'];
        $screen = $_POST['screen'];

		$query = "INSERT INTO inventory VALUES ('" . $pid . "','" . $name . "','" . $qty . "','" . $price . "','" . $type . "','" . $proc . "','" . $space . "','" . $s_type . "','" . $screen . "')";

		$statement = $databaseConnection->query($query);
        if ($statement) {
            echo "Successful";
        } else {
            echo "Not successful";
        }

    }
?>


            <h1>Add Inventory</h1>
        <div class="col-sm-4">
            <form action="" method="post" name="form" id="form" >
                <fieldset>

                    <!-- Contact info fields -->
                    <legend>Product Inventory Details</legend>
                    <div class="form-group">
                        <label for="name" class=" control-label" >Name</label>
                        <div class=""><input type="text" id="name" name="name" class="form-control"  ></div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class=" control-label">
                            Quantity
                        </label><div class="">
                            <input type="text" name="qty" id="qty" class="form-control"  >
                        </div>
                    </div>

                                        <div class="form-group">
                        <label for="price" class=" control-label">
                            Unit Price
                        </label><div class="">
                            <input type="text" name="price" id="price" class="form-control"  >
                        </div>
                    </div>

                    
                </fieldset>

                <!-- Shipping info fields -->
                <fieldset>
                    <legend>Specs</legend>

                    <div class="form-group">
                        <label for="type" class=" control-label">
                            Type
                        </label><div class="">
                            <input type="text" name="type" id="type" class="form-control"  >
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="proc" class=" control-label">
                            Processer
                        </label><div class="">
                            <input type="text" name="proc" id="proc" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="space" class=" control-label">
                            Storage Space
                        </label><div class="">
                            <input type="text" name="space" id="space" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="s_type" class=" control-label">
                            Screen type
                        </label><div class="">
                            <input type="text" name="s_type" id="s_type" list="s_types" class="form-control"  >
                        </div>
                    </div>

                                        <div class="form-group">
                        <label for="screen" class=" control-label">
                            Screen Size
                        </label><div class="">
                            <input type="text" name="screen" id="screen" class="form-control">
                        </div>
                    </div>

                    <datalist id="s_types">
                        <option>HD</option>
                        <option>SSD</option>
                    </datalist>

                    
                </fieldset>

                

                <!-- Submit and clear buttons -->
                <div class="form-group ">
                    <input type="reset" value="Clear Form" class="btn btn-default">
                    <input type="submit" name="submit"  onclick="return validate(form)" value="Add Inventory" class="btn btn-default pull-right">

                </div>
            </form>

           
        </div>
        </div>
                        
    </div>
</body>

	
</html>


