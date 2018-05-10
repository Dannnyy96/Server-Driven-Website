<?php
require('header.php');

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to view this page.<br>";
    echo "<a href='signin.php'>Sign In</a>";
	die;
} else if ($_SESSION['username'] != 'admin') {
	echo "You must be an admin to view this page.<br>";
	die;
}
?>
<html>
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
  
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(makeData);

	  // Object for storing number of posts per user
	  var postCount = {};
	  var likeCount = {};
		

	  
	  function makeData() {
		  $.get('api/recent.php').done(function(data) {
			  data.forEach(function(post) {
				 if (post.username in postCount) {
					 postCount[post.username] += 1;
				 }  else {
					 postCount[post.username] = 1;
				 }
				 
				 if (post.username in likeCount) {
					 likeCount[post.username] += parseInt(post.likes, 10);
				 }  else {
					 likeCount[post.username] = parseInt(post.likes, 10);
				 }
			  });
			  
			  drawChart();
		  });
	  }
	  
	  // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var postdata = new google.visualization.DataTable();
        postdata.addColumn('string', 'Username');
        postdata.addColumn('number', 'Posts');
		
		// Create the data table.
        var likedata = new google.visualization.DataTable();
        likedata.addColumn('string', 'Username');
        likedata.addColumn('number', 'Likes');
		
		var postrows = [];
		var likerows = [];
		
		for (var username in postCount) {
			postrows.push([username, postCount[username]]);
		}
		
		for (var username in likeCount) {
			likerows.push([username, likeCount[username]]);
		}
		
        postdata.addRows(postrows);
		likedata.addRows(likerows);

        // Set chart options
        var postoptions = {'title':'Number of Posts per User',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var postchart = new google.visualization.PieChart(document.getElementById('postchart_div'));
        postchart.draw(postdata, postoptions);
		
		// Set chart options
        var likeoptions = {'title':'Number of Likes per User',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var likechart = new google.visualization.PieChart(document.getElementById('likechart_div'));
        likechart.draw(likedata, likeoptions);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="postchart_div"></div>
	
	<!--Div that will hold the pie chart-->
    <div id="likechart_div"></div>
  </body>
</html>