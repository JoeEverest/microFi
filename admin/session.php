<?php
session_start();

if (isset($_SESSION['loginId'])) {
    $userLoggedIn = $_SESSION['loginId'];   
}
else{
	header("Location: admin_login.php");
}
?>