<?php

require_once "header.php";

$firstname = "";
$lastname = "";
$age = "";
$email = "";
$dateofbirth = "";

$firstname_val = "";
$lastname_val = "";
$age_val = "";
$email_val = "";
$dateofbirth_val = "";

$show_profile_form = false;


if (!isset($_SESSION['LoggedIn']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
elseif (isset($_POST['firstname']))
{
	// user just tried to update their profile
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	

	$firstname = sanitise($_POST['firstname'], $connection);
	$lastname = sanitise($_POST['lastname'], $connection);
	$age = sanitise($_POST['age'], $connection);
	$email = sanitise($_POST['email'], $connection);
	$dateofbirth = sanitise($_POST['dateofbirth'], $connection);
	
	$firstname_val = validateString($firstname, 1, 40);
	$lastname_val = validateString($lastname, 1, 50);
	$age_val = validateInt($age, 1, 255);

	$email_val = validateString($email, 1, 50);
	$email_val = validateEmail($email);
	$date_val = validateDate($dateofbirth);
	
	$errors = "";
	
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		// check to see if this user already has entered profile information:
		$query = "SELECT * FROM profiles WHERE username='$username'";
		
		$result = mysqli_query($connection, $query);
				
		$n = mysqli_num_rows($result);
			
		// if there was a match then UPDATE their profile data, otherwise INSERT it:
		if ($n > 0)
		{
			// we need an UPDATE:
			$query = "UPDATE profiles SET firstname='$firstname',lastname='$lastname',age='$age',email='$email',dateofbirth='$dateofbirth' WHERE username='$username'";
			$result = mysqli_query($connection, $query);		
		}
		else
		{
			// we need an INSERT:
			$query = "INSERT INTO profiles (username,firstname,lastname,age,email,dateofbirth) VALUES ('$username','$firstname','$lastname','$age','$email','$dateofbirth')";
			$result = mysqli_query($connection, $query);	
		}

		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful update message:
			echo "Profile successfully updated<br>";
		} 
		else
		{
			// show the set profile form:
			$show_profile_form = true;
			// show an unsuccessful update message:
			echo "Update failed<br>";
		}
	}
	else
	{
		// validation failed
		$show_profile_form = true;
	
		echo "Update failed, please check the errors above and try again<br>";
	}
	
	mysqli_close($connection);

}
else
{
	
	// read the username from the session:
	$username = $_SESSION["username"];
	
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM profiles WHERE username='$username'";
	
	$result = mysqli_query($connection, $query);
	
	$n = mysqli_num_rows($result);
		
	if ($n > 0)
	{
		
		$row = mysqli_fetch_assoc($result);
		
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$age = $row['age'];
		$email = $row['email'];
		$dateofbirth = $row['dateofbirth'];
	}

	$show_profile_form = true;
	
	mysqli_close($connection);
	
}

if ($show_profile_form)
{
echo <<<_END
<h1> Update your profile information here! </h1>
<div id=updateprofile>
<form action="updateprofile.php" method="post">
  First name: <input type="text" name="firstname" minlength="1" maxlength="40" value="$firstname" required> $firstname_val
  <br>
  Last name: <input type="text" name="lastname" minlength="1" maxlength="50" value="$lastname" required> $lastname_val
  <br>
  Age: <input type="number" min="1" max="255" name="age" value="$age" required> $age_val
  <br>
  Email address: <input type="email" name="email"  maxlength="50" value="$email" required> $email_val
  <br>
  Date of birth: <input type="date" name="dateofbirth" value="$dateofbirth" required> $dateofbirth_val
  <br>
  <input type="submit" value="Submit">
</form>	
</div>
_END;
}

?>