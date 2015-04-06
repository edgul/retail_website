<?php
    
    define('IDLE_TIMEOUT', 180);

    session_start();
    require_once  ("Includes/connectDB.php");
    require_once ("common.php");

    if (isset($_SESSION['timestamp']) && time()-$_SESSION['timestamp'] > IDLE_TIMEOUT) {
        logout();
    }

    $_SESSION['timestamp']=time();

    function username_condition() {
        if (isset($_SESSION['username'])) { // logged in session
            return " username='" . $_SESSION['username'] . "' OR username='" . session_id() . "'";
        } else {
            return " username='" . session_id() . "'";     // anonymous session
        }	
    }

    function logout() {
        global $databaseConnection;

   	    //clears cart values attached to username and returns to inventory 
        $result = $databaseConnection->query( "SELECT * FROM cart WHERE " . username_condition());
	    while ( $temp = $result->fetch_assoc() ){
    	    //remove from cart
    	    $qtyincart = $temp['qty'];
		    $pidincart = $temp['p_id'];
            $databaseConnection->query( "DELETE FROM cart WHERE p_id='" . $pidincart . "' AND " . username_condition());
    
            //return to inv
            $result2 = $databaseConnection->query( "SELECT qty FROM inventory WHERE p_id='" . $pidincart . "'");
            $temp2 = $result2->fetch_assoc();
            $qtyininv = $temp2['qty'];
            $updateqty = $qtyininv + $qtyincart;
            $databaseConnection->query( "UPDATE inventory SET qty='" . $updateqty . "' WHERE p_id='" . $pidincart . "'"); 
	    }

        session_destroy();  // destroy current session
        session_start();    // start new anonymous session so user can still add items to cart and have them be saved
    }
 

    function logged_in()
    {
        return isset($_SESSION['username']);
    }

    function confirm_is_admin() {
        if (!logged_in())
        {   
            header ("Location: login.php");
        }   

        if (!is_admin())
        {   
            header ("Location: index.php");
        }   
    }

    function confirm_is_admin_and_alert_otherwise() {
        if (confirm_is_logged_in_and_alert_otherwise()) {
            if (!is_admin()) {
                echo '<div class="alert alert-danger" role="alert">You do not have sufficient priveleges to access this page!</div>';
            
            } else {
                return TRUE;
            }
        }
    }

    
    function confirm_is_logged_in_and_alert_otherwise() {
        if (!logged_in()) {
            echo '<div class="alert alert-danger">You must <a href="login.php">login</a> to view this page</div>';
        } else {
            return TRUE;
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

