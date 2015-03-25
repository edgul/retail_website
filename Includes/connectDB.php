<?php
    require_once ("var_init.php");

    // Create database connection
    $databaseConnection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($databaseConnection->connect_error)
    {   
        die("Database selection failed: " . $databaseConnection->connect_error);
    }   

?>

