<!-- checkout.php 

-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>EnterpriseHardware.com - Contact</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />
    
    <style>
        /* Fix for scroll jump */
        html {
	overflow-y: scroll; 
}

        tr td:first-child {
            text-align: center;
        }

        .thumbnail {
            width: 50px;
            height: 50px;
        }
        
    </style>
    
    <script src="Scripts/jquery-1.11.2.js"></script>
    <script src="Scripts/bootstrap.js"></script>
    <script>

        var ck_creditcard= /^([0-9]{4}[ -_]{0,1}){4}$/;
		var ck_expireMM = /^0[0-9]|1[0-2]$/;
		var ck_expireYY = /^1[5-9]$/;

        function validate(form) {
            //initialization of variables from fields
            var creditcard = document.getElementById("creditcard").value;
            var expireMM= document.getElementById("expireMM").value;
            var expireYY= document.getElementById("expireYY").value;
            var errors = [];

            if (!ck_creditcard.test(creditcard)) {
                errors[errors.length] = "Please enter a valid credit card number.";
            }
            if (!ck_expireMM.test(expireMM)) {
                errors[errors.length] = "Please enter a valid expiry month.";
            }
            if (!ck_expireYY.test(expireYY)) {
                errors[errors.length] = "Please enter a valid expiry year.";
            }

            if (errors.length > 0) {
                reportErrors(errors);
                return false;
            }
            else {
				return true;
			}
       	} 

		function reportErrors(errors) {
            var msg = "Please Enter Valid Data...\n";
            for (var i = 0; i<errors.length; i++) {
                var numError = i + 1;
                msg += "\n" + numError + ". " + errors[i];
            }
            alert(msg);
        }

    </script>

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
    
	<!-- container for catalog items -->
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h1 id="catalog"> Checkout </h1>
				<a href="catalog.php"> Return to Catalog </a>
            </div>
            
            <div class="col-md-4 col-md-offset-4">
                <input id="search" type="search" name="search" placeholder="Search for a product" class="form-control" style="margin-top: 18px; margin-bottom: auto;" />
            </div>
        </div>

<?php 	
    
    require_once  ("Includes/session.php");
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");

	//clicking remove from cart	
	for ($i = 1; $i < 15; $i++){
		if (isset($_POST['pullcart'.$i])){
			
			//remove from cart
			$result = $databaseConnection->query( "SELECT * FROM cart WHERE p_id='" . $i . "'");
			$temp = $result->fetch_assoc();
			$qtyincart = $temp['qty'];
			$databaseConnection->query( "DELETE FROM cart WHERE p_id='" . $i . "'");
				
			
			//return to inv
			$result = $databaseConnection->query( "SELECT qty FROM inventory WHERE p_id='" . $i . "'");
			$temp = $result->fetch_assoc();
			$qtyininv = $temp['qty'];
			$updateqty = $qtyininv + $qtyincart;
			$databaseConnection->query( "UPDATE inventory SET qty='" . $updateqty . "' WHERE p_id='" . $i . "'");
		}	
	}
	
	if (!isset($_SESSION['username'])){
		echo "
    		<div class=\"container\">
				<h1> You Must login to see this page. </h2><br/>
				<a href=\"login.php\" > Login </a>
			</div>
		";
	}
	else {

	$username = $_SESSION['username'];
	//get rows from cart 
	$query = "SELECT *, qty*unitprice AS \"Price\" FROM cart WHERE username='" . $username . "' OR username='' ";
    $result = $databaseConnection->query($query);
    if ($result->num_rows > 0 ) { 
		$i = 0;
        while($row = $result->fetch_assoc()){
			$qty[$i] = $row["qty"];
			$unitp[$i] = $row["unitprice"];
			$pid[$i] = $row["p_id"];
			$price[$i] = $row["Price"];
			$i = $i +1;
		}
	}


		echo "
        <!-- Table Header -->
        <table class=\"table table-striped\" id=\"catalogTable\">
            <thead>
                <tr>
                    <th class=\"col-md-1\"> </th>
                    <th class=\"col-md-1\"> Qty </th>
                    <th class=\"col-md-1\"> Item Id</th>
                    <th class=\"col-md-1\"> Name </th>
                    <th class=\"col-md-1\"> Unit Price </th>
                    <th class=\"col-md-1\"> Price </th>
                </tr>
            </thead>

            <!-- Table Entries -->
            <tbody>
			";

			$sum=0;
			for ($i = 0; $i < $result->num_rows; $i++){
				echo "	
                <tr>
					<td> <form action=\"checkout.php\" method=\"post\" >
						<input type=\"submit\" name=\"pullcart" . $pid[$i] . "\" value=\"remove from cart\"> </form> </td>
                    <td> " . $qty[$i] . " </td>
                    <td> " . $pid[$i] . " </td> 
                    <td> NAME </td> 
                    <td> " . $unitp[$i] . " </td> 
                    <td> " . $price[$i] . " </td> 
                </tr>
					";
				$sum=$sum + $price[$i];
			}
			$tax= $sum * 0.13;
			$total= $sum * 1.13;
		
			echo "	
            </tbody>
        </table>
		<table>
				<tr>
					<td>Sub-Total: </td>
					<td> $" . $sum . " </td>
				</tr>
				<tr>
					<td>Tax: </td>
					<td> $" . $tax . " </td>
				</tr>
				<tr>
					<td>Total: </td>
					<td> $" . $total . " </td>
				</tr>
		</table>
		";
	}
?>

		<form action="purchaseconfirm.php" method="post" >
			</br>
			<hr>
			</br>
			<h4> Enter your credit card information</h4>
			Card Number:
			<input type="text" name="creditcard" id="creditcard" />
			Expiry:		
			<select name='expireMM' id='expireMM'>
    			<option value=''>Month</option>
    			<option value='01'>Janaury</option>
    			<option value='02'>February</option>
    			<option value='03'>March</option>
    			<option value='04'>April</option>
    			<option value='05'>May</option>
    			<option value='06'>June</option>
    			<option value='07'>July</option>
    			<option value='08'>August</option>
    			<option value='09'>September</option>
    			<option value='10'>October</option>
    			<option value='11'>November</option>
    			<option value='12'>December</option>
			</select> 
			<select name='expireYY' id='expireYY'>
    			<option value=''>Year</option>
    			<option value='15'>2015</option>
    			<option value='16'>2016</option>
    			<option value='17'>2017</option>
    			<option value='18'>2018</option>
    			<option value='19'>2019</option>
			</select> 	
			</br>
			</br>
			<input onclick="return validate(form)" type="submit" value="confirm purchase" name="purchase" />
		</form>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="imgModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">

                    <img class="img-responsive center-block" src="images/logo.svg.png" />
                </div>

            </div>
        </div>
    </div>

</body>
</html>

