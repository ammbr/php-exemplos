<?php 
$page_title = ' - Mymismatch';
include_once('header.php');
require_once('conecta.php');
require_once('appvars.php');


$query = "SELECT * FROM mismatch_response WHERE user_id = '".$_SESSION['user_id']."'";
$data = mysqli_query($conecta, $query)
	or die("erro ao acessar banco de dados.");

if (mysqli_fetch_array($data) != 0) {
	$query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name FROM mismatch_response AS mr INNER JOIN mismatch_topic AS mt USING(topic_id) WHERE mr.user_id = '".$_SESSION['user_id']."'";
	$data = mysqli_query($conecta, $query)
		or die("erro ao acessar banco de dados.");
	$user_responses = array();
	while($row = mysqli_fetch_array($data)) {
		array_push($user_responses, $row);
	}

	$mismatch_score = 0;
	$mismatch_user_id = -1;
	$mismatch_topics = array();

	$query = "SELECT user_id FROM mismatch_user WHERE user_id != '".$_SESSION['user_id']."'";
	$data = mysqli_query($conecta, $query)
		or die("erro ao acessar banco de dados.");

	while ($row = mysqli_fetch_array($data)) {
		$query2 = "SELECT response_id, topic_id, response FROM mismatch_response WHERE user_id != '".$_SESSION['user_id']."'";
		$data2 = mysqli_query($conecta, $query2)
		or die("erro ao acessar banco de dados.");
		$mismatch_responses = array();
		while ($row2 = mysqli_fetch_array($data2)) {
			array_push($mismatch_responses, $row2);
		}
		$score = 0;
		$topics = array();
		for ($i = 0; $i < count($user_responses); $i++) {
			if ((int)$user_responses[$i]['response'] + (int)$mismatch_responses[$i]['response'] == 3) {
			$score += 1;
			array_push($topics, $user_responses[$i]['topic_name']);
	        }
		}
		if ($score > $mismatch_score) {
			$mismatch_score = $score;
			$mismatch_user_id = $row['user_id'];
			$mismatch_topics = array_slice($topics, 0);
		}
	}
	if ($mismatch_user_id != -1) {
		$query = "SELECT username, first_name, last_name, city, state, picture FROM mismatch_user WHERE user_id = '$mismatch_user_id'";
		$data = mysqli_query($conecta, $query)
			or die("erro ao acessar banco de dados.");
		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			echo '<table><tr><td>';
			if (!empty($row['first_name']) && !empty($row['last_name'])) {
				echo $row['first_name']. ' ' . $row['last_name'] . '<br>';
			}
			if (!empty($row['city']) && !empty($row['state'])) {
				echo $row['city'].', '.$row['state'].'<br>';

			}
			echo '</td><td>';
			if (!empty($row['picture'])) {
				echo '<img src= "' . UPLOADPATH.$row['picture'].'" alt="Profile Picture"><br>';

			}
			echo '</td></tr></table>';

			echo '<h4>Vocês tiveram respostas diferentes nos seguintes '.count($mismatch_topics).' tópicos:</h4>';
			foreach ($mismatch_topics as $topic) {
				echo $topic . '<br>';
			}
			echo '<h4>View <a href="view-profile.php?user_id='.$mismatch_user_id.'">'.$row['first_name'].'\'s profile</a>.</h4>';
		}
	}

} else {
	echo '<p> Você precisa primeiro <a href="questionnaire.php"> responder o questionário </a> antes de encontrar seu par imperfeito</p>';
}
include_once('footer.php');