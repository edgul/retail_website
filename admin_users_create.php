<?php 
    require_once  ("Includes/session.php");

    if (isset($_POST['submit'])){
    	require_once ("Includes/var_init.php"); 
    	require_once  ("Includes/connectDB.php");
        $username = $_POST['username'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email']; 
        $phone_num = $_POST['phone']; 
        $street_num = $_POST['streetnum'];
        $street_name = $_POST['streetname'];
        $unit_num = $_POST['unitnum'];
        $city= $_POST['city'];
        $province= $_POST['province'];
        $postalcode= $_POST['postalcode'];
        $password = $_POST['password1'];

		$query = "INSERT INTO users VALUES ('" . $username . "','" . $fname . "','" . $lname . "','" . $email . "','" . $phone_num . "','" . $street_num . "','" . $street_name . "','" . $unit_num . "','" . $city . "','" . $province . "','" . $postalcode . "','" . $password . "')";

		$statement = $databaseConnection->query($query);
 
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;

    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>EnterpriseHardware.com - Create User</title>
    <link rel="stylesheet" type="text/css" href="extra.css" />

    <script type="text/javascript">

        // Name: Allowing one-word names (eg. Musharraf), or multi world names seperated by spaces (eg. Abu Bakr) or dashes (Abu Bakr)
        var ck_name = /^([A-Z]+[- ]?)+$/i; // if we put - at end of character class, no need to escape. But still good idea to

        // Phone: DDD-DDD-DDDD (D is a digital)
        var ck_phone = /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/;
        // Email: the most common emails are matched
        var ck_email = /^[\w._%+-]+@([\w-]+\.)+[A-Z]{2,10}$/i;
        // Username: cannot contain special symbols, except ., - & _, and must be less than 20 characters
        var ck_username = /^[\w._-]{1,20}$/i;
        // City: Allowing letters, spaces, and dashes
        var ck_city = /^[A-Z \-]{2,30}$/i;
        // Street #: Digits
        var ck_str_num = /^[0-9]{1,10}$/;
        // Street name: letters, spaces, dashes allowed
        var ck_str_name = /^[A-Z0-9 .\-]{3,30}$/i;
        // Postal Code: Letter, Num, Letter <space or dash> Num, Letter, Num (eg. L8S 1X3)
        var ck_postalcode = /^[A-Z][0-9][A-Z][ -]?[0-9][A-Z][0-9]$/i;
        // Password: At least 6 characters. At least one: uppercase, lowercase, symbol and digit 
        var ck_password = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])([a-zA-Z0-9!@#$%^&*]+)$/;
       

		
		//creates cookie
        function setCookie(cname, cvalue, password, pvalue) {
            document.cookie = cname + "=" + cvalue + ";";
            document.cookie = password + "=" + pvalue + ";";
        }

        //gets existing cookie
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }

        function validate(form) {
            //initialization of variables from fields
            var firstname = document.getElementById("firstname").value;
            var lastname = document.getElementById("lastname").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var streetnum = document.getElementById("streetnum").value;
            var streetname = document.getElementById("streetname").value;
            var unitnum = document.getElementById("unitnum").value;
            var city = document.getElementById("city").value;
            var username = document.getElementById("username").value;
            var postalcode = document.getElementById("postalcode").value;
            var password1 = document.getElementById("password1").value;
            var password2 = document.getElementById("password2").value;
            var errors = [];

            //checks fields to regex
            if (!ck_name.test(firstname)) {
                errors[errors.length] = "You must enter a valid First Name .";
            }
            if (!ck_name.test(lastname)) {
                errors[errors.length] = "You must enter a valid Last Name .";
            }
            if (!ck_email.test(email)) {
                errors[errors.length] = "You must enter a valid email;\tEx: abc12@something.ca";
            }
            if (!ck_phone.test(phone)) {
                errors[errors.length] = "Enter valid phone with area code;\tEx: 444-444-4444.";
            }
            if (!ck_str_num.test(streetnum)) {
                errors[errors.length] = "Enter valid street number;\tEx: 123. ";
            }
            if (!ck_str_name.test(streetname)) {
                errors[errors.length] = "Enter valid street name. ";
            }
            if (!ck_city.test(city)) {
                errors[errors.length] = "Enter valid city name. ";
            }
            if (!ck_postalcode.test(postalcode)) {
                errors[errors.length] = "Enter valid postalcode;\tEx: X1X 1X1 ";
            }
            if (!ck_username.test(username)) {
                errors[errors.length] = "You must enter valid UserName; no special chars .";
            }
            if (!ck_password.test(password1)) {
                errors[errors.length] = "You must enter a valid Password; At least 6 characters. At least one: uppercase, lowercase, symbol and digit ";
            }
            if (password1 != password2) {
                errors[errors.length] = "Passwords fields must match. ";
            }
    
            if (errors.length > 0) {
                reportErrors(errors);
                return false;
            }
            else {
                //makes a cookie if all fields are good
                setCookie("username", username, "password1", password1);
                alert("Account was created for username: " + getCookie("username") )

                /*//prompts for navigation to login page
                if (x == true) {
                    window.location.href = "register.php";
                }
                else {
                    document.getElementById("form").reset();
                }*/

                return true;
            }
        }

        //alert for invalid data entry
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
                    <li class="active"><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="sitemap.html">Sitemap</a></li>
                    <li><a href='viewreview.php'>Reviews</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="purchaseconfirm.php">Your purchases</a></li>
                    <li><a href="checkout.php">Check out </a> </li>
                    <li><a href="userupdate.php">Profile Update</a></li>
                    <li><a href='logout.php'>Logout</a>
                    </li>
					<li><a href="admin.php">Admin</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!--  Contains form and fields for text entry -->
    <div class="container">

                <?php
            
            require_once("Includes/session.php");
            if (confirm_is_admin_and_alert_otherwise()): ?>


        <p><a href="admin.php">Admin Home</a> >> <a href="admin_users.php">User Administration</a> >> <a href="">Create User</a></p>
            <h1>Create User</h1>
        <div class="col-sm-4">
            <form action="admin_users_create.php" method="post" name="form" id="form" >
                <fieldset>

                    <!-- Contact info fields -->
                    <legend>Contact Info</legend>
                    <div class="form-group">
                        <label for="firstname" class=" control-label" >First name</label>
                        <div class=""><input type="text" id="firstname" name="firstname" class="form-control"  ></div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class=" control-label">
                            Last name
                        </label><div class="">
                            <input type="text" name="lastname" id="lastname" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class=" control-label">
                            Email
                        </label><div class="">
                            <input type="text" name="email" id="email" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class=" control-label">
                            Phone #
                        </label><div class="">
                            <input type="text" name="phone" id="phone" class="form-control"  >
                        </div>
                    </div>

                </fieldset>

                <!-- Shipping info fields -->
                <fieldset>
                    <legend>Shipping Address</legend>

                    <div class="form-group">
                        <label for="streetnum" class=" control-label">
                            Street #
                        </label><div class="">
                            <input type="text" name="streetnum" id="streetnum" class="form-control"  >
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="streetname" class=" control-label">
                            Street Name
                        </label><div class="">
                            <input type="text" name="streetname" id="streetname" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unitnum" class=" control-label">
                            Unit #
                        </label><div class="">
                            <input type="text" name="unitnum" id="unitnum" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="city" class=" control-label">
                            City
                        </label><div class="">
                            <input type="text" name="city" id="city" list="cities" class="form-control"  >
                        </div>
                    </div>

                    <datalist id="cities">
                        <option>Hamilton</option>
                        <option>Mississauga</option>
                        <option>Toronto</option>
                        <option>Burlington</option>
                        <option>Oakville</option>
                    </datalist>

                    <div class="form-group">
                        <label for="province" class=" control-label">
                            Province
                        </label>
                        <div class="">
                            <select name="province" id="province" class="form-control"  >
                                <option value="AB">Alberta</option>
                                <option value="BC">British Columbia</option>
                                <option value="MB">Manitoba</option>
                                <option value="NB">New Brunswick</option>
                                <option value="NL">Newfoundland and Labrador</option>
                                <option value="NS">Nova Scotia</option>
                                <option value="ON">Ontario</option>
                                <option value="PE">Prince Edward Island</option>
                                <option value="QC">Quebec</option>
                                <option value="SK">Saskatchewan</option>
                                <option value="NT">Northwest Territories</option>
                                <option value="NU">Nunavut</option>
                                <option value="YT">Yukon</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="postalcode" class=" control-label">
                            Postal Code
                        </label><div class="">
                            <input type="text" name="postalcode" id="postalcode" class="form-control"  >
                        </div>
                    </div>

                </fieldset>

                <!-- Account information fields -->
                <fieldset>
                    <legend>Account</legend>

                    <div class="form-group">
                        <label for="username" class=" control-label">
                            Username
                        </label><div class="">
                            <input type="text" name="username" id="username" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password1" class=" control-label">
                            Password
                        </label><div class="">
                            <input type="password" name="password1" id="password1" class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password2" class=" control-label">
                            Re-enter Password
                        </label><div class="">
                            <input type="password" name="password2" id="password2" class="form-control" >
                        </div>
                    </div>

                </fieldset>

                <!-- Submit and clear buttons -->
                <div class="form-group ">
                    <input type="reset" value="Clear Form" class="btn btn-default">
                    <input type="submit" name="submit"  onclick="return validate(form)" formaction="admin_users_create.php" formmethod="post" value="Create User" class="btn btn-default pull-right">

                </div>
            </form>

           
        </div>


        <?php endif; ?>
        </div>
</body>
</html>