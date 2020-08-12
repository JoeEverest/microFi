<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];
} else {
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
    <?php include('css.php'); ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="cards">
            <a href="create_center.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/wired/200/000000/add-property.png">
                    <p>Create new Center</p>
                </div>
            </a>
            <a href="create_group.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/dotty/200/000000/add-user-group-man-man.png">
                    <p>Create new Group</p>
                </div>
            </a>
            <a href="loan_existing_customer.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/wired/150/000000/add-property.png">
                    <p>New Loan</p>
                </div>
            </a>
            <a href="new_customer.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/dotty/150/000000/add-administrator.png">
                    <p>New Customer</p>
                </div>
            </a>
            <a href="pending_loans.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/dotty/200/000000/data-pending.png">
                    <p>Pending Loans</p>
                </div>
            </a>
        </div>
    </div>
</body>

</html>