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
}
else{
	header("Location: login.php");
}
if (isset($_GET['id'])) {
    $cusID = $_GET['id'];
    if (isset($_POST['fine'])) {
        if (!$_POST['fine_amount']) {
            echo "<script>alert('Fine Amount Required');</script>";
        }else{
            $getDetails = "SELECT * FROM deliquence WHERE customer_id = '$cusID'";
            $getDetails = mysqli_query($connect, $getDetails);
            while ($details = mysqli_fetch_array($getDetails)) {
                $name = $details['customer_name'];
                $amountLeft = $details['amount_left'];
                $paymentsSkipped = $details['payments_skipped'];
                $phone = '+255'.$details['phone_number'];
            }
            $fineAmount = $_POST['fine_amount'];
            $date = date("Y-m-d", strtotime('today'));
            $insert = "INSERT INTO fines VALUES ('', '$name','$cusID', '$fineAmount', '$date')";
            if (mysqli_query($connect, $insert)) {
                //add the fine to loan amount in active loan then do what's below
                $income = "INSERT INTO incomes VALUES ('', 'FINE','$cusID', '$fineAmount', '$date')";
                if (mysqli_query($connect, $income)) {
                    header('Location: customer_profile.php?id='.$cusID);
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
    header("Location: deliquence.php");
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
    <title>Fine</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <?php
        $getDetails = "SELECT * FROM deliquence WHERE customer_id = '$cusID'";
        $getDetails = mysqli_query($connect, $getDetails);
        while ($details = mysqli_fetch_array($getDetails)) {
            $name = $details['customer_name'];
            $amountLeft = $details['amount_left'];
            $paymentsSkipped = $details['payments_skipped'];
            $phone = '+255'.$details['phone_number'];
        }
    ?>
    <form method="post">
        <h4>Customer Name: <?php echo $name; ?></h4>
        <h4>Phone Number: <?php echo $phone; ?></h4>
        <h4>Payments Skipped: <?php echo $paymentsSkipped; ?></h4>
        <label for="fine_amount">Fine Amount</label>
        <input type="number" name="fine_amount" class="form-control" placeholder="Fine Amount"><br>
        <button type="submit" name="fine" class="btn btn-sm btn btn-success">Issue Fine</button>
    </form>

    </div>
</body>
</html>