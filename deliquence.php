<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

$today = date('Y-m-d');
$sunday = date('Y-m-d', strtotime('Sunday'));
$yesterday = date('Y-m-d', strtotime('Yesterday'));
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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <th>Customer Name</th>
                <th>Customer ID</th>
                <th>Payments Missed</th>
                <th>Amount Due</th>
                <th>Payments Left</th>
                <th>Action</th>
            </thead>
            <tbody>
<?php
// if today is not sunday or public holidays
if ($today != $sunday) {
    $getPaymentsYesterday = "SELECT * FROM payments WHERE next_payment = '$yesterday' AND amount_left > 0 ORDER BY id DESC";
    $getPaymentsYesterday = mysqli_query($connect, $getPaymentsYesterday);

    while ($row = mysqli_fetch_array($getPaymentsYesterday)) {
        $idYesterday = $row['customer_id'];
        // $name = $row['customer_name'];
        // $amountLeft = $row['amount_left'];
        // $paymentsLeft = $row['payments_left'];

        $getPaymentsToday = "SELECT * FROM payments WHERE next_payment = '$today' AND customer_id != '$idYesterday' ORDER BY id DESC";
        $getPaymentsToday = mysqli_query($connect, $getPaymentsToday);

        while ($data = mysqli_fetch_array($getPaymentsToday)) {
            $idToday = $data['customer_id'];
            $name = $data['customer_name'];
            $amountLeft = $data['amount_left'];
            $paymentsLeft = $data['payments_left'];

            ?>
            <td><?php echo $name; ?></td>
            <td><a href="customer_profile.php?id=<?php echo $idToday; ?>"><?php echo $idToday; ?></a></td>
            <td><?php //echo paymentsMissed ?></td>
            <td><?php echo $amountLeft; ?></td>
            <td><?php echo $paymentsLeft; ?></td>
            <td><a href="#"><button class="btn btn-success">Action</button></a></td>
            <?php
        }
    }

}
?>
            </tbody>
        </table>
    </div>
</body>
</html>