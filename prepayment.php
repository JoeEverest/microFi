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
    $getId = $_GET['id'];
} else {
    header('Location: active_loans.php');
}

$retrieve = "SELECT * FROM active_loans WHERE loan_id = '$getId' ORDER BY id DESC";
$retrieve = mysqli_query($connect, $retrieve);

if (isset($_POST['submit'])) {
    if (!$_POST['customer_name'] | !$_POST['customer_id'] | !$_POST['amount_paid'] | !$_POST['reciept']) {
        echo 'All input fields are required';
    } else {
        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            $uniqueId = $row['customer_id'];
            $businessTitle = $row['business_title'];
            $loanAmount = $row['loan_amount'];
            $loanID = $row['loan_id'];
            $installAmount = $row['installment_amount'];
            $disbursementDate = $row['disbursment_date'];
            $maturityDate = $row['maturity_date'];
        }
        $customerName = $_POST['customer_name'];
        $customerId = $_POST['customer_id'];
        $amountPaid = $_POST['amount_paid'];
        $reciept = $_POST['reciept'];

        $checkReciept = mysqli_query($connect, "SELECT reciept_number FROM payments WHERE reciept_number='$reciept'");
        $num_rows = mysqli_num_rows($checkReciept);

        if ($num_rows > 0) {
            echo "Payment Already Made";
        } else {

            $date = date('Y-m-d');
            $onetwenty = $intrest + 100;

            $principle = $amountPaid * 100 / $onetwenty;
            $interest = $amountPaid * $intrest / $onetwenty;

            $tomorrow = date('Y-m-d', strtotime('tomorrow'));
            $sunday = date('Y-m-d', strtotime('Sunday'));
            if ($tomorrow == $sunday) {
                $nextPayment = date('Y-m-d', strtotime('Monday'));
            } else {
                //check public holiday
                $nextPayment = date('Y-m-d', strtotime('tomorrow'));
            }

            $getAmountLeft = "SELECT amount_left FROM payments WHERE loan_id = '$loanID' ORDER BY id DESC LIMIT 1";
            $getAmountLeft = mysqli_query($connect, $getAmountLeft);

            $num_rows = mysqli_num_rows($getAmountLeft);
            $gal = "SELECT amount_left FROM payments WHERE loan_id = '$loanID' ORDER BY id DESC LIMIT 1";
            $gal = mysqli_query($connect, $gal);
            while ($rew = mysqli_fetch_array($gal)) {
                $totalAmount = $rew['amount_left'];
            }
            // if ($num_rows > 0) {
            //     while ($row = mysqli_fetch_array($getAmountLeft)) {
            //         $amountLeft = $row['amount_left'];
            //         $amountLeft = $amountLeft - $amountPaid;
            //     }
            // }else {
            $amountLeft = $totalAmount - $amountPaid;
            // }
            $getPaymentsLeft = "SELECT payments_left FROM payments WHERE loan_id = '$loanID' ORDER BY id DESC LIMIT 1";
            $getPaymentsLeft = mysqli_query($connect, $getPaymentsLeft);

            $num_rows = mysqli_num_rows($getPaymentsLeft);
            if ($num_rows > 0) {
                while ($row = mysqli_fetch_array($getPaymentsLeft)) {
                    $paymentsLeft = $row['payments_left'];
                    $paymentsLeft = $paymentsLeft - 1;
                }
            } else {
                $paymentsLeft = 29;
            }
            $amount_left = $totalAmount - $amountPaid;

            $query = "INSERT INTO payments VALUES ('', '$loanID', '$customerName','$uniqueId', '$amountPaid', '$reciept', '$date', '$principle', '$interest', '0', '$amount_left', '0', '$userLoggedIn')";

            if (mysqli_query($connect, $query)) {
                echo $amount_left;
                $removeActive = "UPDATE `active_loans` SET `amount_toPay` = '$amount_left' WHERE `active_loans`.`loan_id` = '$getId'";
                if (mysqli_query($connect, $removeActive)) {
                    $incomes = "INSERT INTO incomes VALUES ('', 'INTEREST','$loanID','$customerId', '$interest', '$date')";
                    if (mysqli_query($connect, $incomes)) {
                        header('Location: customer_profile.php?id=' . $uniqueId);
                    } else {
                        echo mysqli_error($connect);
                        echo 'There was an error ' . $error;
                    }
                } else {
                    echo mysqli_error($connect);
                    echo 'There was an error ' . $error;
                }
            } else {
                echo mysqli_error($connect);
                echo 'There was an error ' . $error;
            }
        }
    }
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
    <title>Prepayment</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <h3>Prepayment</h3>
        <form method="post">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['customer_name'];
                $uniqueId = $row['loan_id'];
                $businessTitle = $row['business_title'];
                $loanAmount = $row['loan_amount'];
                $installAmount = $row['installment_amount'];
                $disbursementDate = $row['disbursment_date'];
                $maturityDate = $row['maturity_date'];

                $getAmountLeft = "SELECT amount_left FROM payments WHERE loan_id = '$uniqueId' ORDER BY id DESC LIMIT 1";
                $getAmountLeft = mysqli_query($connect, $getAmountLeft);
                while ($row = mysqli_fetch_array($getAmountLeft)) {
                    $totalAmount = $row['amount_left'];
                }
            ?>
                <label for="customer_name">Customer Name</label>
                <input readonly required type="text" class="form-control" name="customer_name" value="<?php echo $name; ?>" placeholder="Customer Name">
                <label for="customer_id">Customer ID</label>
                <input readonly required type="text" class="form-control" name="customer_id" value="<?php echo $uniqueId; ?>" placeholder="Customer ID">
                <label for="amount_paid">Amount Paid</label>
                <input required type="number" class="form-control" name="amount_paid" value="<?php echo $totalAmount; ?>" placeholder="Amount Paid">
                <label for="reciept">Reciept Number</label>
                <input required type="text" class="form-control" name="reciept" placeholder="Reciept Number">
            <?php } ?><br>
            <button class="btn btn btn-success" type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>