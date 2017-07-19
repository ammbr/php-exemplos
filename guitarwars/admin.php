<?php
require_once('authorize.php');
require_once('appvars.php');
require_once('conecta.php')
?>

<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
	<title>Guitar</title>
	<link rel="stylesheet" type="text/css" href="css/guitar-style.css">
</head>
<body>
	<h2>Guitar Wars</h2>
	
<?php 

	
	$query = "SELECT * FROM guitarwars INNER JOIN usuarios ON (guitarwars.user_id = usuarios.user_id) ORDER BY score DESC, date ASC";
	$data = mysqli_query($dbc, $query);
	echo '<table>';

	while($row = mysqli_fetch_array($data)) {

		echo '<tr><td><strong>'.$row['first_name'].'</strong></td>';
		echo '<td>'.$row['date'].'</td>';
		echo '<td>'.$row['score'].'</td>';
		echo '<td><a href="remove-score.php?id='.$row['id'].'&amp;date='.$row['date'].'&amp;name='. $row['first_name'].'&amp;score='.$row['score'].'&amp;screenshot='.$row['screenshot'].'">Remove</a></td>';
		if($row['approved'] == 0) {
			echo '<td><a href="aprovar.php?id='.$row['id'].'&amp;date='.$row['date'].'&amp;name='. $row['first_name'].'&amp;score='.$row['score'].'&amp;screenshot='.$row['screenshot'].'"> / Aprovar</a></td>';
		}	
		echo '</tr>';
	}	
	echo '<table>';

	mysqli_close($dbc);

	 ?>
	 <p><a href="index.php">Voltar</a></p>
	
</body>
</html>
