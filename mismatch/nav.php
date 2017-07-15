<?php  
session_start();

if(!isset($_SESSION['user_id'])) {
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		$_SESSION['username'] = $_COOKIE['username'];
	}
}

if(isset($_SESSION['username'])) {
	echo "&#10084;<a href='index.php'>Home</a><br>";
	echo "&#10084;<a href='view-profile.php'>View Profile</a><br>";
	echo "&#10084;<a href='edit-profile.php'>Edit Profile</a><br>";
	echo "&#10084;<a href='logout.php'>Logout</a><br><br>";
} else {

	echo "&#10084;<a href='index.php'>Home</a><br>";
	echo "&#10084;<a href='login.php'>Login</a><br>";
	echo "&#10084;<a href='signup.php'>Sign Up</a><br><br>";
}
echo '<hr>';