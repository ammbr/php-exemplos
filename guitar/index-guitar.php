<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Guitar</title>
	<link rel="stylesheet" type="text/css" href="css/guitar-style.css">
</head>
<body>
	<h2>Guitar Wars</h2>
	<br>
<?php 
	require_once('appvars.php');
	require_once('conecta.php');

	
	$query = "SELECT * FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
	$data = mysqli_query($dbc, $query);
	echo '<table>';

	$i = 0;

	while($row = mysqli_fetch_assoc($data)) {

		if($i == 0) {
			echo '<tr><td colspan="2" class="topScoreHeader">Top Score: '.$row['score'].
				'</tr></td>';
		}
		echo '<tr><td>';
		echo '<span>'.$row['score'].'</span><br>';
		echo '<strong>Name:</strong>'.$row['name'].'<br>';
		echo '<strong>Date:</strong>'.$row['date'].'<br>';
		if(is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0) {
			echo '<td><img src="'. GW_UPLOADPATH . $row['screenshot'].'" alt="image"></td></tr>';
		} else {
			echo '<td><img src="'. GW_UPLOADPATH . 'invalido.jpg" alt=unimage"></td></tr>';
		}
		$i++;
	}	
	echo '<table>';

	mysqli_close($dbc);

	 ?>
	
</body>
</html>