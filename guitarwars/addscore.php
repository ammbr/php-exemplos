<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Guitar Wars</title>
</head>
<body>
	<h2>Guitar Wars</h2>

<?php  
require_once('appvars.php');
require_once('conecta.php');
if(!isset($_SESSION['user_id'])) {
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		$_SESSION['username'] = $_COOKIE['username'];
	}
}

if(isset($_POST['submit'])) {
		
	$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
	$last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	$score = mysqli_real_escape_string($dbc, trim($_POST['score']));
	$screenshot = mysqli_real_escape_string($dbc, trim($_FILES['screenshot']['name']));
	$screenshot_type = $_FILES['screenshot']['type'];
	$screenshot_size = $_FILES['screenshot']['size'];

	if(!empty($name) && is_numeric($score) && !empty($screenshot)) {

		if((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpg') ||
			($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/png')) && ($screenshot_size > 0) && ($screenshot_size <= MAX_FILE_SIZE)) {
			if($_FILES['screenshot']['error'] == 0) {

				$target = GW_UPLOADPATH . $screenshot;
				if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {

					$user_id = $_SESSION['user_id'];
				
					$query = "UPDATE usuarios SET first_name = '$name', last_name = '$last_name' WHERE user_id = '$user_id'";
					mysqli_query($dbc, $query)
						or die('Erro ao consultar o banco de dados MySQL server.');
					$query2 = "UPDATE guitarwars SET date = NOW(), score = '$score', screenshot = '$screenshot' WHERE user_id = '$user_id'";
					mysqli_query($dbc, $query2)
						or die('Erro ao consultar o banco de dados MySQL server.');
					echo '<p>Obrigado por adicionar o seu recorde.</p>';
					echo '<p><strong>Nome:</strong>' . $name . '<br>';
					echo '<img src="'.GW_UPLOADPATH . $screenshot.'" alt="img"></p>';
					
					$name = "";
					$last_name = "";
					$score = "";
					$screenshot = ""; 
					
					mysqli_close($dbc);
			    }
			} else {
				echo '<p>Houve um problema no arquivo na tentativa de envio.</p>';
			}
		} else {
			echo '<p>O arquivo precisa ser jpg, gif ou png e ser menor que '.MAX_FILE_SIZE.'KB.</p>';
		}
		@unlink($_FILES['screenshot']['tmp_name']);

	} else {
		echo '<p>Insira todas as informações.</p>';
	}
}

 ?>
 	<hr>

 	<form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<input type="hidden" name="MAX_FILE_SIZE" value="<?=MAX_FILE_SIZE?>">
		<label for="name">Nome:</label>
		<input type="text" id="name" name="name" value="<?php if(!empty($name))echo $name?>">
		<br>
		<label for="last_name">Sobrenome:</label>
		<input type="text" id="last_name" name="last_name" value="<?php if(!empty($last_name))echo $last_name?>">
		<br>
		<label for="score">Pontuação:</label>
		<input type="text" id="score" name="score" value="<?php if(!empty($score))echo $score?>">
		<br>
		<label for="screenshot">Captura de tela:</label>
		<input type="file" id="screenshot" name="screenshot">
		<hr>
		<input type="submit" name="submit" value="Add">
		
	</form><br>
	<a href ="index.php">&lt;&lt; Voltar para a lista dos recordes.</a>

</body>
</html>