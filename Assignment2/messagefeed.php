<?php
include_once("header.php");

$message_val = "";


if (!isset($_SESSION['LoggedIn'])) {
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
    echo "<a href='signin.php'>Sign In</a>";
} elseif (isset($_POST['message'])) {
    
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    //message input form	
    $message = sanitise($_POST['message'], $connection);
    
    $message_val = validateString($message, 1, 140);
    
    $errors = $message_val;
    
    // check that all the validation tests passed before going to the database:
    if ($errors == "") {
        // read their username from the session:
        $username = $_SESSION["username"];
        
        $query = "INSERT INTO posts(username, message, dateposted) VALUES ('$username','$message',NOW())";
        
        $result = mysqli_query($connection, $query);
        
        if ($result) {
            echo "Message successfully posted!<br>";
        } else {
            echo "Message failed to post<br>";
        }
    }
}

if (isset($_SESSION['LoggedIn'])) {
    echo <<<_END
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	


<script>
$(document).ready(function()
{
	function listen() {
		$("#posts .likebutton").click(function(event) {
			// user just clicked a "like" link, prevent default behaviour:
			event.preventDefault(); 
					
			var likeButton = $(this).siblings('.like');
			
			$.post('api/like.php', { postid: $(this).parent().parent().data('postid') }).done(function(data) {
				// update the relevant user's likes number by one:
				var likes = parseInt(likeButton.text(), 10) + 1;
				likeButton.text(likes);
			})
		});
	}
	
	function update() {
		var table = $('#posts');
		//gets lists of posts from recent.php
		$.get('api/recent.php').done(function(data) {
			//clears table
			table.empty();
			
			
			//goes through each post
			data.forEach(function(post) {
				table.append("<tr data-postid='" + post.postid + "'><td><a href=\"profile.php?username=" + post.username + "\">" + post.username + "</a></td><td>" + post.message + "</td><td>" + post.dateposted + "</td><td><a href='#' class='likebutton'>&#x1F44D;</a> <span class='like'>" + post.likes + "</span></td></tr>");
			});
			
			listen();
		});
	}
	
	setInterval(update, 5000);
	update();
});
</script>

<h1> Welcome to the message feed! </h1>
<table border=1 id=posts-table style="width:493px">
<tr><th>User</th><th>Message</th><th>Date posted</th><th>Likes</th></tr>
<tbody id='posts'>
	<tr id='loading'><td colspan="4">Loading...</td></tr>
</tbody>
</table>

<form action="messagefeed.php" method="post">
  <textarea name="message" rows="4" cols="40" required></textarea> $message_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
}



?>