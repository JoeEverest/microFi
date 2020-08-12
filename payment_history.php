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

if (isset($_GET['id'])) {
    $loanID = $_GET['id'];
    $retrieve = "SELECT * FROM payments WHERE loan_id = '$loanID' ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
} else {
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
    <?php include('css.php'); ?>
    <title>Payment History</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Loan ID: <u><?php echo $loanID; ?></u></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
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
                                        <td><a href="customer_profile.php?id=<?php echo $customerId; ?>"><?php echo $customerId; ?></a></td>
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>