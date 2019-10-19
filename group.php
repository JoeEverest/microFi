<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
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
    <title>Document</title>
</head>
<body><div class="container">
    <?php
    $id = $_GET['id'];
    $extract = "SELECT * FROM groups WHERE id = '$id' ORDER BY id DESC";
            $execute = mysqli_query($connect, $extract);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $id = $dataRows["id"];
                $name = $dataRows["group_name"];
                $centername = $dataRows["center_name"];
                $groupId = $dataRows["group_id"];    
    ?>
    <p>Group Name: <?php echo $name; ?></p>
    <?php } ?>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Business Name</th>
            <th>Customer ID</th>
            <th>Registration Date</th>
            <th>Phone Number</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php
        $name = ' '.$name;
        $extract = "SELECT * FROM customers WHERE group_name = '$name' ORDER BY id DESC";
        $execute = mysqli_query($connect, $extract);
                while ($dataRows = mysqli_fetch_array($execute)) {
                    $id = $dataRows["id"];
                    $customerName = $dataRows["customer_name"];
                    $businessTitle = $dataRows["business_title"];
                    $groupName = $dataRows["group_name"];
                    $customer_id = $dataRows["unique_id"];
                    $age = $dataRows["age"];
                    $date = $dataRows["registration_date"];
                    $phone = $dataRows["phone_number"];
        $check_database_query = mysqli_query($connect, "SELECT * FROM groups WHERE center_name = '$centername'");
        $check_login_query = mysqli_num_rows($check_database_query);
        $numberOfGroups = $check_login_query;
        ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $customerName; ?></td>
                <td><?php echo $businessTitle; ?></td>
                <td><?php echo $customer_id; ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo '+255'.$phone; ?></td>
                <td><a href="payment_history.php?id=<?php echo $id; ?>"><button class="btn btn-primary">View Payment History</button></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div></body>
</html>