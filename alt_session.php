<?php
include('config/config.php');
include('date.php');
if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	if (isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];  

    }else{
	header("Location: login.php");
    }
}
?>