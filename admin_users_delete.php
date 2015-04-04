<?php
if (isset($_GET['username'])) {
    $query = "DELETE FROM users WHERE username = $_GET['username'];";
    $result = $databaseConnection->query($query);
    header("Location: admin_users.php");
    if ($result->error) {
        echo $_GET["action"] . "failed!";
    } else {
        echo $_GET["action"] . "successful!";
    }
}

?>