<?php require_once("conecta.php");
require_once("appvars.php")
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mismatch</title>
</head>
<body>

	<h1>Mismatch</h1>

<?php 
if(isset($_COOKIE['username'])) {
	echo "&#10084;<a href='view-profile.php'>View Profile</a><br>";
	echo "&#10084;<a href='edit-profile.php'>Edit Profile</a><br>";
	echo "&#10084;<a href='logout.php'>Logout</a><br>";
} else {

	echo "&#10084;<a href='login.php'>Login</a><br>";
	echo "&#10084;<a href='signup.php'>Sign Up</a><br>";
}
 ?>
	
	<h2>Menmbers</h2>

<?php 

$query = "SELECT * FROM mismatch_user";
$data = mysqli_query($conecta, $query)
	or die("erro ao acessar banco de dados.");
echo "<table>";
while ($user = mysqli_fetch_assoc($data)) {
	
	echo "<tr><td><img alt='foto' src='".GW_UPLOADPATH.$user['picture']."'></td><td>".$user['first_name']."</td></tr>";
}
echo "</table>";

mysqli_close($conecta);

?>

</body>
</html>
