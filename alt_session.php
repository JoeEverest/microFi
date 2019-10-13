<?php
if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	if (isset($_SESSION['loginId'])) {
    $userLoggedIn = $_SESSION['loginId'];   
    }else{
	header("Location: login.php");
    }
}
?>