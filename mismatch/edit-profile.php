<?php require_once("conecta.php");
require_once("appvars.php");
 if(isset($_COOKIE['user_id'])) {
 	$user_id = $_COOKIE['user_id'];
	if(isset($_POST['submit'])) {

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$sexo = $_POST['gender'];
		$birthday = $_POST['birthday'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$picture = mysqli_real_escape_string($conecta, trim($_FILES['picture']['name']));
		$screenshot_type = $_FILES['picture']['type'];
		$screenshot_size = $_FILES['picture']['size'];

		if(!empty($first_name) && !empty($last_name) && !empty($sexo) && !empty($birthday) && !empty($city) && !empty($state) && !empty($picture)) {
			if((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpg') ||
				($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/png')) && ($screenshot_size > 0) && ($screenshot_size <= MAX_FILE_SIZE)) {
				if($_FILES['picture']['error'] == 0) {

					$target = GW_UPLOADPATH . $picture;
					if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {

					$query = "UPDATE mismatch_user SET first_name = '$first_name', last_name = '$last_name', gender = '$sexo', birthday = '$birthday', city = '$city', state = '$state', picture = '$picture' WHERE user_id = '$user_id'";
					mysqli_query($conecta, $query)
						or die("erro ao acessar banco de dados.");
					mysqli_close($conecta);
					echo "Perfil atualizado.";
				   	}
				} else {
						echo '<p>Houve um problema no arquivo na tentativa de envio.</p>';
				}
			} else {
				echo '<p>O arquivo precisa ser jpg, gif ou png e ser menor que '.MAX_FILE_SIZE.'KB.</p>';
			}
		} else {
			echo "<p>Insira todas as informações.</p>";
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mismatch</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
	<h1>Cadastro</h1>

	<form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<label for="first_name">First Name:</label>
		<input type="text" id="first_name" name="first_name"><br>

		<label for="last_name">Last Name:</label>
		<input type="text" id="last_name" name="last_name"><br>
		
		<label for="gender">Sexo:</label>
		M<input type="radio" id="gender " name="gender" value="M">
		F<input type="radio" id="gender " name="gender" value="F"><br>
	
		<label for="birthday">Birthday:</label>
		<input type="text" id="birthday" name="birthday"><br>

		<label for="city">City:</label>
		<input type="text" id="city" name="city"><br>

		<label for="state">State:</label>
		<input type="text" id="state" name="state"><br>

		<label for="picture">Picture:</label>
		<input type="file" id="picture" name="picture"><br><br>

		<input type="submit" name="submit" value="Cadastrar">

	</form>
	<a href="index.php">Voltar</a>
	
</body>
</html>