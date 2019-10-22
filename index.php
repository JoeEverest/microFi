<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Dashboard</title>
</head>
<body><div class="container">
<h2>Operator Dashboard</h2>
    <h4>Operator Name: <?php echo $userLoggedIn; ?></h4>
    <a href="branches.php">Branches</a><br>
    <a href="active_loans.php">Active Loans</a><br>
    <a href="new_loan.php">New Loan</a><br>
    <a href="deliquence.php">View Deliquence</a><br>
</div></body>
</html>