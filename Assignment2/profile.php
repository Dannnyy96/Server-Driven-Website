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
	
	$username = isset($_GET['username']) ? $_GET['username'] : $_SESSION['username'];
	
		// find profile where username matches username entered
	$query = "SELECT * FROM profiles WHERE username = '$username'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
echo <<<_END
		<h1> Welcome to the profile page! :)</h1>
	   <table id=profile border=1>
		<tr><th>Username</th><td>${row['username']}</td></tr>
		<tr><th>First Name</th><td>${row['firstname']}</td></tr>
		<tr><th>Last Name</th><td>${row['lastname']}</td></tr>
		<tr><th>Age</th><td>${row['age']}</td></tr>	
		<tr><th>Email</th><td>${row['email']}</td></tr>
		<tr><th>Date of birth</th><td>${row['dateofbirth']}</td></tr>		
		</table>
_END;
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}
	
	?>