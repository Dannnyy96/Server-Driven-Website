<?php

require_once "header.php";

$postid = "";
$message = "";
$dateposted = "";

$postid_val = "";
$message_val = "";
$dateposted_val = "";

$show_messagepost_form = false;

if (!isset($_SESSION['LoggedIn']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
elseif (isset($_POST['message']))
{
	// user just tried to enter a message
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	

	$message = sanitise($_POST['message'], $connection);
	$dateposted = sanitise($_POST['dateposted'], $connection);	

	$message_val = validateString($message, 1, 140);
	
	$errors = "";
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		$query = "INSERT INTO posts(postid, username, message, dateposted) VALUES ('$postid','$username','$message','$dateposted')";
		
		$result = mysqli_query($connection, $query);
		
		if ($result) 
		{
			echo "Message successfully posted!<br>";
		} 
		else
		{
			$show_messagepost_form = true;
			echo "Message failed to post<br>";
		}
	}
	else
		{
		$show_messagepost_form = true;
		echo "Message failed to post please check the errors above and try again<br>";
		}
}
else
{
	$username = $_SESSION["username"];
	
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// show the message post form:
	$show_messagepost_form = true;
	
	mysqli_close($connection);
	
}
	if ($show_messagepost_form)
{
echo <<<_END
<form action="messagepost.php" method="post">
  Please enter a message and provide the date you posted it on!:<br>
  Message: <textarea name="message" rows="4" cols="40"></textarea required> $message_val
  <br>
  Date posted on: <input type="date" name="dateposted" value="$dateposted" required> $dateposted_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
		
	
}
?>