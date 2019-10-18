<?php
session_start();

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
include('header.php');

?>

    <h3><?php echo $userLoggedIn; ?></h3>
    <a href="branches.php">Branches</a>
    <a href="active_loans.php">Active Loans</a>
    <a href="new_loan.php">New Loan</a>
</body>
</html>