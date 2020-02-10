<?php
session_start();
include('config/config.php');
include('date.php');
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
echo $centerName;
$retrieve = "SELECT * FROM customers WHERE center_name = '$center__name' ORDER BY id DESC";
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
    <title>Customers</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">

        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" href="active_loans.php">Active Customers</a>
            </li>
        </ul>

    <table class="table table-striped table-sm">
        <thead>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Business Title</th>
            <th>Phone Number</th>
            <th>Branch Name</th>
            <th>Center Name</th>
            <th>Group Name</th>
            <th>Age</th>
            <th>Registration Date</th>
        </thead>
        <tbody>
    <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            $businessTitle = $row['business_title'];
            $groupName = $row['group_name'];
            $customerId = $row['unique_id'];
            $age = $row['dob'];
            $dob = date('Y', strtotime($age));
            $today = date('Y', strtotime('Today'));
            $age = $today - $dob;
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
    <tr>
    <td><a href="customer_profile.php?id=<?php echo $row['unique_id']; ?>"><?php echo $row['unique_id']; ?></a></td>
    <td><?php echo $name; ?></td>
    <td><?php echo $businessTitle; ?></td>
    <td><?php echo '+255'.$phoneNumber; ?></td>
    <td><?php echo $branchName; ?></td>
    <td><?php echo $centerName; ?></td>
    <td><?php echo $groupName; ?></td>
    <td><?php echo $age; ?></td>
    <td><?php echo $registrationDate; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
</div></body>
</html>

