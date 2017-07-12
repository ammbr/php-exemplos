<?php require_once("conecta.php");
require_once("appvars.php");
session_start();

echo "<h1>Mismatch - View Profile</h1>";
if(isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$query = "SELECT * FROM mismatch_user WHERE user_id ='$user_id'";
	$data = mysqli_query($conecta, $query)
		or die("erro ao acessar banco de dados.");
	echo "<table>";
	while ($user = mysqli_fetch_assoc($data)) {
		
		echo "<tr><td>Username:</td><td>".$user['username']."</td></tr>";
		echo "<tr><td>First name:</td><td>".$user['first_name']."</td></tr>";
		echo "<tr><td>Last name:</td><td>".$user['last_name']."</td></tr>";
		echo "<tr><td>Gender:</td><td>".$user['gender']."</td></tr>";
		echo "<tr><td>Birthday:</td><td>".$user['birthday']."</td></tr>";
		echo "<tr><td>Location:</td><td>".$user['city'].", ".$user['state']."</td></tr>";
		echo "</table>";
		echo "<img alt='foto' src='".GW_UPLOADPATH.$user['picture']."'><br>";
		
	}
}
echo "<a href='index.php'>Voltar<a/>";

mysqli_close($conecta);

