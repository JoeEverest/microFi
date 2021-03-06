<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $getCenter = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn'";
    $getCenter = mysqli_query($connect, $getCenter);
    while ($centerName = mysqli_fetch_array($getCenter)) {
        $centerDetails = $centerName['center_name'];
        $cname = explode("_", $centerDetails);
        $center__name = $cname[0];
        $branch__name = $cname[1];
    }
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
    <title>Incomes</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="body">
                <div class="cards">
                    <a href="all_incomes.php">
                        <div class="card home-cards">
                            <img src="https://img.icons8.com/wired/200/000000/add-property.png">
                            <p>All Incomes</p>
                        </div>
                    </a>
                    <a href="group_incomes.php">
                        <div class="card home-cards">
                            <img src="https://img.icons8.com/dotty/200/000000/add-user-group-man-man.png">
                            <p>Incomes by Groups</p>
                        </div>
                    </a>
                    <!-- <a href="customer_incomes.php">
                        <div class="card home-cards">
                            <img src="https://img.icons8.com/dotty/200/000000/data-pending.png">
                            <p>Incomes by Customers</p>
                        </div>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>