/* 
ASCII ART
A program allowing users to upload ascii art for exhibiting
on the web.

AUTHOR: Robert Barry
# DATE CREATED: July 23, 2012
# DATE CHANGED: July 23, 2012
# WEB ADDRESS: http://www.robertbarry.net/ascii/ascii.php

*/

<?php
	// Get variables
	$title = $_POST['title'];
	$art = $_POST['art'];
	
	$error = "";
	
	// Connect to database
	$db = new mysqli('localhost', 'root', 'root', 'ascii');
	
	// Database error check
	if (mysqli_connect_errno()) {
		$error = "ERROR: Could not connect to database. Please try again later.";
	}
	
	// If the art was submitted, check for valid title and art
	if ($_POST['submit']) {
		if ($title && $art) {
			// SQL to add art and title to the database
			$query = "INSERT INTO art (title, art) VALUES('".$title."', '".$art."')";
			// Query the database
			$result = $db->query($query);
			// Test that the query was successful
			if (!$result) {
				$error  = "ERROR: The item was not added.";
			}
			// reset variables to keep from accidental reload
			$title = "";
			$art = "";
		} else {
			$error = "You must enter a title and some art.";
		}
	}

?>
	

<!doctype html>

<html>
    <head>
	<title>/ascii/</title>

	<link href="ascii.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
	<h1>/ascii/</h2>

	<form method="post">
	    <label>
	        <div>title</div>
		<input type="text" name="title" value="<?php echo $title; ?>" />
	    </label>
	    <label>
		<div>art</div>
		<textarea name="art"><?php echo $art; ?></textarea>
	    </label>

	    <div class="error"><?php echo $error; ?></div>

	    <input type="submit" name="submit" value="Submit" />
	</form>

	<hr />

<?php
	// Output the artwork on the front page ordered by creation date
	// SQL Query to retieve the database
	$query = "SELECT * FROM art ORDER BY created DESC";
	
	// Query the database
	$result = $db->query($query);
	
	// Get the number of rows returned
	$num_results = $result->num_rows;
	
	// Output the data to the web page
	for ($i = 0; $i < $num_results - 1; $i++) {
		$row = $result->fetch_object();

?>
	
	<div class="art">
	    <div class="art-title"><?php echo $row->title; ?></div>
	    <pre class="art-body"><?php echo $row->art; ?></pre>
	</div>

<?php
	}
	
	// close the database
	$db->close();
?>
	
    </body>
</html>
