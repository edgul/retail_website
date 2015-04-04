<!-- catalog.php 

-->
<?php
    require_once  ("Includes/session.php");
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");
	
    if (isset($_POST['add']) ){
  
		$username = $_SESSION['username']; 

		//collect additions to cart 
        $add[1] = $_POST['boss'];
        $add[2] = $_POST['#2'];
        $add[3] = $_POST['sales_rep'];
        $add[4] = $_POST['techie'];
        $add[5] = $_POST['assistant'];
        $add[6] = $_POST['manager'];
        $add[7] = $_POST['crew_lead'];
        $add[8] = $_POST['crew_member'];
        $add[9] = $_POST['hr'];
        $add[10] = $_POST['clerk'];
        $add[11] = $_POST['guest'];
        $add[12] = $_POST['coop'];
        $add[13] = $_POST['intern'];
        $add[14] = $_POST['secretary'];
        $add[15] = $_POST['janitor'];
		
		$addsum = array_sum($add);

		//get prices
		$pquery = $databaseConnection->query( "SELECT unitprice FROM inventory");

		for ( $i= 1; $i <= 15; $i ++){
			
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

        // Populate product images

        $(function () {
            var links = $('td:nth-child(3) a');
            for (var i = 0; i < links.length; i++) {
                $(links[i]).append('<img src="images/' + (i + 1) + '.jpg" class="img-responsive" />');
            }

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
                    <li><form action="logout.php" name="form1" method="post">
                             <input type="submit" value="Logout" ></form>
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
	}

	//print html	
	echo "
    <!-- container for catalog items -->
    <div class=\"container\">
        <div class=\"row\">

            <div class=\"col-md-4\">
                <h1 id=\"catalog\"> Catalog Items </h1>
				<a href=\"checkout.php\"> Proceed to Checkout </a>
            </div>
            
            <div class=\"col-md-4 col-md-offset-4\">
                <input id=\"search\" type=\"search\" name=\"search\" placeholder=\"Search for a product\" class=\"form-control\" style=\"margin-top: 18px; margin-bottom: auto;\" />
            </div>
        </div>


        <!-- Table Header -->
        <table class=\"table table-striped\" id=\"catalogTable\">
            <thead>
                <tr>
                    <th> In stock </th>
                    <th> Add to cart</th>
                    <th class=\"col-md-1\"> Image </th>
                    <th class=\"col-md-1\"> Name </th>
                    <th class=\"col-md-1\"> Price </th>
                    <th class=\"col-md-3\"> Description </th>
                    <th class=\"col-md-1\"> Type </th>
                    <th class=\"col-md-1\"> Processor </th>
                    <th class=\"col-md-1\"> Storage Space </th>
                    <th class=\"col-md-1\"> Storage Type </th>
                    <th class=\"col-md-1\"> Screen Size (inches) </th>
                    <th class=\"col-md-1\"> Product Review </th>
                </tr>
            </thead>

            <!-- Table Entries -->
            <tbody>


			<form action=\"catalog.php\" name=\"form2\" method=\"post\" >
			
                <!-- Row Entry1 -->
                <tr>
                    <td> " . $qty[0]. " </td>
                    <td> <select name=\"boss\"/> 
					";
					for ($i = 0; $i <= $qty[0]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td><a data-toggle=\"modal\" href=\"#imgModal\"></a></td>
                    <td> The Boss </td>  
                    <td> $1000 </td>
                    <td> Top of the line everything. For the big man.</td>
                    <td> Desktop </td>
                    <td> Intel i7 </td>
                    <td> 2 TB </td>
                    <td> HD </td>
                    <td> 30 </td>    
                    <td> ";
					if ($reviews[1])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry2 -->
                <tr>
                    <td> " . $qty[1] . " </td>
                    <td> <select name=\"#2\"/>
					";
					for ($i = 0; $i <= $qty[1]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td><a data-toggle=\"modal\" href=\"#imgModal\"></a></td>
                    <td> The #2 </td>
                    <td> $950 </td>
                    <td>
                        Portable version of the big boss's computer.
                    </td>
                    <td> Laptop </td>
                    <td> Intel i7 </td>
                    <td> 2 TB </td>
                    <td> HD </td>
                    <td> 15 </td>
                    <td> ";
					if ($reviews[2])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry3 -->
                <tr>
                    <td> " . $qty[2] . " </td>
                    <td> <select name=\"sales rep\"/>
					";
					for ($i = 0; $i <= $qty[2]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"></a></td>
                    <td> The Sales Rep </td>
                    <td> $900</td>
                    <td>
                        On the go, fast and pleasing.
                    </td>
                    <td> Laptop </td>
                    <td> Intel i5 </td>
                    <td> 750 GB </td>
                    <td> SSD </td>
                    <td> 14</td>
                    <td> ";
					if ($reviews[3])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry4 -->
                <tr>
                    <td> " . $qty[3] . " </td>
                    <td> <select name=\"techie\"/>
					";
					for ($i = 0; $i <= $qty[3]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Techie </td>
                    <td> $850</td>
                    <td>            
                        The best specs, somehow for a cheaper price!
                    </td>
                    <td> Laptop </td>
                    <td> Intel i7</td>
                    <td> 2 TB </td>
                    <td> SSD </td>
                    <td> 15 </td>
                    <td> ";
					if ($reviews[4])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry5 -->
                <tr>
                    <td> " . $qty[4] . " </td>
                    <td> <select name=\"assistant\"/>
					";
					for ($i = 0; $i <= $qty[4]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Assistant </td>
                    <td> $700 </td>
                    <td>
                        Help with what you need, when you need it, now!
                    </td>
                    <td> Laptop </td>
                    <td> Intel i5 </td>
                    <td> 500 GB </td>
                    <td> HD </td>
                    <td> 20 </td>
                    <td> ";
					if ($reviews[5])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                 </tr>     

                <!-- Row Entry6 -->
                 <tr>
                    <td> " . $qty[5] . " </td>
                    <td> <select name=\"manager\"/>
					";
					for ($i = 0; $i <= $qty[5]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                     <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Manager </td>
                    <td> $ 800 </td>
                    <td>
                        He doesn't do much, but he tells others how to do it.
                    </td>
                    <td> Desktop </td>
                    <td> Intel i7 </td>
                    <td> 1 TB </td>
                    <td> HD </td>
                    <td> 20 </td>
                    <td> ";
					if ($reviews[6])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry7 -->
                <tr>
                    <td> " . $qty[6] . " </td>
                    <td> <select name=\"crew lead\"/>
					";
					for ($i = 0; $i <= $qty[6]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td><a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Crew Lead </td>
                    <td> $600 </td>
                    <td>
                        Upper management material, underrecognized and overworked.
                    </td>
                    <td> Laptop </td>
                    <td> Intel i5</td>
                    <td> 750 GB </td>
                    <td> SSD </td>
                    <td> 14 </td>
                    <td> ";
					if ($reviews[7])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                 </tr>

                <!-- Row Entry8 -->
                 <tr>
                    <td> " . $qty[7] . " </td>
                    <td> <select name=\"crew member\"/>
					";
					for ($i = 0; $i <= $qty[7]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                     <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Crew Member </td>
                    <td> $550</td>
                    <td>
                        The dirty work of the company, lazy and overworked.
                    </td>
                    <td> Laptop </td>
                    <td> Intel i3 </td>
                    <td> 250 GB </td>
                    <td> HD </td>
                    <td> 14 </td>
                    <td> ";
					if ($reviews[8])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry9 -->
                <tr>
                    <td> " . $qty[8] . " </td>
                    <td> <select name=\"hr\"/>
					";
					for ($i = 0; $i <= $qty[8]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The HR </td>
                    <td> $700 </td>
                    <td>
                        MS array guru, can they use it to its full potential?
                    </td>
                    <td> Desktop </td>
                    <td> Intel i7</td>
                    <td> 1 TB </td>
                    <td> HD </td>
                    <td> 22 </td>
                    <td> ";
					if ($reviews[9])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                 </tr>

                <!-- Row Entry10 -->
                <tr>
                    <td> " . $qty[9] . " </td>
                    <td> <select name=\"clerk\"/>
					";
					for ($i = 0; $i <= $qty[9]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Clerk </td>
                    <td> $350 </td>
                    <td>
                        Did you say \"filing\"?
                    </td>
                    <td> Laptop </td>
                    <td>Intel i3 </td>
                    <td> 250 GB </td>
                    <td> HD </td>
                    <td> 15 </td>
                    <td> ";
					if ($reviews[10])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry11 -->
                <tr>
                    <td> " . $qty[10] . " </td>
                    <td> <select name=\"guest\"/>
					";
					for ($i = 0; $i <= $qty[10]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Guest </td>
                    <td> $300 </td>
                    <td>    
                        Provides basic access, with limited rights.
                    </td>
                    <td> Desktop </td>
                    <td> Intel i3</td>
                    <td> 250 GB </td>
                    <td> HD </td>
                    <td> 20 </td>
                    <td> ";
					if ($reviews[11])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry12 -->
                <tr>
                    <td> " . $qty[11] . " </td>
                    <td> <select name=\"coop\"/>
					";
					for ($i = 0; $i <= $qty[11]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Coop </td>
                    <td> $250 </td>
                    <td>
                        How did he get a better computer than the Intern?
                    </td>
                    <td> Laptop </td>
                    <td> Intel i5 </td>
                    <td> 750 GB </td>
                    <td> HD </td>
                    <td> 17</td>
                    <td> ";
					if ($reviews[12])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry13 -->
                <tr>
                    <td> " . $qty[12] . " </td>
                    <td> <select name=\"intern\"/>
					";
					for ($i = 0; $i <= $qty[12]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Intern</td>
                    <td> $200</td>
                    <td>
                        You're already investing in him. Don't spend a penny more.
                    </td>
                    <td> Desktop </td>
                    <td> Intel i3</td>
                    <td> 500 GB </td>
                    <td> HD </td>
                    <td> 15 </td>
                    <td> ";
					if ($reviews[13])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry14 -->
                <tr>
                    <td> " . $qty[13] . " </td>
                    <td> <select name=\"secretary\"/>
					";
					for ($i = 0; $i <= $qty[13]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Secretary </td>
                    <td> $100 </td>
                    <td>
                        Perfect for word processing and thats about it!
                    </td>
                    <td> Desktop </td>
                    <td> Intel i3</td>
                    <td> 500 GB </td>
                    <td> HD </td>
                    <td> 10 </td>
                    <td> ";
					if ($reviews[14])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>

                <!-- Row Entry15 -->
                <tr>
                    <td> " . $qty[14] . " </td>
                    <td> <select name=\"janitor\"/>
					";
					for ($i = 0; $i <= $qty[14]; $i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option> ";
					}
					echo "
						<input type=\"submit\" formaction=\"catalog.php\" formmethod=\"post\" value=\"add all items\" name=\"add\" >
					</td>
                    <td> <a data-toggle=\"modal\" href=\"#imgModal\"> </a></td>
                    <td> The Janitor </td>
                    <td> $75 </td>
                    <td>
                        A cardboard box with a picture of a monitor taped to it.
                    </td>
                    <td> Laptop </td>
                    <td> Banana Sticker</td>
                    <td> 256 KB  </td>
                    <td> HD </td>
                    <td> 7 </td>
                    <td> ";
					if ($reviews[15])
						echo " <a href='viewreview.php' > <input type='button' value='see review' >	</a> ";
					else
						echo "No review available.";
					echo "
					</td>    
                </tr>
				</form>
            </tbody>
        </table>

		<a href=\"checkout.php\"> Proceed to Checkout </a> 
		<p> </br> </br> </p>
    </div>


    <!-- Modal -->
    <div class=\"modal fade\" id=\"imgModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"imgModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"imgModalLabel\">Modal title</h4>
                </div>
                <div class=\"modal-body\">

                    <img class=\"img-responsive center-block\" src=\"images/logo.svg.png\" />
                </div>

            </div>
        </div>
    </div>

		";
?>

</body>
</html>

