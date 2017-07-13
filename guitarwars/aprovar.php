<?php 
require_once('authorize.php');
require_once('appvars.php');
require_once('conecta.php');

if(isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name']) && isset($_GET['score']) && isset($_GET['screenshot'])) {

	$id = $_GET['id'];
	$date = $_GET['date']; 
	$name = $_GET['name'];
	$score = $_GET['score'];
	$screenshot = $_GET['screenshot'];
} elseif(isset($_POST['id']) && isset($_POST['date']) && isset($_POST['name']) && isset($_POST['score']) && isset($_POST['screenshot'])) {

	$id = $_POST['id'];
	$date = $_POST['date'];
	$name = $_POST['name'];
	$score = $_POST['score'];
	$screenshot = $_POST['screenshot'];
} else {
	echo '<p>Erro ao especificar</p>';
}
if(isset($_POST['submit'])) {
	if($_POST['confirm'] == 'Yes') {
		$query = "UPDATE guitarwars SET approved = 1 WHERE id = $id";
		mysqli_query($dbc, $query)
			or die ('Erro ao acessar o banco de dados.');
		mysqli_close($dbc);
		echo "<p>A pontuação de ".$score." para ".$name." foi aprovada.";
	} else {
		echo "<p>A pontuação de ".$score." para ".$name." não foi aprovada.";
	}
} elseif(isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)) {
	echo '<p>Tem certeza que deseja aprovar?</p>';
	echo '<p><strong>Nome:</strong>'.$name.'<br><strong>Date:</strong>'.$date.'<br><strong>Pontuação:</strong>'.$score.'<br></p>';
	echo '<img src="'.GW_UPLOADPATH.$screenshot.'" alt="image"<br>';
	echo '<form method="post" action="aprovar.php">';
	echo '<input type="radio" name="confirm" value="Yes">Yes';
	echo '<input type="radio" name="confirm" value="No" checked="checked">No<br>';
	echo '<input type="submit" name="submit" value="Submit">';
	echo '<input type="hidden" name="id" value="'.$id.'">';
	echo '<input type="hidden" name="name" value="'.$name.'">';
	echo '<input type="hidden" name="date" value="'.$date.'">';
	echo '<input type="hidden" name="score" value="'.$score.'">';
	echo '<input type="hidden" name="screenshot" value="'.$screenshot.'">';
	echo '</form>';
}
echo '<p><a href="admin.php">&lt;&lt; Voltar</a></p>';

 