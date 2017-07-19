<?php  
session_start();
require_once('startsession.php');

if(isset($_SESSION['username'])) {
	echo "&#10084;<a href='index.php'>Home</a><br>";
	echo "&#10084;<a href='view-profile.php'>View Profile</a><br>";
	echo "&#10084;<a href='edit-profile.php'>Edit Profile</a><br>";
	echo "&#10084;<a href='questionnaire.php'>Questionnaire</a><br>";
	echo "&#10084;<a href='mymismatch.php'>Mymismatch</a><br>";
	echo "&#10084;<a href='logout.php'>Logout</a><br><br>";
} else {

	echo "&#10084;<a href='index.php'>Home</a><br>";
	echo "&#10084;<a href='login.php'>Login</a><br>";
	echo "&#10084;<a href='signup.php'>Sign Up</a><br><br>";
}
echo '<hr>';