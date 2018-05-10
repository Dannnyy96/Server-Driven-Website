<?php

// default values for Xampp:
$dbhost  = 'localhost';
$dbuser  = 'root';
$dbpass  = '';

// name of a database to hold our tables (we'll create it if it doesn't exist)
$dbname  = 'LoginSystem';

// We'll use the procedural (rather than object oriented) mysqli calls

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}
  
// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Database created successfully, or already exists<br>";
} 
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
////////////// MEMBERS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS members";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: members<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE Members (username VARCHAR(16), password VARCHAR(16), PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: members<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
$usernames[] = 'admin'; $passwords[] = 'admin1';
$usernames[] = 'dannym'; $passwords[] = 'password';
$usernames[] = 'joebloggs'; $passwords[] = 'abc123';
$usernames[] = 'johnsmith'; $passwords[] = 'pass123';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	$sql = "INSERT INTO members (username, password) VALUES ('$usernames[$i]', '$passwords[$i]')";
	
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//////////////////////////////////////////////
////////////// PROFILES TABLE //////////////
//////////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS profiles";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: profiles<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE profiles (username VARCHAR(16) PRIMARY KEY, firstname VARCHAR(40), lastname VARCHAR(50), age BIGINT(255), email VARCHAR(50), dateofbirth Date)";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: profiles<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
$username = array(); 
$username[] = 'dannym'; $id[] = '1'; $firstname[] = 'daniel'; $lastname[] = 'mcnamara'; $age[] = 20; $email[] = 'daniel@live.com'; $dateofbirth[] = '1996/04/17';
$username[] = 'joebloggs'; $id[] = '2'; $firstname[] = 'joe'; $lastname[] = 'bloggs'; $age[] = 35; $email[] = 'joe@live.com'; $dateofbirth[] = '1981/08/08';
$username[] = 'johnsmith'; $id[] = '3'; $firstname[] = 'john'; $lastname[] = 'smith'; $age[] = 35; $email[] = 'john@live.com';$dateofbirth[] = '1991/01/01';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($id); $i++)
{
	$sql = "INSERT INTO profiles (username, firstname, lastname, age, email, dateofbirth) VALUES ('$username[$i]', '$firstname[$i]', '$lastname[$i]', '$age[$i]', '$email[$i]', '$dateofbirth[$i]')";
	
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

///////////////////////////////////////////
////////////// POSTS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS posts";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: posts<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE posts (username VARCHAR(16), message VARCHAR(140), dateposted DATETIME, likes INT DEFAULT 0, postid SERIAL PRIMARY KEY)";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: posts<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
$usernames = [];
$usernames[] = 'dannym'; $message[] = 'Hello there!'; $dateposted[] = '2016-12-15 16:23:12'; $postid[] = '1';
$usernames[] = 'joebloggs'; $message[] = 'This is my first message!'; $dateposted[] = '2016-12-18 20:01:37'; $postid[] = '2';
$usernames[] = 'johnsmith'; $message[] = 'Hellooooo'; $dateposted[] = '2016-12-20 18:48:19'; $postid[] = "3";


// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	$sql = "INSERT INTO posts (username, message, dateposted) VALUES ('$usernames[$i]', '$message[$i]', '$dateposted[$i]')";
	
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}
// we're finished, close the connection:
mysqli_close($connection);
?>