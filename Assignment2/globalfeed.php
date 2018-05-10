<?php

require_once "header.php";

$username = "";
$lastname = "";

$show_globalfeed_form = false;

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
	$dateupdated = sanitise($_POST['dateupdated'], $connection);	

	$message_val = validateString($message, 1, 140);
	$dateupdated_val = validateDate($dateupdated);
	
	$errors = "";
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		// now write the new data to our database table...
		
		// check to see if this user already had a favourite:
		$query = "INSERT INTO posts WHERE username='$username'";
		
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);
		
		// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
		$n = mysqli_num_rows($result);
			
		// if there was a match then add message to posts table:
		if ($n > 0)
		{
			
			$query = "INSERT INTO posts WHERE username='$username'"
			$result = mysqli_query($connection, $query);		
		}

		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful update message:
			$message = "Message successfully posted!<br>";
		} 
		else
		{
			// show the set profile form:
			$show_globalfeed_form = true;
			// show an unsuccessful update message:
			echo "Message failed to post<br>";
		}
	}
	else
	{
		// validation failed
		$show_globalfeed_form = true;
	
		echo "Message failed to post please check the errors above and try again<br>";
	}
	
		$show_globalfeed_form = true;
	

		mysqli_close($connection);
		
if ($show_globalfeed_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
	if (isset($_GET['noval']))
	{
// a version WITHOUT client-side validation so that we can test server-side validation:
echo <<<_END
<form action="globalfeed.php?noval=y" method="post">
  Please enter a message and provide the date:<br>
  Message: <input type="text" name="message" maxlength="140" value="$message" required> $message_val
  <br>
  Date updated: <input type="DATETIME" name="date" value="$date" required> $date_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;

?>