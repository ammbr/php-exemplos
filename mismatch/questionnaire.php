<?php 
$page_title = ' - Questionnaire';
require_once('header.php');
require_once('appvars.php');
require_once('conecta.php');


if(!isset($_SESSION['user_id'])) {
	echo '<p>Por favor <a href="login.php"> faça </a> login para acessar esta página.</p>';
	exit;
}

$query = "SELECT * FROM mismatch_response WHERE user_id ='".$_SESSION['user_id']."'";
$data = mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
if(mysqli_num_rows($data) == 0) {
	$query = "SELECT topic_id FROM mismatch_topic ORDER BY category_id, topic_id";
	$data = mysqli_query($conecta, $query)
		or die("erro ao acessar banco de dados.");
	$topicIDs = array();
	while ($row = mysqli_fetch_array($data)) {
		array_push($topicIDs, $row['topic_id']);
	}
	foreach ($topicIDs as $topic_id) {
		$query = "INSERT INTO mismatch_response (user_id, topic_id) VALUES ('".$_SESSION['user_id']."', '$topic_id')";
		mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
	}
}
if(isset($_POST['submit'])) {
	foreach ($_POST as $response_id => $response) {
		$query = "UPDATE mismatch_response SET response = '$response' WHERE response_id = '$response_id'";
		mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
	}
	echo '<p>As suas respostas foram registradas.</p>';
}
$query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name, mc.name AS category_name FROM mismatch_response AS mr INNER JOIN mismatch_topic AS mt USING(topic_id) INNER JOIN mismatch_category AS mc USING(category_id) WHERE mr.user_id = '".$_SESSION['user_id']."'";
$data = mysqli_query($conecta, $query);
$responses = array();
while ($row = mysqli_fetch_array($data)) {
	array_push($responses, $row);
}
mysqli_close($conecta);

echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
echo '<p>Qual sua opinião sobre cada tópico?</p>';
$category = $responses[0]['category_name'];
echo '<fieldset><legend>'.$responses[0]['category_name'].'</legend>';
foreach ($responses as $response) {
	if($category != $response['category_name']) {
		$category = $response['category_name'];
		echo '</fieldset><fieldset><legend>'.$response['category_name'].'</legend>';
	}
	echo '<label class="questionarioLabel" '.($response['response'] == NULL ? '' : '').' for="'.$response['response_id'].'">'.$response['topic_name'].':</label>';
	echo '<input type="radio" id="'.$response['response_id'].'" name="'.$response['response_id'].'" value="1"'.
	($response['response'] == 1 ? 'checked' : "").'>Love';
	echo '<input type="radio" id="'.$response['response_id'].'" name="'.$response['response_id'].'" value="2"'.
	($response['response'] == 2 ? 'checked' : "").'>Hate<br>';
}
echo '</fieldset>';
echo '<input type="submit" value="Salvar o questionário" name="submit">';
echo '</form>';
require_once('footer.php');
 ?>