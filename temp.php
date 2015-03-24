<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<p> Test </p>

<?php
$servername = "mysqlsrv2";
$dbname = "guloiej_db";
$username = "guloiej";
$password = "0749435";

// Create connection & connect to db
$conn = new mysqli($servername, $username, $password, $dbname);
//mysql -u guloiej -h mysqlsrv2 -p -A guloiej_db

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); 
}

// Query user table
$user = "SELECT * FROM users";
$result = $conn->query($user);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "uid: " . $row["uid"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<?php
?>

</body>
</html>
