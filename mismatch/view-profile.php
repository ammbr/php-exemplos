<?php require_once("conecta.php");
require_once("appvars.php");
$page_title = ' - View Profile';
include_once("header.php");

if(isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$query = "SELECT * FROM mismatch_user WHERE user_id ='$user_id'";
	$data = mysqli_query($conecta, $query)
		or die("erro ao acessar banco de dados.");
	
} elseif (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
		$query = "SELECT * FROM mismatch_user WHERE user_id ='$user_id'";
		$data = mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
		
	
}
while ($user = mysqli_fetch_assoc($data)) {
		echo "<table>";
		echo "<tr><td>Username:</td><td>".$user['username']."</td></tr>";
		echo "<tr><td>First name:</td><td>".$user['first_name']."</td></tr>";
		echo "<tr><td>Last name:</td><td>".$user['last_name']."</td></tr>";
		echo "<tr><td>Gender:</td><td>".$user['gender']."</td></tr>";
		echo "<tr><td>Birthday:</td><td>".$user['birthday']."</td></tr>";
		echo "<tr><td>Location:</td><td>".$user['city'].", ".$user['state']."</td></tr>";
		echo "</table>";
		echo "<img alt='foto' src='".UPLOADPATH.$user['picture']."'><br>";
		
}
mysqli_close($conecta);

include_once('footer.php');


