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
while ($row = mysqli_fetch_array($retrieve)) {
    $installAmount = $row['installment_amount'];
}

if (isset($_POST['submit'])) {
    if (!$_POST['customer_name'] | !$_POST['customer_id'] | !$_POST['amount_paid'] | !$_POST['reciept']) {
        echo 'All input fields are required';
    } else {

        $retrieve = "SELECT * FROM active_loans WHERE loan_id = '$getId' ORDER BY id DESC";
        $retrieve = mysqli_query($connect, $retrieve);

        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $loanID = $row['loan_id'];
            $name = $row['customer_name'];
            $uniqueId = $row['customer_id'];
            $businessTitle = $row['business_title'];
            $loanAmount = $row['loan_amount'];
            $totalAmount = $row['amount_toPay'];
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

            $getAmountLeft = "SELECT amount_left FROM payments WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
            $getAmountLeft = mysqli_query($connect, $getAmountLeft);

            $num_rows = mysqli_num_rows($getAmountLeft);
            if ($num_rows > 0) {
                while ($row = mysqli_fetch_array($getAmountLeft)) {
                    $amountLeft = $row['amount_left'];
                    $amountLeft = $amountLeft - $amountPaid;
                }
            } else {
                $amountLeft = $totalAmount - $amountPaid;
            }
            $getPaymentsLeft = "SELECT payments_left FROM payments WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
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
            $query = "INSERT INTO payments VALUES ('', '$loanID', '$customerName','$customerId', '$amountPaid', '$reciept', '$date', '$principle', '$interest', '$nextPayment', '$amountLeft', '$paymentsLeft', '$userLoggedIn')";
            $incomes = "INSERT INTO incomes VALUES ('', 'INTEREST','$loanID','$customerId', '$interest', '$date')";

            if ($amountPaid < $installAmount) {
                //$amountLeft = $installAmount - $amountPaid;
                $q = "SELECT * FROM deliquence WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
                $q = mysqli_query($connect, $q);
                $numDel = mysqli_fetch_array($q);
                $numDel = $numDel['payments_skipped'];
                $numDel = $numDel + 1;
                $q1 = "INSERT INTO deliquence VALUES ('', '$customerName', '$customerId', '$amountPaid', '$disbursementDate', '$maturityDate', '$numDel', '$phoneNumber')";
                if (mysqli_query($connect, $q1)) {
                } else {
                    echo mysqli_error($connect);
                    echo 'There was an error ' . $error;
                }
                if (mysqli_query($connect, $query)) {
                    if (mysqli_query($connect, $incomes)) {
                        header('Location: customer_profile.php?id=' . $customerId);
                    } else {
                        echo mysqli_error($connect);
                        echo 'There was an error ' . $error;
                    }
                } else {
                    echo mysqli_error($connect);
                    echo 'There was an error ' . $error;
                }
            } else {
                if (mysqli_query($connect, $query)) {
                    if (mysqli_query($connect, $incomes)) {
                        $updateActiveLoans = "UPDATE `active_loans` SET `amount_toPay` = '$amountLeft' WHERE `active_loans`.`loan_id` = '$loanID'";
                        if (mysqli_query($connect, $updateActiveLoans)) {
                            header('Location: customer_profile.php?id=' . $customerId);
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
    <title>Make a Payment</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <h3>Make a Payment</h3>
        <form method="post">
            <?php
            $retrieve = "SELECT * FROM active_loans WHERE loan_id = '$getId' ORDER BY id DESC";
            $retrieve = mysqli_query($connect, $retrieve);
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['customer_name'];
                $uniqueId = $row['customer_id'];
                $loanAmount = $row['loan_amount'];
                $totalAmount = $row['amount_toPay'];
                $installAmount = $row['installment_amount'];
                $disbursementDate = $row['disbursment_date'];
                $maturityDate = $row['maturity_date'];
            ?>
                <label for="customer_name">Customer Name</label>
                <input readonly required type="text" class="form-control" name="customer_name" value="<?php echo $name; ?>" placeholder="Customer Name">
                <label for="customer_id">Customer ID</label>
                <input readonly required type="text" class="form-control" name="customer_id" value="<?php echo $uniqueId; ?>" placeholder="Customer ID">
                <label for="amount_paid">Amount Paid</label>
                <input required type="number" class="form-control" name="amount_paid" value="<?php echo $installAmount; ?>" placeholder="Amount Paid">
                <label for="reciept">Reciept Number</label>
                <input required type="text" class="form-control" name="reciept" placeholder="Reciept Number">
            <?php } ?><br>
            <button class="btn btn btn-success" type="submit" name="submit">Submit</button>
        </form>
        <br>
        <a href="prepayment.php?id=<?php echo $getId; ?>"><button class="btn btn btn-dark">Prepayment</button></a>

    </div>
</body>

</html>