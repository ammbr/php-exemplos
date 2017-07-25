<?php include_once('header.php');
require_once('conecta.php');

echo '<h2>Risky Jobs - Registration</h2>';

if (isset($_POST['submit'])) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$job = $_POST['job'];
	$resume = $_POST['resume'];
	$output_form = 'no';

	if (empty($first_name)) {
		echo '<p>Digite seu nome.</p>';
		$output_form = 'yes';
	}
	if (empty($last_name)) {
		echo '<p>Digite seu sobrenome.</p>';
		$output_form = 'yes';
	}
	if (!preg_match('/[a-zA-Z0-9\_\-%!?=#]*@/', $email)) {
		echo '<p>Email inválido.</p>';
		$output_form = 'yes';
	} else {
		$domain = preg_replace('/^[a-zA-Z0-9][a-zA-Z-9\_\-&!?=#]*@/','', $email);
		function myCheckDNSRR($hostName, $recType = '') {
			if(!empty($hostName)) { 
			   	if( $recType == '' ) $recType = "MX"; 
			   	exec("nslookup -type=$recType $hostName", $result); 
			   	// check each line to find the one that starts with the host 
			   	// name. If it exists then the function succeeded. 
			   	foreach ($result as $line) { 
			    	if(preg_match("/^$hostName/",$line)) { 
			        	return true; 
				    } 
				} 
			   	// otherwise there was no mail handler for the domain 
			   	return false; 
			} 
			return false; 
		} 
		if (!myCheckDNSRR($domain) || !checkdnsrr($domain)) {
			echo '<p>Email inválido.</p>';
			$output_form ='yes';
		}
	}
	if (!preg_match('/^\(?[2-9]\d{2}\)?[-\s]\d{3}?[-\s]\d{4}$/', $phone)) {
		echo '<p>Número do seu telefone é inválido.</p>';
		$output_form = 'yes';
	} else {
		$pattern = '/[\(\)\-\s]/';
		$replacement = '';
		$new_phone = preg_replace($pattern, $replacement, $phone);
	}
	if (empty($job)) {
		echo '<p>Digite o serviço desejado.</p>';
		$output_form = 'yes';
	}
	if (empty($resume)) {
		echo '<p>Não foi digitado nada no resumo.</p>';
		$output_form = 'yes';
	}
	if ($output_form == 'no') {
		$query = "INSERT INTO user (first_name, last_name, email, phone, desired_job, resume) VALUES ('$first_name', '$last_name', '$email', '$new_phone', '$job', '$resume')";
		mysqli_query($dbc, $query)
			or die("erro ao acessar banco de dados.");
		mysqli_close($dbc);
		echo 'Cadastro realizado.';
		echo '<p>Seu número telefônico foi registrado como '.$new_phone.'.</p>';
	}

} else {
	$output_form = 'yes';
}
if ($output_form == 'yes') {
?>
<form action="registration.php" method="post">
	<label for="first_name">First Name:</label>
	<input type="text" name="first_name" id="first_name"><br>
	<label for="last_name">Last Name:</label>
	<input type="text" name="last_name" id="last_name"><br>
	<label for="email">Email:</label>
	<input type="email" name="email" id="email"><br>
	<label for="phone">Phone:</label>
	<input type="text" name="phone" id="phone"><br>
	<label for="job">Desired Job</label>
	<input type="text" name="job" id="job"><br>
	<label class="clear" for="resume">Paste your resume here:</label><br>
	<textarea id="resume" name="resume"></textarea><br>
	<input type="submit" name="submit" value="Submit">
</form>
<?php 
}
include_once('footer.php'); 
?>