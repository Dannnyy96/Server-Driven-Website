<?php
require_once "header.php";

$username = "";
$password = "";

$username_val = "";
$password_val = "";


$show_signin_form = false;

if (isset($_SESSION['LoggedIn']))
{
	echo "<p>You are already logged in, please log out first.</p><br>";
}
elseif (isset($_POST['username']))
{
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}	
	
	$username = sanitise($_POST['username'], $connection);
	$password = sanitise($_POST['password'], $connection);
	
	$username_val = validateString($username, 1, 16);
	$password_val = validateString($password, 1, 16);
	
	$errors = $username_val . $password_val;
	
	if ($errors == "")
	{
		
		// check for a row in our members table with a matching username and password:
		$query = "SELECT * FROM members WHERE username='$username' AND password='$password'";
		
		$result = mysqli_query($connection, $query);

		$n = mysqli_num_rows($result);
			
		if ($n > 0)
		{
			
			$_SESSION['LoggedIn'] = true;
			$_SESSION['username'] = $username;
			
			if($username == 'admin'){		
				echo "<p>Hi, $username, you have successfully logged in, please <a href='adminhome.php'>click here to go to the admin page!</a></p><br>";
			}
			else{
			
			echo "<p>Hi, $username, you have successfully logged in, please <a href='profile.php'>click here to go to your profile!</a></p><br>";
			}
		}
		else
		{
			$show_signin_form = true;
			echo "<p>Sign in failed, please try again</p><br>";
		}
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_signin_form = true;
		// show an unsuccessful signin message:
		echo "<p>Sign in failed, please check the errors shown above and try again</p><br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);
}
else
{
	// show signin form:
	$show_signin_form = true;
}

if ($show_signin_form)
{
// show the form that allows users to log in
// Note we use an HTTP POST request to avoid their password appearing in the URL:
	if (isset($_GET['noval']))
	{
// a version WITHOUT client-side validation so that we can test server-side validation:
echo <<<_END
<form action="signin.php?noval=y" method="post">
  Sign in here to access your profile!<br>
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
<div id=signin>
<form action="signin.php" method="post">
  Sign in here to access your profile!<br>
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