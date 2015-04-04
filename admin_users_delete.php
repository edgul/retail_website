<?php
require_once  ("Includes/session.php");    

if (isset($_GET['username'])) {
    $query = "DELETE FROM users WHERE username = {$_GET['username']};";
    $result = $databaseConnection->query($query);
    if ($result->error) {
        echo $_GET["action"] . "failed!";
    } else {
        echo $_GET["action"] . "successful!";
    }
}

?>