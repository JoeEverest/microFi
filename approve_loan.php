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

    $extract = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $rank = $dataRows["rank"];
        if ($rank != 'AUTHORIZER') {
            header("Location: index.php");
        }
    }


    if (isset($_GET['reqID'])) {
        $requestID = $_GET['reqID'];

        $getDetails = "SELECT * FROM pending_loans WHERE id = '$requestID'";
        $getDetails = mysqli_query($connect, $getDetails);
        while ($details = mysqli_fetch_array($getDetails)) {
            $loanID = $details['loan_id'];
            $customerName = $details['customer_name'];
            $customerID = $details['customer_id'];
            $loanAmount = $details['loan_amount'];
            $amountDue = $details['amount_due'];
            $installAmount = $details['installment_amount'];
            $status = $details['status'];
        }

        if (isset($_POST['approve'])) {
            if (!$_POST['disbursement_date']) {
                echo "<script>alert('Disbursement Date required');</script>";
            } else {
                $disbursementDate = $_POST['disbursement_date'];

                $nextday = date('Y-m-d', strtotime('+1 day', strtotime($disbursementDate)));
                $sunday = date('Y-m-d', strtotime('sunday'));

                $due_date = date('Y-m-d', strtotime('+35 days', strtotime($disbursementDate)));

                //if ($nextday != $sunday | date stuff) {
                if ($nextday != $sunday) {
                    $nextPayment = date('Y-m-d', strtotime('+1 day', strtotime($disbursementDate)));
                } else {
                    $nextPayment = date('Y-m-d', strtotime('+2 days', strtotime($disbursementDate)));
                }

                $query = "INSERT INTO active_loans VALUES ('', '$loanID', '$customerName','$customerID', '$loanAmount', '$amountDue', '$installAmount', '$disbursementDate', '$due_date')";

                if (mysqli_query($connect, $query)) {
                    $qu = "INSERT INTO payments VALUES ('', '$loanID', '$customerName','$customerID', '0', 'NEW LOAN', '$disbursementDate', '0', '0', '$nextPayment', '$amountDue', '30', '$userLoggedIn')";
                    if (mysqli_query($connect, $qu)) {
                        $today = date("Y-m-d", strtotime('today'));
                        $statusUpdate = "UPDATE `pending_loans` SET `status` = 'APPROVED' WHERE `pending_loans`.`id` = '$requestID';";
                        if (mysqli_query($connect, $statusUpdate)) {
                            header('Location: pending_loans.php');
                        } else {
                            $error = mysqli_error($connect);
                            echo 'There was an error ' . $error;
                        }
                    } else {
                        $error = mysqli_error($connect);
                        echo 'There was an error ' . $error;
                    }
                } else {
                    $error = mysqli_error($connect);
                    echo 'There was an error ' . $error;
                }
            }
        }
    } else {
        header("Location: pending_loans.php");
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
    <title>Pending Loans</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Loan ID: <?php echo $loanID; ?></h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="table-responsive mb-0">
                            <table class="table table-sm table-nowrap card-table">
                                <tbody>
                                    <tr>
                                        <td>Customer Name:</td>
                                        <td><?php echo $customerName; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Customer ID:</td>
                                        <td><?php echo $loanID; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Loan Amount:</td>
                                        <td><?php echo $loanAmount; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Due:</td>
                                        <td><?php echo $amountDue; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Installmemt Amount:</td>
                                        <td><?php echo $installAmount; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td><?php echo $status; ?></td>
                                    </tr>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <label for="disbursement_date">Disbursement Date:</label>
                        <input required type="date" name="disbursement_date" class="form-control"><br>
                        <button type="submit" class="btn btn-success" name="approve">Approve Loan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>