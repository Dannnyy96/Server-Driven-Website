<?php

require_once "db.php";
require_once "helper.php";
session_start();



if (isset($_SESSION['LoggedIn']))
{
if($_SESSION['username'] == 'admin'){
echo <<<_END
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style2.css">
	</head>
<div id=adminheader>
<body>
<a href='adminhome.php'>Admin home</a> ||
<a href='statistics.php'>Statistics</a> ||
<a href='messagefeed.php'>Message feed</a> ||
<a href='adminviewanyprofile.php'>View all profiles</a> ||
<a href='logout.php'>Log out ({$_SESSION['username']})</a>
<br><br>
</div>
_END;
}
else{
echo <<<_END
<!DOCTYPE html>
<html>
	<head>	<link rel="stylesheet" href="style2.css"></head>
<div id=header>
<body>
<a href='index.php'>Home</a> ||
<a href='messagefeed.php'>Message Feed</a> ||
<a href='profile.php'>Your profile</a> ||
<a href='updateprofile.php'>Update profile</a> ||
<a href='viewanyprofile.php'>View all profiles</a> ||
<a href='logout.php'>Log out ({$_SESSION['username']})</a>
<br><br>
</div>
_END;
	}
}
else
{
	
echo <<<_END
<html>
<head>	<link rel="stylesheet" href="style2.css"></head>
<div id=header>
<body>
<a href='signup.php'>Sign up</a> ||
<a href='signin.php'>Sign in</a>
</div>
<br><br>
_END;
}
?>