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
            $loanID
            $customerName
            $customerID
            $loanAmount
            $amountDue
            $installAmount
            $status
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
    
</div>
</body>
</html>