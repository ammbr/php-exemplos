<!DOCTYPE html>
<html pt-BR>
<head>
	<meta charset="utf-8">
	<title>Aliens Abducte Me - Report an Abduction<</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>

	<h1>Aliens Abducte Me - Report an Abduction</h1>

	<?php 
		$first_name = $_POST['firstname'];
		$last_name = $_POST['lastname'];
		$name = $first_name.''.$last_name;
		$how_many = $_POST['howmany'];
		$what_they_did = $_POST['whattheydid'];
		$other = $_POST['other'];
		$when_it_happened = $_POST['whenithappened'];
		$how_long = $_POST['howlong'];
		$alien_description = $_POST['aliendescription'];
		$fang_spotted = $_POST['fangspotted'];
		$email = $_POST['email'];

		//$to = 'email@email.com';
		//$subject = 'Aliens Abducte Me - Abduction Report';
        $msg = $name.' was abducted '.$when_it_happened.' and was gone for '.$how_long.'\n'.
        'Alien description: '.$alien_description.'\n'.
        'What they did: '.$what_they_did.'\n'.
        'Fang spotted: '.$fang_spotted.'\n'.
        'Other comments: '.$other;
        //mail($to, $subject, $msg, 'From: '.$email);

		echo 'Thanks for submitting the form.<br>';
		echo 'You were abducted '.$when_it_happened;
		echo ' and were gone for '.$how_long.'<br>';
		echo 'Number of aliens: '.$how_many.'<br>';
		echo 'Describle them: '.$alien_description.'<br>';
		echo 'The aliens did this: '.$what_they_did.'<br>';
		echo 'Was Fang there? '.$fang_spotted.'<br>';
		echo 'Other comments: '.$other.'<br>';
		echo 'Your email address is '.$email.'<br>';

		$dbc = mysqli_connect('localhost', 'root', '', 'aliendatabase')
			or die('Error connecting to MySQL server.');

	    $query = "INSERT INTO aliens_abduction (first_name, last_name, when_it_happened, how_long, ".
	    	"how_many, alien_description, what_they_did, fang_spotted, other, email) VALUES ('$first_name',".
	    	" '$last_name', '$when_it_happened', '$how_long', '$how_many', '$alien_description', ".
	    	"'$what_they_did', '$fang_spotted', '$other', '$email')";
        
		$result = mysqli_query($dbc, $query)
			or die('Error querying database.');

		mysqli_close($dbc);

	?>

</body>
</html>