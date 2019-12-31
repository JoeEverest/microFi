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

if (isset($_GET['id'])) {
    $loanID = $_GET['id'];
    $retrieve = "SELECT * FROM payments WHERE loan_id = '$loanID' ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
}else{
    header('Location: customers.php');
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
    <title>Payment History</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <h4>Loan ID: <u><?php echo $loanID; ?></u></h4><br>
<table class="table table-striped table-sm">
    <thead>
        <th>Customer Name</th>
        <th>Customer ID</th>
        <th>Amount Paid</th>
        <th>Reciept Number</th>
        <th>Date</th>
        <th>Next Payment</th>
        <th>Amount Left</th>
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
    ?>
    <tr>
        <td><?php echo $name; ?></td>
        <td><a href="customer_profile.php?id=<?php echo $Id; ?>"><?php echo $customerId; ?></a></td>
        <td><?php echo $amountPaid; ?></td>
        <td><?php echo $recieptNumber; ?></td>
        <td><?php echo $date; ?></td>
        <td><?php echo $nextPayment; ?></td>
        <td><?php echo $amountLeft; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
</div>
</body>
</html>