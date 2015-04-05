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

        td, th {
            text-align: center;
        }

        .thumbnail {
            width: 50px;
            height: 50px;
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

<?php 	
    
    require_once  ("Includes/session.php");
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");
    ?>

    <!-- container for catalog items -->
    <div class="container">

    <?php 


    if (confirm_is_logged_in_and_alert_otherwise()):

	//if coming from review page -> insert review into review table
	if(isset($_POST['reviewsub'])){
		$reviewpid = $_SESSION['reviewpid'];
		
		//if review for this product and username exists, delete 
		$databaseConnection->query( " DELETE FROM review WHERE username='" . $_SESSION['username'] . "' AND p_id='" . $reviewpid . "'");

		//insert review
		$databaseConnection->query( "INSERT INTO review VALUES ('" . $_SESSION['username'] . "','" . $reviewpid . "','" . $_POST['pseudonym'] . "','" . $_POST['numstars'] . "','" . $_POST['descMsg'] . "')" );
	}

	//purchse was just made -> insert cart into purchase table
	$date = date('ymd');	
	$recommend=false;
	
	if (isset($_POST['purchase'])){
	
			$recommend = true;	
			//get item num in inv	
			$numItemsInInv = $databaseConnection->query("SELECT * FROM inventory")->num_rows;

			//query users cart
			$result = $databaseConnection->query( "SELECT * FROM cart WHERE username='" . $_SESSION['username'] . "' OR username=''");
	
			//get latest ordernumber	
			$temp2 = $databaseConnection->query( "SELECT MAX(o_id) AS maxo FROM purchase" );
			$arg= $temp2->fetch_assoc();
			$maxordernumber = $arg['maxo'];
			if ($maxordernumber === NULL){
				$newordernumber = 1;
			}
			else{
				$newordernumber = $maxordernumber +1;
			}

			//remove from cart and put in purchase table
			if ( $result->num_rows > 0){
				$recommendNum=1;
			while (	$temp = $result->fetch_assoc() ){
				//store vital variables
				$username = $temp['username'];
				$qtyincart = $temp['qty'];
				$pidincart = $temp['p_id'];

				//accumulate reccomended Items array
				if ( $pidincart < $numItemsInInv){
					$recommendedItems [$recommendNum] = $pidincart +1;
					$recommendNum = $recommendNum + 1;
				}
				if ( $pidincart > 1){
					$recommendedItems [$recommendNum] = $pidincart -1;
					$recommendNum = $recommendNum + 1;
				}

				//remove from cart
				$databaseConnection->query( "DELETE FROM cart WHERE p_id='" . $pidincart . "' AND username='" . $username . "'");
		

				//insert new order into purchase table
				$databaseConnection->query( "INSERT INTO purchase VALUES (" . $newordernumber  . ",'" . $_SESSION['username'] . "','" . $pidincart . "'," . $qtyincart . ",'". $date  . "')");

			}				
		}	
	}

		//get rows from cart 
		$query = "SELECT p.*,i.name, i.unitprice, p.qty*i.unitprice AS \"Price\" FROM purchase AS p, inventory as i WHERE username='" . $_SESSION['username'] ."' AND p.p_id = i.p_id";
    	$result = $databaseConnection->query($query);
    	if ($result->num_rows > 0 ) { 
			$i = 0;
        	while($row = $result->fetch_assoc()){ 
				$name[$i] = $row["name"];
				$oid[$i] = $row["o_id"]; 
				$qty[$i] = $row["qty"];
				$unitp[$i] = $row["unitprice"];
				$pid[$i] = $row["p_id"];
				$price[$i] = $row["Price"];
			
				if ( $row["orderdate"] === date('ymd')){
					$status[$i] = "processing"; 
				}
				else {
					$status[$i] = "shipped";
				}
				$i = $i +1;
			}
		}
		
		//print_r($recommendedItems);	
		//print html	--  tables

			
					if ( $recommend){	
						echo "<h3> Recommended Items for You: </h3>
						";			

						echo " <table class=\"table table-striped\"> 
											<tr>
						";

						//print_r($recommendedItems);
						for  ( $j = 1; $j <  $recommendNum; $j++){
							echo " <td> 
											<a href=\"catalog.php\">  
													<img height='100' width='100' src='images/" .  $recommendedItems[$j] . ".jpg'> 
													" . $name[$recommendedItems[$j]] . " 
											</a> 
										</td>";
	
						}
						echo " </tr></table></br><hr></br>";
					}	

				echo "
        	<div class=\"row\">
            	<div class=\"col-md-4\">                	
                <h1 id=\"catalog\"> Your confirmed orders: </h1>
					<a href=\"catalog.php\"> Return to Catalog </a>
            	</div>
            	
            	<div class=\"col-md-4 col-md-offset-4\">
                	<input id=\"search\" type=\"search\" name=\"search\" placeholder=\"Search for an order by its order number\" class=\"form-control\" style=\"margin-top: 18px; margin-bottom: auto;\" />
            	</div>
        	</div>
			";	
	
			$neworder=false;	
			$lastordernum=0;
			$sum=0;
			for ($i = 0; $i < $result->num_rows; $i++){
				if($lastordernum !== $oid[$i]){
					$lastordernum = $oid[$i];
					echo "
                    <div class='orderDetails' id='orderDetails{$oid[$i]}'>
        			<!-- Table Header -->
        			<table class=\"table table-striped orderTable\" id=\"orderTable" . $oid[$i]  . "\">
            			<thead>
                			<tr>
                    			<th class=\"col-md-1\"> Order # </th>
                    			<th class=\"col-md-1\"> Qty </th>
                    			<th class=\"col-md-1\"> Item Id</th>
                    			<th class=\"col-md-1\"> Name </th>
                    			<th class=\"col-md-1\"> Unit Price </th>
                    			<th class=\"col-md-1\"> Price </th>
                    			<th class=\"col-md-1\"> Status </th>
                    			<th class=\"col-md-1\"> Review </th>
                			</tr>
            			</thead>
					";
				}
			
				echo "	
            		<!-- Table Entries -->
            		<tbody>

                	<tr>
                   		<td> " . $oid[$i] . " </td>
                   		<td> " . $qty[$i] . " </td>
                   		<td> " . $pid[$i] . " </td> 
                   		<td> " . $name[$i] . "</td> 
                   		<td> " . $unitp[$i] . " </td> 
                   		<td> " . $price[$i] . " </td> 
                   		<td> " . $status[$i] . " </td> 
                   		<td> 
							<form action='productreview.php' method='post'>
							<input type='submit' name='review" . $pid[$i] . "' value='review' </td> 
                	</tr>
            		</tbody>
				";
				
				$sum=$sum + $price[$i];
				$tax= $sum * 0.13;
				$total= $sum * 1.13;
						
				if ($oid[$i+1] !== $oid[$i]){
				echo "	
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
			</table></div> </br> </br> </br>
					";
					$sum=0;
					$tax=0;
					$total=0;
				}
	
			}
		


?>

    	</div>

        <script src="Scripts/jquery-1.11.2.js"></script>
    <script src="Scripts/bootstrap.js"></script>
    <script>



        /* Order Search */
        var searchEl = $("#search")[0];
        $(searchEl).on('input', function (e) {
            var searchText = searchEl.value;
            var orderDetails = $(".orderDetails");

            for (var i = 0; i < orderDetails.length; i++) {
                var item = orderDetails[i];
                if ((item.id == "orderDetails" + searchText) || (searchText == "")) {
                    $(item).show("fast")
                } else {
                    $(item).hide("fast");       // otherwise hide the row
                }

            }
        });

    </script>
    <?php endif; ?>
</body>
</html>

