<?php
session_start();
include('config/config.php');

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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $retrieve = "SELECT * FROM customers WHERE unique_id = '$id' ORDER BY id DESC";
    $retrieve = mysqli_query($connect, $retrieve);
} else {
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
    <?php include('css.php'); ?>
    <title>Customer Profile</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <?php
                echo "<script> alert ('Customer ID: " . $id . "'); </script>";

                while ($row = mysqli_fetch_array($retrieve)) {
                    $id = $row['id'];
                    $name = $row['customer_name'];
                    $businessTitle = $row['business_title'];
                    $groupName = $row['group_name'];
                    $customerId = $row['unique_id'];
                    $age = $row['dob'];
                    $registrationDate = $row['registration_date'];
                    $phoneNumber = $row['phone_number'];
                    $branchName = $row['branch_name'];
                    $centerName = $row['center_name'];


                    // $branchID = substr($customerId, 0, strpos($customerId, '/'));
                    //     $getBranchName = "SELECT branch_name FROM branches WHERE branch_id = '$branchID'";
                    //     $getBranchName = mysqli_query($connect, $getBranchName);
                    //     $branchName = mysqli_fetch_array($getBranchName);
                    //     $branchName = implode(', ', $branchName);
                    //     $branchName = substr($branchName, 0, strpos($branchName, ','));

                    // $centerId = substr($customerId, 5, strpos($customerId, '/'));
                    // $centerId = str_replace('/', '', $centerId);
                    //     $getCenterName = "SELECT center_name FROM centers WHERE center_id = '$centerId'";
                    //     $getCenterName = mysqli_query($connect, $getCenterName);
                    //     $centerName = mysqli_fetch_array($getCenterName);
                    //     $centerName = implode(', ', $centerName);
                    //     $centerName = substr($centerName, 0, strpos($centerName, ','));    

                    $customerId = str_replace(' ', '', $customerId);
                ?>
                    <div class="card-header">
                        <h3 class="card-header-title">Customer Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-0">
                            <table class="table table-sm table-nowrap card-table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h3>Customer ID</h3>
                                        </td>
                                        <td><?php echo $customerId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Customer Name</h3>
                                        </td>
                                        <td><?php echo $name; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Business Title</h3>
                                        </td>
                                        <td><?php echo urldecode($businessTitle); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Phone Number</h3>
                                        </td>
                                        <td><?php echo '+255' . $phoneNumber; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Branch Name</h3>
                                        </td>
                                        <td><?php echo $branchName; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Center Name</h3>
                                        </td>
                                        <td><?php echo $centerName; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Group Name</h3>
                                        </td>
                                        <td><?php echo $groupName; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>DoB</h3>
                                        </td>
                                        <td><?php echo $age; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3>Registration Date</h3>
                                        </td>
                                        <td><?php echo $registrationDate; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>