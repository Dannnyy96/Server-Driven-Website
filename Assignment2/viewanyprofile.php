<?php
include_once("header.php");

if (!isset($_SESSION['LoggedIn'])) {
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
    echo "<a href='signin.php'>Sign in</a>";
} else {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit:
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    
    // find profile where username matches username entered
    $query = "SELECT username, firstname, lastname FROM profiles";
    
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) > 0) {
		echo "<h1> Here you can see all the profiles! :) </h1>";
		echo "<table id=viewanyprofile border=1>";
		echo "<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Link to page</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {

            echo "<tr><td>${row["username"]}</td><td>${row["firstname"]}</td><td>${row["lastname"]}</td><td><a href=\"profile.php?username=${row["username"]}\">&#x27A8;</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No profiles available";
    }
    
    
    // we're finished with the database, close the connection:
    mysqli_close($connection);
    
}
?>
