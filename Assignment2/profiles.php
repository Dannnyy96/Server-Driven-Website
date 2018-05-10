<?php
include_once("header.php");


if (!isset($_SESSION['LoggedIn'])) {
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
    echo "<a href='signin.php'>Sign in</a>";
} else {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit:
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    
    $username = $_GET['username'];
    
    // find profile where username matches username entered
    $query = "SELECT DISTINCT * FROM profiles INNER JOIN posts ON profiles.username = posts.username WHERE profiles.username ='$username'";
    
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "Welcome to, $username's page!<br>";
		$printedProfile = false;
        
        while ($row = mysqli_fetch_assoc($result)) {
			if (!$printedProfile) {
				echo "Username: {$row['username']}<br>";
				echo "First name: {$row['firstname']}<br>";
				echo "Last name: {$row['lastname']}<br>";
				echo "Age: {$row['age']}<br>";
				echo "Email: {$row['email']}<br>";
				echo "Date of birth: {$row['dateofbirth']}<br>";
				$printedProfile = true;
			}
			
            echo "Message: {$row['message']} Posted on: {$row['dateposted']}<br>";
        }
    }
    // we're finished with the database, close the connection:
    mysqli_close($connection);
    
}


?>