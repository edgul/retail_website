<!-- register.html 
     Displays fields for user input to create an account of the website.
     Uses cookies to pass data to other pages.
-->

<?php 
    require_once ("Includes/var_init.php"); 
    require_once  ("Includes/connectDB.php");


    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $street_num = $_POST['streetnum'];
        $street_name = $_POST['streetname'];
        $unit_num = $_POST['unitnum'];
        $province= $_POST['province'];
        $postalcode= $_POST['postalcode'];
	
     //   $query = "INSERT INTO users (username,fname,lname,email,street_num, street_name,unit_num,province, postalcode, password) VALUES (?,?,?,?,?,?,?,?,?,?)";
        //$query = "INSERT INTO users (username,fname,lname,email,street_num, street_name,unit_num,province, postalcode, password) VALUES (eddyboi,ed,gul,ed.gul@hotmail.com,11,townley,5,ont,lom1p0,User123$)";
		
		$query = "INSERT INTO temp VALUES ('user', 'rmail')";

        //$statement = $databaseConnection->prepare($query);
		$statement = $databaseConnection->query($query);
        //$statement->bind_param('ssssisisss', $username,$fname,$lname,$email,$street_num,$street_name,$unit_num,$province,$postalcode, $password);
        //$statement->execute();
        //$statement->store_result();

        //$creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
        //if ($creationWasSuccessful)
        //{   
       //     $userId = $statement->insert_id;
//
 //           $addToUserRoleQuery = "INSERT INTO users_in_roles (user_id, role_id) VALUES (?, ?)";
  //          $addUserToUserRoleStatement = $databaseConnection->prepare($addToUserRoleQuery);
//
 //           // TODO: Extract magic number for the 'user' role ID.
  //          $userRoleId = 2;
   //         $addUserToUserRoleStatement->bind_param('dd', $userId, $userRoleId);
    //        $addUserToUserRoleStatement->execute();
     //       $addUserToUserRoleStatement->close();
//
 //           $_SESSION['userid'] = $userId;
            //$_SESSION['username'] = $username;
//			header ("Location: index.php");
        echo "success";
		//}
        //else
        //{
            //echo "Failed registration";
        //}
    }
?>

<!DOCTYPE html>
<html>
<head>

<body>

	<form action="temp2.php" method="post">
	Name: <input type="text" name="name"><br>
	E-mail: <input type="text" name="email"><br>
	<input type="submit" name="submit" formaction="temp2.php" formmethod="post">
	</form>

</body>
</html>

