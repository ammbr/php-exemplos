<?php  

$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];
setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));
setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));

