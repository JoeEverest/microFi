<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
    $retrieve = "SELECT * FROM deliquence ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
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
    <title>Document</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <table class="table table-striped">
        <thead>
            <td>Customer Name</td>
            <td>Customer ID</td>
            <td>Amount Left</td>
            <td>Payments Skipped</td>
            <td>Phone Number</td>
            <td>Action</td>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $name = $row['customer_name'];
            $customerId = $row['customer_id'];
            $amountLeft = $row['amount_left'];
            $paymentsSkipped = $row['payments_skipped'];
            $phoneNumber = $row['phone_number'];
        ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $customerId; ?></td>
            <td><?php echo $amountLeft; ?></td>
            <td><?php echo $paymentsSkipped; ?></td>
            <td><?php echo '+255'.$phoneNumber; ?></td>
            <td><a href="payment_history.php?id=<?php echo $customerId; ?>"><button class="btn btn-primary">View Payment History</button></a></td>
        </tr>
        <?php } ?>
    </table>
</div></body>
</html>