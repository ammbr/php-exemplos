<?php require_once("conecta.php");
require_once("appvars.php");
$page_title = '';
include_once("header.php");
	
echo '<h2>Members</h2>';

$query = "SELECT * FROM mismatch_user";
$data = mysqli_query($conecta, $query)
	or die("erro ao acessar banco de dados.");
echo "<table>";
while ($user = mysqli_fetch_assoc($data)) {
	
	echo "<tr><td><img alt='foto' src='".GW_UPLOADPATH.$user['picture']."'></td><td>".$user['first_name']."</td></tr>";
}
echo "</table>";

mysqli_close($conecta);

include_once('footer.php');