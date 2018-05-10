<?php

require_once "header.php";

if (isset($_SESSION['LoggedIn']))
{
	if( isset($_SESSION['username']) == 'admin')
	{
		echo "Hello, welcome to the admin page";
	}
	else
	{
		echo "You need to be an admin to access this page!";
		echo "please <a href='profile.php'>click here to go back to your profile!</a><br>";
	}
}else{
	
	echo "You need to be logged in to access this page!";
	echo "please <a href='signin.php'>click here to sign in!</a><br>";
	echo "or please <a href='signup.php'>click here to sign up!</a><br>";
}
 

?>