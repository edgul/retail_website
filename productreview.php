<!-- productreview.php
     Provides avenue to rate purchased product 

-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>EnterpriseHardware.com - Sitemap</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />
    <script src="Scripts/jquery-1.11.2.js"></script>
    <style>
        a#stars:hover, a#start:active, a#stars:visited, a#stars:link {
            text-decoration: none;
        }

        a#stars {
            color: #91170a;
        }

        a:hover, a:focus {
            color: #d9230f;
        }

        .starhover {
            color: #d9230f;
        }

        .starclicked {
            color: #d9230f;
            /*text-shadow: #d9230f 0px 0px 2px 2px;*/
            text-shadow: 2px 2px 5px #4e120b;
            
        }
    </style>
</head>

<body>
    <!-- navbar code -->
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
                    <li class="active"><a href="review.html">Review</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="purchaseconfirm.php">Your purchases</a></li>
                    <li><a href="checkout.php">Check out </a> </li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><a href='logout.php'>Logout</a>
                    </li>
					<li><a href="#">Help</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
<?php
	require_once("Includes/session.php");

	print_r($_POST);
	for ($i = 1; $i <= 15; $i++){
		if (isset($_POST['review' . $i])){
			$_SESSION['reviewpid'] = $i;	
		}
	}

?>
    <div class="container">

        <div class="jumbotron text-center">

            <!-- Header and stars input-->
            <p class="page-header">
                What did you think of this product?
            </p>
            <p>
                <a href="#" id="stars">
                    <span class="glyphicon glyphicon-star" data-rating="1"></span>
                    <span class="glyphicon glyphicon-star" data-rating="2"></span>
                    <span class="glyphicon glyphicon-star" data-rating="3"></span>
                    <span class="glyphicon glyphicon-star" data-rating="4"></span>
                    <span class="glyphicon glyphicon-star" data-rating="5"></span>
                </a>
            </p>

            <!-- form with input fields and buttons -->
            <form method="post" action="purchaseconfirm.php" name="form" id="form" >
                User: <br />
                <input type="text" onclick="this.value = '';" name="pseudonym" id="pseudonym" value="anonymous" /> <br /> <br />
                
                Describe your experience with this product :<br />
                <textarea style="height:200px; width:400px" name="descMsg" id="descMsg"> </textarea> <br /><br />
				<input type="hidden" name="numstars" id="numstars" value="1"> 
				
				Multiple ratings of the same product will be overwritten. </br>
                <input type="submit" onclick="return post_prep()" formaction="purchaseconfirm.php" formmethod="post" name="reviewsub" value="submit review" id="reviewsub"/>

            </form>
        </div>


    </div>
    <script>
        var rating;
        var reviewMsg;
        var splitMsg;
        var user;
        var starsEls = $("a#stars span");

        //mouse hover color change on stars
        starsEls.hover(function (event) {
            var thisstar = $(event.target);
            for (var i = 0; i < starsEls.length; i++) {
                if ($(starsEls[i]).data('rating') <= thisstar.data('rating')) {
                    $(starsEls[i]).addClass('starhover');
                }
            }
        }, function (event) {
            starsEls.removeClass('starhover');
        });

        //mouse click -- changes colour
        starsEls.click(function (event) {
            rating = $(event.target).data('rating');

            var thisstar = $(event.target);
            for (var i = 0; i < starsEls.length; i++) {
                if ($(starsEls[i]).data('rating') <= thisstar.data('rating')) {
                    $(starsEls[i]).addClass('starclicked');
                } else {
                    $(starsEls[i]).removeClass('starclicked');
                }
            }


        });

        //add review to html
		function post_prep() {
            //grabs and checks the inputs if null
            reviewMsg = $("#descMsg").val();
            if (rating == null ) {
                alert("Before submitting you must Rate by stars\n\t");
				return false;
            }
            else {
                user = $("#username").val();
                if (user == '') {
                   user = "Anonymous";
                }
               
				//hides review in html
				document.getElementById("numstars").setAttribute("value", rating);
				return true;

            }
        }
            
    </script>

</body>


</html>

