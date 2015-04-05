<?php
    session_start();
    require_once  ("Includes/connectDB.php");
	$_SESSION['timestamp']=time(); 

    function logged_on()
    {
        return isset($_SESSION['username']);
    }

    function confirm_is_admin() {
        if (!logged_on())
        {   
            header ("Location: login.php");
        }   

        if (!is_admin())
        {   
            header ("Location: index.php");
        }   
    }

    function confirm_is_admin_and_alert_otherwise() {
        if (!logged_on()) {
            echo '<div class="alert alert-danger">You must <a href="login.php">login</a> to view this page';
        }
        elseif  (!is_admin()) {
            echo '<div class="alert alert-danger" role="alert">You do not have sufficient priveleges to access this page!</div>';
        }
    }

    function is_admin() {
        return isset($_SESSION['is_admin']);
    }

    function is_admin_sql()
    {   
        global $databaseConnection;
        $query = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND is_admin=1";
        return $databaseConnection->query($query)->num_rows == 1;
    }
?>

