<?php
session_start();

include('alt_session.php');
include('config/config.php');

$retrieve = 'SELECT * FROM active_loans WHERE amount_toPay != 0 ORDER BY id DESC';
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
    <title>Active Loans</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <table class="table table-striped">
        <thead>
            <th>Customer Name</th>
            <th>Customer ID</th>
            <th>Business Title</th>
            <th>Loan Amount</th>
            <th>Amount To Pay</th>
            <th>Installemnt Amount</th>
            <th>Disbursement Date</th>
            <th>Maturity Date</th>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            $uniqueId = $row['customer_id'];
            $businessTitle = $row['business_title'];
            $loanAmount = $row['loan_amount'];
            $totalAmount = $row['amount_toPay'];
            $installAmount = $row['installment_amount'];
            $disbursementDate = $row['disbursment_date'];
            $maturityDate = $row['maturity_date'];
        ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><a href="customer_profile.php?id=<?php echo $id; ?>"><?php echo $uniqueId; ?></a></td>
            <td><?php echo $businessTitle; ?></td>
            <td><?php echo $loanAmount; ?></td>
            <td><?php echo $totalAmount; ?></td>
            <td><?php echo $installAmount; ?></td>
            <td><?php echo $disbursementDate; ?></td>
            <td><?php echo $maturityDate; ?></td>
        </tr>
        <?php } ?>
    </table>
</div></body>
</html>