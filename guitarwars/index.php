<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Guitar Wars</title>
	<link rel="stylesheet" type="text/css" href="css/guitar-style.css">
</head>
<body>
	<h2>Guitar Wars</h2>
	<br>
	
<?php 
require_once('appvars.php'); 
require_once('conecta.php');
if(!isset($_SESSION['user_id'])) {
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		$_SESSION['username'] = $_COOKIE['username'];
	}
}
if(isset($_SESSION['username'])) {
	echo "<a href='index.php'>Home</a><br>";
	echo "<a href='admin.php'>Gerenciar</a><br>";
	echo "<a href='addscore.php'>Adicionar Pontuação</a><br>";
	echo "<a href='logout.php'>Logout</a><br><br>";
} else {

	echo "<a href='index.php'>Home</a><br>";
	echo "<a href='admin.php'>Gerenciar</a><br>";
	echo "<a href='login.php'>Login</a><br>";
	echo "<a href='signup.php'>Sign Up</a><br><br>";
}

$query = "SELECT * FROM guitarwars INNER JOIN usuarios ON (guitarwars.user_id = usuarios.user_id and guitarwars.approved = '1') ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query)
	or die("erro ao acessar banco de dados.");
echo '<table>';

$i = 0;

while($row = mysqli_fetch_assoc($data)) {

	if($i == 0) {
		echo '<tr><td colspan="2" class="topScoreHeader">Top Score: '.$row['score'].
			'</tr></td>';
	}
	echo '<tr><td>';
	echo '<span>'.$row['score'].'</span><br>';
	echo '<strong>Name:</strong>'.$row['first_name'].'<br>';
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