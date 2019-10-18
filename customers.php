<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

$retrieve = "SELECT * FROM customers ORDER BY id DESC";
$retrieve = mysqli_query($connect, $retrieve);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border='1'>
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
    <tr>
    <td><?php echo $customerId; ?></td>
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
</body>
</html>

