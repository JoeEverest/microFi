<?php
session_start();
include('config/config.php');
include('date.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];
    
    $getCenter = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn'";
    $getCenter = mysqli_query($connect, $getCenter);
    while ($centerName = mysqli_fetch_array($getCenter)){
        $centerDetails = $centerName['center_name'];
        $cname = explode("_", $centerDetails);
        $center__name = $cname[0];
        $branch__name = $cname[1];
    }
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
    <title>New Loan</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <p>New Loan</p>
    <div class="cards">
        <a href="new_customer.php"><div class="card">
        <img src="https://img.icons8.com/dotty/150/000000/add-administrator.png">
          <p>New Customer</p>
        </div></a>
        <a href="loan_existing_customer.php">
            <div class="card">
            <img src="https://img.icons8.com/wired/150/000000/add-property.png">
                <p>New Loan</p>
            </div>
        </a>
    </div>
</div></body>
</html>