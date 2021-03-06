﻿<!-- checkout.php 

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
        /* Product Search */
        var searchEl = $("#search")[0]; 
        $(searchEl).on('input', function (e) {
            var searchText = searchEl.value;
            var regex = new RegExp(searchText, "i");    // case insensitive
            var itemRows = $("#catalogTable tbody tr");

            outer:
            for (var i=0; i<itemRows.length; i++) {
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
            var links = $('td:nth-child(2) a');
            for (var i=0; i<links.length; i++) {
                $(links[i]).append('<img src="images/' + (i+1) + '.jpg" class="img-responsive" />');
            }
        });

        // Img modal box

        $('#imgModal').on('show.bs.modal', function (event) {
            var thumbnailLink = $(event.relatedTarget) // Link that triggered the modal
            var productImgSrc = thumbnailLink.find('img')[0].src;
            var productTitle = thumbnailLink.parent().siblings(':nth-child(3)').text();     // grab the product title from different column of same row

            var modal = $(this);
            modal.find('.modal-body img')[0].src = productImgSrc;
            modal.find('.modal-title').text(productTitle);

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
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li class="active"><a href='viewreview.php'>Reviews</a></li>
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

<?php 	
    
    require_once  ("Includes/session.php");
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");

	//view purchases already made	

	//get rows from cart 
	$query = "SELECT * FROM review";
    $result = $databaseConnection->query($query);
    if ($result->num_rows > 0 ) { 
		$i = 0;
        while($row = $result->fetch_assoc()){ 
			$pseudonym[$i] = $row['pseudonym'];
			$pid[$i] = $row["p_id"];
			$rating[$i] = $row["rating"];
			$msg[$i] = $row["msg"];
		
			$i = $i +1;
		}
	}

	//print html	--  tables
	echo "
    <!-- container for catalog items -->
    <div class=\"container\">
                <h1 id=\"catalog\"> Reviewed Items: </h1>
				<a href=\"catalog.php\"> Return to Catalog </a>
        <div class=\"row\">
            <div class=\"col-md-4 col-md-offset-4\">
            </div>
        </div>


        <!-- Table Header -->
        <table class=\"table table-striped\" id=\"catalogTable\">
            <thead>
                <tr>
                    <th class=\"col-md-1\"> Review by </th>
                    <th class=\"col-md-1\"> Product Id </th>
                    <th class=\"col-md-1\"> Star Rating /5 </th>
                    <th class=\"col-md-1\"> Description </th>
                </tr>
            </thead>

            <!-- Table Entries -->
            <tbody>
			";

			for ($i = 0; $i < $result->num_rows; $i++){
				echo "	
                <tr>
                    <td> " . $pseudonym[$i] . " </td>
                    <td> " . $pid[$i] . " </td> 
                    <td> " . $rating[$i] . " </td> 
                    <td> " . $msg[$i] . " </td> 
                </tr>
					";
			}
				echo "	
            </tbody>
        </table>

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

