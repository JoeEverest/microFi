<?php
session_start();

include('alt_session.php');
include('config/config.php');

$retrieve = 'SELECT * FROM active_loans WHERE amount_toPay > 0 ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <?php include('css.php'); ?>
    <title>Active Loans</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" href="active_loans.php">Active Loans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inactive_loans.php">Inactive Loans</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                                <th>Loan ID</th>
                                <th>Customer Name</th>
                                <th>Customer ID</th>
                                <th>Loan Amount</th>
                                <th>Amount Left</th>
                                <th>Installemnt Amount</th>
                                <th>Disbursement Date</th>
                                <th>Maturity Date</th>
                                <th>Action</th>
                            </thead>
                            <?php
                            while ($row = mysqli_fetch_array($retrieve)) {
                                $id = $row['id'];
                                $loanID = $row['loan_id'];
                                $name = $row['customer_name'];
                                $uniqueId = $row['customer_id'];
                                $loanAmount = $row['loan_amount'];
                                $installAmount = $row['installment_amount'];
                                $disbursementDate = $row['disbursment_date'];
                                $maturityDate = $row['maturity_date'];

                                $qr = "SELECT amount_left FROM `payments` WHERE customer_id = '$uniqueId' ORDER BY `id` DESC LIMIT 1";
                                $qr = mysqli_query($connect, $qr);
                                while ($row = mysqli_fetch_array($qr)) {
                                    $totalAmount = $row['amount_left'];
                                    $onetwenty = $intrest + 100;
                                    $totalAmount = $totalAmount * 100 / $onetwenty;
                                }
                            ?>
                                <tr>
                                    <td><?php echo $loanID; ?></td>
                                    <td><?php echo $name; ?></td>
                                    <td><a href="customer_profile.php?id=<?php echo $uniqueId; ?>"><?php echo $uniqueId; ?></a></td>
                                    <td><?php echo $loanAmount; ?></td>
                                    <td><?php echo round($totalAmount, 2); ?></td>
                                    <td><?php echo $installAmount; ?></td>
                                    <td><?php echo $disbursementDate; ?></td>
                                    <td><?php echo $maturityDate; ?></td>
                                    <td><a href="payment_history.php?id=<?php echo $loanID; ?>"><button class="btn btn-sm btn-success">View Payment History</button></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>