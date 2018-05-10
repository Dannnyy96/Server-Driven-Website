<?php include_once("header.php"); 

		
if (!isset($_SESSION['LoggedIn']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
	echo "<a href='signin.php'>Sign in</a>";
}
else
{
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
		// find profile where username matches username entered
	$query = "SELECT * FROM profiles WHERE username = '" . $_SESSION['username'] . "'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			
			echo "Welcome to your profile page!<br>";  
			echo "Username: {$row['username']}<br>";
			echo "First name: {$row['firstname']}<br>";
			echo "Last name: {$row['lastname']}<br>";
			echo "Age: {$row['age']}<br>";
			echo "Email: {$row['email']}<br>";
			echo "Date of birth: {$row['dateofbirth']}<br>";
			
			echo "<a href='updateprofile.php'>if you want to update your profile click here;</a><br>";
			echo "<a href='logout.php'>if you want to log out click here;</a><br>";
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}
	
	?>