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
    $getId = $_GET['id'];
}else {
    header('Location: active_loans.php');
}

$retrieve = "SELECT * FROM active_loans WHERE customer_id = '$getId' ORDER BY id DESC";
$retrieve = mysqli_query($connect, $retrieve);
while ($row = mysqli_fetch_array($retrieve)) {
    $installAmount = $row['installment_amount'];
}

if (isset($_POST['submit'])) {
    if (!$_POST['customer_name'] | !$_POST['customer_id'] | !$_POST['amount_paid'] | !$_POST['reciept']) {
        echo 'All input fields are required';
    }else {

        $retrieve = "SELECT * FROM active_loans WHERE customer_id = '$getId' ORDER BY id DESC";
        $retrieve = mysqli_query($connect, $retrieve);

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
        }
        
        $customerName = $_POST['customer_name'];
        $customerId = $_POST['customer_id'];
        $amountPaid = $_POST['amount_paid'];
        $reciept = $_POST['reciept'];

        $checkReciept = mysqli_query($connect, "SELECT reciept_number FROM payments WHERE reciept_number='$reciept'");
        $num_rows = mysqli_num_rows($checkReciept);

        if ($num_rows > 0) {
            echo "Payment Already Made";
        }else {

        $date = date('Y-m-d');
        $onetwenty = $intrest + 100;
        $principle = $amountPaid * 100/$onetwenty;
        $interest = $amountPaid * $intrest/$onetwenty;

        $tomorrow = date('Y-m-d', strtotime('tomorrow'));
        $sunday = date('Y-m-d', strtotime('Sunday'));
        if ($tomorrow == $sunday) {
            $nextPayment = date('Y-m-d', strtotime('Monday'));    
        }else {
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
        }else {
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
        }else {
            $paymentsLeft = 29;
        }
        $query = "INSERT INTO payments VALUES ('', '$customerName','$customerId', '$amountPaid', '$reciept', '$date', '$principle', '$interest', '$nextPayment', '$amountLeft', '$paymentsLeft', '$userLoggedIn')";
        
        if ($amountPaid < $installAmount) {
            $amountLeft = $installAmount - $amountPaid;
            $q1 = "INSERT INTO deliquence VALUES ('', '$customerName', '$customerId', '$amountPaid', '$disbursementDate', '$maturityDate', '$amountLeft', '$phoneNumber')";
            if (mysqli_query($connect, $q1)) {
            }else {
                echo mysqli_error($connect);
                echo 'There was an error '.$error;
            }
            if (mysqli_query($connect, $query)) {
                header('Location: customer_profile.php?id='.$getId);
            }else {
                echo mysqli_error($connect);
                echo 'There was an error '.$error;
            }
        }else {
            if (mysqli_query($connect, $query)) {
                header('Location: customer_profile.php?id='.$getId);
            }else {
                echo mysqli_error($connect);
                echo 'There was an error '.$error;
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
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Make a Payment</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <h3>Make a Payment</h3>
    <form method="post">
    <?php
    $retrieve = "SELECT * FROM active_loans WHERE customer_id = '$getId' ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
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
    <label for="customer_name">Customer Name</label>
    <input readonly required type="text" class="form-control" name="customer_name" value="<?php echo $name; ?>" placeholder="Customer Name">
    <label for="customer_id">Customer ID</label>
    <input readonly required type="text" class="form-control" name="customer_id" value="<?php echo $uniqueId; ?>" placeholder="Customer ID">
    <label for="amount_paid">Amount Paid</label>
    <input required type="number" class="form-control" name="amount_paid" value="<?php echo $installAmount; ?>" placeholder="Amount Paid">
    <label for="reciept">Reciept Number</label>
    <input required type="text" class="form-control" name="reciept" placeholder="Reciept Number">
    <?php } ?><br>
    <button class="btn btn-success" type="submit" name="submit">Submit</button>
    </form>
    <br>
    <a href="prepayment.php?id=<?php echo $getId; ?>"><button class="btn btn-dark">Prepayment</button></a>

</div></body>
</html>