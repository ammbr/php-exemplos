<?php  

$dbc = mysqli_connect('localhost','root','','elvis_store')
	or die ('Erro ao conectar com o servidor MySQL server.');
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$query = "INSERT INTO email_list (first_name, last_name, email)".
	"VALUES ('$first_name', '$last_name', '$email')";

mysqli_query($dbc, $query)
	or die ('Erro ao acessar o banco de dados.');

echo 'Cliente adicionado!';

mysqli_close($dbc);

