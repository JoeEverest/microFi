<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

$today = date('Y-m-d', strtotime('Today'));

$retrieve = "SELECT * FROM payments WHERE next_payment = '$today' ORDER BY id DESC";
$retrieve = mysqli_query($connect, $retrieve);
?>