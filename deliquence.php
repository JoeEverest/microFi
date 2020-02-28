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
    $retrieve = "SELECT * FROM deliquence ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
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
    <title>Deliquence</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <table class="table table-striped table-sm">
        <thead>
            <th>Customer Name</th>
            <th>Customer ID</th>
            <th>Amount Left</th>
            <th>Payments Skipped</th>
            <th>Phone Number</th>
            <th>Action</th>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $name = $row['customer_name'];
            $customerId = $row['customer_id'];
            $amountLeft = $row['amount_left'];
            $paymentsSkipped = $row['payments_skipped'];
            
            $rt = "SELECT * FROM customers WHERE unique_id = '$customerId' ORDER BY id DESC";
            $rt = mysqli_query($connect, $rt);
            while ($rw = mysqli_fetch_array($rt)) {
                $phoneNumber = $rw['phone_number'];
            }
        ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $customerId; ?></td>
            <td><?php echo $amountLeft; ?></td>
            <td><?php echo $paymentsSkipped; ?></td>
            <td><?php echo '+255'.$phoneNumber; ?></td>
            <td><a href="fine.php?id=<?php echo $customerId; ?>"><button class="btn btn-sm btn btn-danger">Fine</button></a></td>
        </tr>
        <?php } ?>
    </table>
</div></body>
</html>