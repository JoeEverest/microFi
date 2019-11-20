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

$today = date('Y-m-d', strtotime('Today'));

$retrieve = "SELECT * FROM payments WHERE next_payment = '$today' ORDER BY id DESC";
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
    <title>All Payments</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <h3>Payments for <?php echo $today; ?></h3>
<table class="table table-striped">
    <thead>
        <th>Customer Name</th>
        <th>Customer ID</th>
        <th>Amount To Pay</th>
        <th>Amount Left</th>
        <th>Action</th>
    </thead>
    <tbody>
    <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $name = $row['customer_name'];
            $customerId = $row['customer_id'];
            $amountPaid = $row['amount_paid'];
            $recieptNumber = $row['reciept_number'];
            $date = $row['date'];
            $nextPayment = $row['next_payment'];
            $amountLeft = $row['amount_left'];

    $Id = substr($customerId, 12, strpos($customerId, '/'));
    $Id = str_replace('/', '', $Id);

    $q = "SELECT installment_amount FROM active_loans WHERE customer_id = '$customerId' ORDER BY id DESC";
    $q = mysqli_query($connect, $q);
    $installment = mysqli_fetch_array($q);
    $installmentAmount = $installment['installment_amount'];
    ?>
    <tr>
        <td><?php echo $name; ?></td>
        <td><a href="customer_profile.php?id=<?php echo $customerId; ?>"><?php echo $customerId; ?></a></td>
        <td><?php echo $installmentAmount; ?></td>
        <td><?php echo $amountLeft; ?></td>
        <td><a href="make_payment.php?id=<?php echo $customerId; ?>"><button class="btn btn-success">Make Payment</button></a></td>
    </tr>
    <?php } ?>
</tbody>
</table>
</div>
</body>
</html>