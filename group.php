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
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $retrieve = "SELECT * FROM customers WHERE id = '$id' ORDER BY id DESC";
        $retrieve = mysqli_query($connect, $retrieve);
    }else{
        header('Location: index.php');
    }
    $extract = "SELECT * FROM groups WHERE group_id = '$id' ORDER BY id DESC";
            $execute = mysqli_query($connect, $extract);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $id = $dataRows["id"];
                $name = $dataRows["group_name"];
                $centername = $dataRows["center_name"];
                $groupId = $dataRows["group_id"];    
            }
    ?>
    <title><?php echo $name; ?></title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <p>Group Name: <?php echo $name; ?></p>
    <table class="table table-striped table-sm">
        <thead>
            <th>Customer Name</th>
            <th>Business Name</th>
            <th>Customer ID</th>
            <th>Registration Date</th>
            <th>Phone Number</th>
        </thead>
        <tbody>
        <?php
        $extract = "SELECT * FROM customers WHERE group_name = '$name' ORDER BY id DESC";
        $execute = mysqli_query($connect, $extract);
                while ($dataRows = mysqli_fetch_array($execute)) {
                    $id = $dataRows["id"];
                    $customerName = $dataRows["customer_name"];
                    $businessTitle = $dataRows["business_title"];
                    $groupName = $dataRows["group_name"];
                    $customer_id = $dataRows["unique_id"];
                    $age = $dataRows["dob"];
                    $date = $dataRows["registration_date"];
                    $phone = $dataRows["phone_number"];
        $check_database_query = mysqli_query($connect, "SELECT * FROM groups WHERE center_name = '$centername'");
        $check_login_query = mysqli_num_rows($check_database_query);
        $numberOfGroups = $check_login_query;
        ?>
            <tr>
                <td><?php echo $customerName; ?></td>
                <td><?php echo $businessTitle; ?></td>
                <td><a href="customer_profile.php?id=<?php echo $customer_id; ?>"><?php echo $customer_id; ?></a></td>
                <td><?php echo $date; ?></td>
                <td><?php echo '+255'.$phone; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div></body>
</html>