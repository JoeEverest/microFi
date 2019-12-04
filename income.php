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
    <title>Customers</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <nav>
        <span class="element">
            <h4>Incomes</h4>
        </span>
        <span class="element">
            <h4>Operator: <u><?php echo $userLoggedIn; ?></u></h4>
        </span>
    </nav>
    <div class="body">
    <div class="cards">
        <a href="all_incomes.php"><div class="card">
            <img src="https://img.icons8.com/wired/200/000000/add-property.png">
            <p>All Incomes</p>
        </div></a>
        <a href="group_incomes.php">
            <div class="card">
            <img src="https://img.icons8.com/dotty/200/000000/add-user-group-man-man.png">            
                <p>Incomes by Groups</p>
            </div>
        </a>
        <a href="customer_incomes.php">
            <div class="card">
            <img src="https://img.icons8.com/dotty/200/000000/data-pending.png">           
                <p>Incomes by Customers</p>
            </div>
        </a>
    </div>
    </div>
    </div>
</body>
</html>