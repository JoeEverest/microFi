<?php
session_start();
include('config/config.php');
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
        while ($details = mysqli_fetch_array($getDetails)){
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
            }else {
                $disbursementDate = $_POST['disbursement_date'];
                
                $nextday = date('Y-m-d', strtotime('+1 day', strtotime($disbursementDate)));
                $sunday = date('Y-m-d', strtotime('sunday'));

                $due_date = date('Y-m-d', strtotime('+35 days', strtotime($disbursementDate)));

                //if ($nextday != $sunday | date stuff) {
                if ($nextday != $sunday){
                    $nextPayment = date('Y-m-d', strtotime('+1 day', strtotime($disbursementDate)));
                }else {
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
                        }else {
                            $error = mysqli_error($connect);
                            echo 'There was an error '.$error;
                        }
                    }else {
                        $error = mysqli_error($connect);
                        echo 'There was an error '.$error;
                    }
                }else {
                    $error = mysqli_error($connect);
                    echo 'There was an error '.$error;
                }
            }
        }

        
    }else {
        header("Location: pending_loans.php");
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
    <title>Pending Loans</title>
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="container">
<h4>Loan ID: <?php echo $loanID; ?></h4>
    <form method="post">
        <ul>
            <li><b>Customer Name:</b><?php echo $customerName; ?></li>
            <li><b>Customer ID:</b><?php echo $loanID; ?></li>
            <li><b>Loan Amount:</b><?php echo $loanAmount; ?></li>
            <li><b>Amount Due:</b><?php echo $amountDue; ?></li>
            <li><b>Installmemt Amount:</b><?php echo $installAmount; ?></li>
            <li><b>Status:</b><?php echo $status; ?></li>
        </ul>
        <label for="disbursement_date">Disbursement Date:</label>
        <input required type="date" name="disbursement_date" class="form-control"><br>
        <button type="submit" class="btn btn-success" name="approve">Approve Loan</button>
    </form>
</div>
</body>
</html>