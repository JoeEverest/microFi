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

        $getCenterID = "SELECT center_id FROM centers WHERE center_name = '$center__name'";
        $getCenterID = mysqli_query($connect, $getCenterID);
        $centerID = mysqli_fetch_array($getCenterID);
        $centerID = $centerID["center_id"];
    }
} else {
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
    <?php include('css.php'); ?>
    <title>All Payments</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-header-title">Payments for Today. Date: <u><?php echo $today; ?></u></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
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
                                    $loanID = $row['loan_id'];
                                    $customerId = $row['customer_id'];
                                    $amountPaid = $row['amount_paid'];
                                    $recieptNumber = $row['reciept_number'];
                                    $date = $row['date'];
                                    $nextPayment = $row['next_payment'];
                                    $amountLeft = $row['amount_left'];

                                    $customerData = explode("/", $customerId);

                                    $customerCenter = $customerData[1];

                                    if ($centerID == $customerCenter) {


                                        $q = "SELECT installment_amount FROM active_loans WHERE loan_id = '$loanID' ORDER BY id DESC";
                                        $q = mysqli_query($connect, $q);
                                        $installment = mysqli_fetch_array($q);
                                        $installmentAmount = $installment['installment_amount'];
                                ?>
                                        <tr>
                                            <td><?php echo $name; ?></td>
                                            <td><a href="customer_profile.php?id=<?php echo $customerId; ?>"><?php echo $customerId; ?></a></td>
                                            <td><?php echo $installmentAmount; ?></td>
                                            <td><?php echo $amountLeft; ?></td>
                                            <td><a href="make_payment.php?id=<?php echo $loanID; ?>"><button class="btn btn-sm btn-success">Make Payment</button></a></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>