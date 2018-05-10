<?php

require_once "../db.php";
require_once "../helper.php";

session_start();
// Things to notice:
// we don't require headers, etc, as this is not a page that is accessed directly (no menu options needed)
// this is a stateless API and the caller doesn't need to be logged in
// we check that the correct parameters have been supplied via a HTTP POST request
// missing parameters, a failure to connect to the database, or no impact from the query cause error response codes to be returned
// otherwise we return a success response code along with the likes that was updated



// variable to store the data we'll send back
$response['postid'] = "";

if (!isset($_POST['postid']))
{
	// set the kind of data we're sending back and an error response code:
	header("Content-Type: application/json", NULL, 400);
	// and send:
	echo json_encode($response);
	// and exit this script:
	exit;
}
else
{
	$postid = $_POST['postid'];
}

// copy the username into our response:
$response['postid'] = $postid;

// connect directly to our database (notice 4th argument):
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// connection failed, return an internal server error:
if (!$connection)
{
	// set the kind of data we're sending back and an error response code:
	header("Content-Type: application/json", NULL, 500);
	// and send:
	echo json_encode($response);
	// and exit this script:
	exit;
}

// update the number of likes for this user/favourite:
$query = "UPDATE posts SET likes=likes+1 WHERE postid='$postid'";

// no data, just true/false:
$result = mysqli_query($connection, $query);

// no data returned, we just test for true(success)/false(failure):
if ($result) 
{
	// did we actually change a row?
	if (mysqli_affected_rows($connection) == 1)
	{
		// set the kind of data we're sending back and a success response code:
		header("Content-Type: application/json", NULL, 201);
	}
	else
	{
		// set the kind of data we're sending back and an error response code:
		header("Content-Type: application/json", NULL, 400);
	}
}
else
{
	// something went wrong (e.g., user may have just changed their number)
	// set the kind of data we're sending back and an error response code:
	header("Content-Type: application/json", NULL, 400);
}

// we're finished with the database, close the connection:
mysqli_close($connection);

// and send:
echo json_encode($response);

?>