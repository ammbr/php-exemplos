<?php require_once("conecta.php");
session_start();

if(isset($_POST['submit'])) {
	$username = mysqli_real_escape_string($conecta, trim($_POST['username']));
	$password1 = mysqli_real_escape_string($conecta, trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($conecta, trim($_POST['password2']));

	if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
		$query = "SELECT * FROM mismatch_user WHERE username ='$username'";
		$data = mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
		if(mysqli_num_rows($data) == 0) {
			$query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$username', SHA('$password1'), NOW())";
			mysqli_query($conecta, $query)
				or die("erro ao acessar banco de dados.");
			if(isset($username)) {
				$query = "SELECT user_id, username FROM mismatch_user WHERE  username = '$username' AND password = SHA('$password1')";
			$data = mysqli_query($conecta, $query)
				or die("erro ao acessar banco de dados.");

				if(mysqli_num_rows($data) == 1) {
					$row =mysqli_fetch_array($data);
					$_SESSION['user_id'] = $row['user_id'];
				    $_SESSION['username'] = $row['username'];
				}
			}
			echo "<p>Conta criada com sucesso. Agora você pode fazer login e <a href='edit-profile.php'>editar seu perfil</a>.<p>";
			mysqli_close($conecta);
			exit();
		} else {
			echo "<p>Esse usuário já existe.Escolha outro.</p>";
			$username = "";
		}
	} else {
		echo "<p>Digite todos os dados.</p>";
	}
} 
mysqli_close($conecta);
?>
<form method="post" action="signup.php">
		<fieldset>

			<legend>Informações de registro.</legend>

			<label for="username">Username:</label>
			<input type="text" id="username" name="username" value="<?php if(!empty($username)) echo $username; ?>"><br>

			<label for="password1">Password:</label>
			<input type="password" id="password1" name="password1"><br>

			<label for="password2">Password:</label>
			<input type="password" id="password2" name="password2"><br>

		</fieldset>
		<input type="submit" name="submit" value="Sign Up">
	</form>

