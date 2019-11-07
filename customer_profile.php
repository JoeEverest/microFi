<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $retrieve = "SELECT * FROM customers WHERE unique_id = '$id' ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
}else{
    header('Location: customers.php');
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
    <title>Customer Profile</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            $businessTitle = $row['business_title'];
            $groupName = $row['group_name'];
            $customerId = $row['unique_id'];
            $age = $row['age'];
            $registrationDate = $row['registration_date'];
            $phoneNumber = $row['phone_number'];

    $branchID = substr($customerId, 0, strpos($customerId, '/'));
        $getBranchName = "SELECT branch_name FROM branches WHERE branch_id = '$branchID'";
        $getBranchName = mysqli_query($connect, $getBranchName);
        $branchName = mysqli_fetch_array($getBranchName);
        $branchName = implode(', ', $branchName);
        $branchName = substr($branchName, 0, strpos($branchName, ','));

    $centerId = substr($customerId, 5, strpos($customerId, '/'));
    $centerId = str_replace('/', '', $centerId);
        $getCenterName = "SELECT center_name FROM centers WHERE center_id = '$centerId'";
        $getCenterName = mysqli_query($connect, $getCenterName);
        $centerName = mysqli_fetch_array($getCenterName);
        $centerName = implode(', ', $centerName);
        $centerName = substr($centerName, 0, strpos($centerName, ','));    
    
    $customerId = str_replace(' ', '', $customerId);
    ?>
    <h3>Customer Profile</h3>
    <p>Customer ID: <?php echo $customerId; ?></p>
    <p>Customer Name: <?php echo $name; ?></p>
    <p>Business Title: <?php echo $businessTitle; ?></p>
    <p>Phone Number: <?php echo '+255'.$phoneNumber; ?></p>
    <p>Branch Name: <?php echo $branchName; ?></p>
    <p>Center Name: <?php echo $centerName; ?></p>
    <p>Group Name: <?php echo $groupName; ?></p>
    <p>Age: <?php echo $age; ?></p>
    <p>Registration Date: <?php echo $registrationDate; ?></p>
    <p><a href="payment_history.php?id=<?php echo $row['unique_id'];; ?>"><button class="btn btn-success">View Payment History</button></a></p>
    <?php } ?>
</div></body>
</html>

