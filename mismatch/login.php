<?php require_once("conecta.php");
$page_title = ' - Log In';
include_once("header.php");

$error_msg = "";

if(!isset($_SESSION['user_id'])) {
	if(isset($_POST['submit'])) {
		$user_username = mysqli_real_escape_string($conecta, trim($_POST['username']));
		$user_password = mysqli_real_escape_string($conecta, trim($_POST['password']));

		if(!empty($user_username) && !empty($user_password)) {
			$query = "SELECT user_id, username FROM mismatch_user WHERE  username = '$user_username' AND password = SHA('$user_password')";
			$data = mysqli_query($conecta, $query)
				or die("erro ao acessar banco de dados.");

			if(mysqli_num_rows($data) == 1) {
				$row =mysqli_fetch_array($data);

				require_once('startsession.php');
				
				$home_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).
					"/index.php";
				header("Location:".$home_url);
			} else {
				$error_msg = "Nome ou senha inválida. Ou <a href='signup.php'>Cadastrar.</a>";
			}
		} else {
			$error_msg = "Digite o nome e sua senha. Ou <a href='signup.php'>Cadastrar.</a>";
		}
	}
	?>
	<?php
} 

if(empty($_SESSION['user_id'])) {
	echo "<p>".$error_msg."</p>";
?>
	<form action="login.php" method="post">
		<label for="username">Usuário:</label>
		<input type="text" name="username"><br>

		<label for="password">Senha:</label>
		<input type="password" name="password"><br><br>

		<input type="submit" name="submit" value="Entrar">
	</form>

<?php 
} else {
	echo "<p>Você está logado como ".$_SESSION['username']."</p>";
}

include_once('footer.php'); 

?>

