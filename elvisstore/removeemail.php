<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<?php 

$dbc = mysqli_connect('localhost', 'root', '', 'elvis')
	or die('Error connecting to MySQL server.');

if(isset($_POST['submit'])) {

	foreach($_POST['todelete'] as $delete_id) {
		$query = "DELETE FROM email_list WHERE id = $delete_id";
		mysqli_query($dbc, $query)
			or die('Erro ao consultar o banco de dados MySQL server.');
	}
	echo 'Cliente(s) removido(s).<br>';
}

$query = "SELECT * FROM email_list";
$result = mysqli_query($dbc, $query)
	or die('Erro ao consultar o banco de dados MySQL server.');
	
while ($row = mysqli_fetch_array($result)) {
	
	echo '<input type="checkbox" name="todelete[]" value="'.$row['id'].'">';

	echo $row['first_name'].' '.$row['last_name'].' '.$row['email'].'<br>';
}
mysqli_close($dbc);
?>

<input type="submit" name="submit" value="Remover">

</form>

