<?php
session_start();

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
    <title>Dashboard</title>
</head>
<body>
    <h3><?php echo $userLoggedIn; ?></h3>
    <a href="branches.php">Branches</a>
    <a href="active_loans.php">Active Loans</a>
    <a href="new_loan.php">New Loan</a>
</body>
</html>