<?php include_once('header.php'); ?>

	<h2>Risk jobs search</h2>
	<form action="search.php">
		<input type="hidden" name="sort" value="1">
		<label for="usersearch">Find your risk jobs</label><br>
		<input type="text" name="usersearch" id="usersearch"><br>
		<input type="submit" name="submit" value="search">
	</form>
	
<?php include_once('footer.php'); ?>
