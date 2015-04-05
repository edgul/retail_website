<!-- catalog.php 

-->
<?php
    require_once  ("Includes/session.php");
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/common.php");
	
    if (isset($_POST['add']) ){
  
		$username = $_SESSION['username']; 

        $numProds = $databaseConnection->query("SELECT * FROM inventory")->num_rows;

        		for ( $i= 1; $i <= $numProds; $i++){
                    $add[$i] = $_POST[$i + ""];
                }

		
		$addsum = array_sum($add);

		//get prices
		$pquery = $databaseConnection->query( "SELECT unitprice FROM inventory");

		for ( $i= 1; $i <= $numProds; $i ++){
			
			//update inventory counts 
			$j ="inv" . $i;
			$left[$i] = $_SESSION[$j] - $add[$i];
			$tempprice = $pquery->fetch_assoc();
			$prices[$i] = $tempprice["unitprice"];
			$query = "UPDATE inventory SET qty='" . $left[$i] . "' WHERE p_id='" . $i . "'";
        	$databaseConnection->query($query);
	
			//add to shopping cart table: recentlyAddedToCart + AlreadyInCart
			if ( $add[$i] > 0 ){
				$qtyincart = $databaseConnection->query( "SELECT qty FROM cart WHERE p_id='" . $i . "'");
				$oldcart= $qtyincart->fetch_assoc();
				$add[$i]=$add[$i]+$oldcart['qty'];
				echo $oldcart['qty']+$add[$i];
				$databaseConnection->query("DELETE FROM cart WHERE username='" . $username ."' AND p_id='" . $i . "'");
				$query = "INSERT INTO cart VALUES ('" . $username . "','" . $i . "','" . $add[$i] . "','" . $prices[$i] . "')";		
				$databaseConnection->query($query); 
			}

		}
		
		//notify items that were added
	
	}	
?>

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
        /* Product Search */
        var searchEl = $("#search")[0];
        $(searchEl).on('input', function (e) {
            var searchText = searchEl.value;
            var regex = new RegExp(searchText, "i");    // case insensitive
            var itemRows = $("#catalogTable tbody tr");

            outer:
            for (var i = 0; i < itemRows.length; i++) {
                var item = itemRows[i];
                var cols = $("td", item);
                for (var j = 1; j < cols.length; j++) {
                    if (regex.test(cols[j].innerText)) {    // if search term matches any text in any column for a row, then show that row
                        $(item).show("slow");
                        continue outer;
                    }
                }
                $(item).hide("slow");       // otherwise hide the row
            }
        });

        //// Populate product images

        $(function () {
        //    var links = $('td:nth-child(3) a');
        //    for (var i = 0; i < links.length; i++) {
        //        $(links[i]).append('<img src="images/' + (i + 1) + '.jpg" class="img-responsive" />');
        //    }

            // Img modal box

        $('#imgModal').on('show.bs.modal', function (event) {
            var thumbnailLink = $(event.relatedTarget); // Link that triggered the modal
            var productImgSrc = thumbnailLink.find('img')[0].src;
            var productTitle = thumbnailLink.parent().siblings('td:nth-child(4)').text();     // grab the product title from different column of same row

            var modal = $(this);
            modal.find('.modal-body img')[0].src = productImgSrc;
            modal.find('.modal-title').text(productTitle);

        });


        });


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
                    <li><a href='logout.php'>Logout</a></form>
					</li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

<?php 	
    
	//get quantities from inventory
	$query = "SELECT * FROM inventory ";
    $result = $databaseConnection->query($query);
    if ($result->num_rows > 0 ) { 
		$i = 0;
        while($row = $result->fetch_assoc()){
			$qty[$i] = $row["qty"];
			$i = $i +1;
		}
	}

	//assign quantities to session var
	for ($i=1; $i <=15; $i ++){
		$_SESSION['inv'.$i] = $qty[$i-1];
	}	

	
	//makes array of already reviewed products
	$reviews = array_fill(1, 15, False);
	print_r($reviews);
	$query = "SELECT * FROM review ";
	$query = $databaseConnection->query($query);
	while ( $row = $query->fetch_assoc()){
		$reviews[$row['p_id']] = True; 
	} ?>


    <!-- container for catalog items -->
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h1 id="catalog"> Catalog Items </h1>
				<a href="checkout.php"> Proceed to Checkout </a>
            </div>
            
            <div class="col-md-4 col-md-offset-4">
                <input id="search" type="search" name="search" placeholder="Search for a product" class="form-control" style="margin-top: 18px; margin-bottom: auto;" />
            </div>
        </div>

        			<form action="catalog.php" name="form2" method="post" >
        <!-- Table Header -->
        <table class="table table-striped" id="catalogTable">
            <thead>
                <tr>
                    <th> In stock </th>
                    <th> Add to cart</th>
                    <th class="col-md-1"> Image </th>
                    <th class="col-md-1"> Name </th>
                    <th class="col-md-1"> Price </th>
                    <th class="col-md-3"> Description </th>
                    <th class="col-md-1"> Type </th>
                    <th class="col-md-1"> Processor </th>
                    <th class="col-md-1"> Storage Space </th>
                    <th class="col-md-1"> Storage Type </th>
                    <th class="col-md-1"> Screen Size (inches) </th>
                    <th class="col-md-1"> Product Review </th>
                </tr>
            </thead>

            <!-- Table Entries -->
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
				            echo "<td contenteditable>" . $row["qty"] . "</td>";
                            echo "<td><select name='{$row['p_id']}'>";
                            for ($i = 0; $i <= $row['qty']; $i++){
						        echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					        }
                            echo '<input type="submit" formaction="catalog.php" formmethod="post" value="add all items" name="add" >';
                            echo "</td>";

                            echo '<td><a data-toggle="modal" href="#imgModal"><img src="' . getImageSrc($row['image_link']) . '" class="img-responsive" /></a></td>';
                                                        echo "<td contenteditable>" . $row["name"] . "</td>";
                            echo "<td contenteditable>" . $row["unitprice"] . "</td>";
                            echo "<td contenteditable>" . $row['descr'] . "</td>";
                            echo "<td contenteditable>" . $row["type"] . "</td>";
                            echo "<td contenteditable>" . $row["proc"] . "</td>";
                            echo "<td contenteditable>" . $row["space"] . "</td>";
                            echo "<td contenteditable>" . $row["s_type"] . "</td>";
                            echo "<td contenteditable>" . $row["screen"] . "</td>";
                            echo "<td contenteditable>" . "Review here" . "</td>";
				            echo "</tr>";
			            }
                    }

                    

                ?>
				
            </tbody>
        </table>
                        </form>

		<a href="checkout.php"> Proceed to Checkout </a> 
		<p> </br> </br> </p>
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

