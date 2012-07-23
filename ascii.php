<?php
	$title = $_POST['title'];
	$art = $_POST['art'];
	
	$error = "";
	
	$db = new mysqli('localhost', 'root', 'root', 'ascii');
	
	if (mysqli_connect_errno()) {
		$error = "ERROR: Could not connect to database. Please try again later.";
	}
	
	if ($_POST['submit']) {
		$query = "INSERT INTO art (title, art) VALUES('".$title."', '".$art."')";
		$result = $db->query($query);
		if (!$result) {
			$error  = "ERROR: The item was not added.";
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
		<input type="text" name="title" value="" />
	    </label>
	    <label>
		<div>art</div>
		<textarea name="art"></textarea>
	    </label>

	    <div class="error"><?php echo $error; ?></div>

	    <input type="submit" name="submit" value="Submit" />
	</form>

	<hr />

<?php
	$query = "SELECT * FROM art ORDER BY created DESC";
	
	$result = $db->query($query);
	
	$num_results = $result->num_rows;
	
	for ($i = 0; $i < $num_results; $i++) {
		$row = $result->fetch_object();

?>
	
	<div class="art">
	    <div class="art-title"><?php echo $row->title; ?></div>
	    <pre class="art-body"><?php echo $row->art; ?></pre>
	</div>

<?php
	}
	
	$db->close();
?>
	
    </body>
</html>
