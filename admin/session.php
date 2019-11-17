<?php
session_start();
$host = 'localhost';
$loginUser = 'root';
$loginPassword = '';
$dbName = 'microfinance';
$conn = mysqli_connect($host, $loginUser, $loginPassword, $dbName);//Connection variable


if (isset($_SESSION['loginId'])) {
    $userLoggedIn = $_SESSION['loginId'];   
    
}
else{
	header("Location: admin_login.php");
}
?>