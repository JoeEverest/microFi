<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $getCenter = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn'";
    $getCenter = mysqli_query($connect, $getCenter);
    while ($centerName = mysqli_fetch_array($getCenter)) {
        $centerDetails = $centerName['center_name'];
        $cname = explode("_", $centerDetails);
        $center__name = $cname[0];
        $branch__name = $cname[1];
    }
} else {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('css.php'); ?>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $retrieve = "SELECT * FROM customers WHERE id = '$id' ORDER BY id DESC";
        $retrieve = mysqli_query($connect, $retrieve);
    } else {
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
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Group Name: <?php echo $name; ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
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
                                        <td><?php echo '+255' . $phone; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>