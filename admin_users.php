<?php

switch ($_GET["action"]) {
    case: "create":
        //header("Location: login.php");
        break;
    case: "update":
        break;
    case: "delete":
        $query = "DELETE FROM users WHERE username = $_GET['username'];"
        break;
}

$result = $databaseConnection->query($query);
if ($result->error) {
    echo $_GET["action"] . "failed!";
} else {
    echo $_GET["action"] . "successful!";
}


?>