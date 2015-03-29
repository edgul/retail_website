<!-- register.html 
     Displays fields for user input to create an account of the website.
     Uses cookies to pass data to other pages.
-->

<?php 
	session_start();
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");

	print_r($_SESSION);
	print_r($_POST);

    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
	
		//$query = "INSERT INTO temp VALUES ('user', 'rmail')";

        //$statement = $databaseConnection->prepare($query);
		//$statement = $databaseConnection->query($query);
        echo "success";
    }
?>

<!DOCTYPE html>
<html>
<head>

<body>

<?php

	$_SESSION['hello'] = "hi";
	print_r($_SESSION);
	echo "
	<form action=\"temp2.php\" method=\"post\">
	Name: <input type=\"text\" name=\"name\"><br>
	";
	echo "
	E-mail: <input type=\"text\" name=\"email\"><br>
	<input type=\"submit\" name=\"submit\" formaction=\"temp2.php\" formmethod=\"post\">

	</form>

	";
?>
</body>
</html>

