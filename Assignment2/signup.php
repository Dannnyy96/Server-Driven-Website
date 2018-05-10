<?php

require_once "header.php";


$username = "";
$password = "";

$username_val = "";
$password_val = "";


$show_signup_form = false;


if (isset($_SESSION['LoggedIn']))
{
	// user is already logged in, just display a message:
	echo "You are already logged in, please log out first<br>";
	
}
elseif (isset($_POST['username']))
{
	// user just tried to sign up:
	
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, 
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}	
	
	// SANITISATION (see helper.php for the function definition)
	
	// take copies of the credentials the user submitted, and sanitise (clean) them:
	$username = sanitise($_POST['username'], $connection);
	$password = sanitise($_POST['password'], $connection);

	// VALIDATION (see helper.php for the function definitions)
	
	// now validate the data (both strings must be between 1 and 16 characters long):
	// (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table)
	$username_val = validateString($username, 1, 16);
	$password_val = validateString($password, 1, 16);
	
	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $username_val . $password_val;
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{
		
		// try to insert the new details:
		$query = "INSERT INTO members (username, password) VALUES ('$username', '$password');";
		$result = mysqli_query($connection, $query);
		
		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful signup message:
			echo "<p>Signup was successful, please sign in</p><br>";
		} 
		else 
		{
			// show the form:
			$show_signup_form = true;
			// show an unsuccessful signup message:
			echo"<p>Sign up failed, please try again</p><br>";
		}
			
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_signup_form = true;
		// show an unsuccessful signin message:
		echo "<p>Sign up failed, please check the errors shown above and try again</p><br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}
else
{
	// just a normal visit to the page, show the signup form:
	$show_signup_form = true;
	
}

if ($show_signup_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
	if (isset($_GET['noval']))
	{
// a version WITHOUT client-side validation so that we can test server-side validation:
echo <<<_END
<form action="signup.php?noval=y" method="post">
  Please choose a username and password:<br>
  Username: <input type="text" name="username" value="$username"> $username_val
  <br>
  Password: <input type="text" name="password" value="$password"> $password_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
	}
	else
	{
// a version WITH client-side validation:
echo <<<_END
<div id=signup>
<form action="signup.php" method="post">
  Please choose a username and password:<br>
  Username: <input type="text" name="username" maxlength="16" value="$username" required> $username_val
  <br>
  Password: <input type="password" name="password" maxlength="16" value="$password" required> $password_val
  <br>
  <input type="submit" value="Submit">
</form>	
</div>
_END;
	}
}



?>