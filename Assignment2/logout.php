<?php include_once("header.php");
	
	if(isset($_SESSION['LoggedIn']))
	{
	session_unset(); #removes the varirables in the session

	session_destroy(); #destroys the session
	}
	
	
	if(!isset($_SESSION['LoggedIn']))
		{
			echo "<h1>Successfully logged out!</h1><br>";
		}

?>