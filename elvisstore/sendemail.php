
<?php  
if(isset($_POST['submit'])) {
	$output_form = false;
	$dbc = mysqli_connect('localhost', 'root', '', 'elvis')
		or die('Error connecting to MySQL server.');
	$from = 'elmer@makemeelvis.com';
	$subject = $_POST['subject'];
	$text = $_POST['elvismail'];
	$query = "SELECT * FROM email_list";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result);

	if(empty($subject) && empty($text)) {
		echo "Você esqueceu os dois campos.<br>";
		$output_form = true; 
	}
	if(empty($subject) && (!empty($text))) {
		echo "Você esqueceu o assunto.<br>";
		$output_form = true;
	}
	if((!empty($subject)) && empty($text)) {
		echo "Você esqueceu o texto.<br>";
		$output_form = true;
	}
	if((!empty($subject)) && (!empty($text))) {
		
		while ($row = mysqli_fetch_array($result)) {
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];

			$msg = "Dear $first_name $last_name, \n $text";
			$to =$row['email'];

			mail($to, $subject, $msg, 'From: '.$from);
			echo 'Email send to '.$to.'<br>';
		}
		mysqli_close($dbc);
	}
} else {
	$output_form = true;
}
if($output_form) { ?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		
	<label for="subject">Subject of email:</label><br>
	<input type="text" name="subject" id="subject" 
		value="<?php if(isset($subject)){echo $subject;} ?>"><br>
		
	<label for="elvismail">Body of email:</label><br>
	<textarea cols="40" rows="10" name="elvismail">
		<?php if(isset($text)){echo $text;} ?></textarea><br>
	<input type="submit" name="submit">
	
</form>

<?php } ?>

