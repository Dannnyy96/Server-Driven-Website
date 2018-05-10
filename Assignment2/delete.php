<?php include_once("header.php");
	
	if(isset($_SESSION['LoggedIn']))
{
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit:
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    $username = $_GET["username"];
    // find profile where username matches username entered
    $query = "DELETE profiles, members FROM profiles INNER JOIN members WHERE profiles.username = members.username and profiles.username ='$username'";
    
    $result = mysqli_query($connection, $query);
	
	if ($result == true)
	{	
		echo"Account successfully deleted";
		echo "<a href='adminviewanyprofile.php'>Click here to view all the profiles</a>";
	}
	else{	
		echo "Failed to delete account<br>";
		echo "<a href='adminviewanyprofile.php'>Click here to view all the profiles</a>";
	}
}

?>