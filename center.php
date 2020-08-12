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
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <?php include('css.php'); ?>
    <?php
    $id = $_GET['id'];
    $extract = "SELECT * FROM centers WHERE center_id = '$id' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $id = $dataRows['id'];
        $branchname = $dataRows['branch_name'];
        $centername = $dataRows['center_name'];
        $centerId = $dataRows['center_id'];
    }
    ?>
    <title><?php echo $centername; ?></title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <p><?php echo $centername; ?></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
                            <thead class="thead-dark">
                                <th>Group Name</th>
                                <th>Group ID</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $extract = "SELECT * FROM groups WHERE center_name = '$centername' ORDER BY id DESC";
                                $execute = mysqli_query($connect, $extract);
                                while ($dataRows = mysqli_fetch_array($execute)) {
                                    $id = $dataRows["id"];
                                    $groupname = $dataRows["group_name"];
                                    $centername = $dataRows["center_name"];
                                    $groupId = $dataRows["group_id"];
                                    $check_database_query = mysqli_query($connect, "SELECT * FROM customers WHERE group_name = '$groupname'");
                                    $check_login_query = mysqli_num_rows($check_database_query);
                                    $numberOfMembers = $check_login_query;

                                ?>
                                    <tr>
                                        <td><?php echo $groupname; ?></td>
                                        <td><?php echo $groupId; ?></td>
                                        <td><a href="group.php?id=<?php echo $groupId; ?>"><button class="btn btn-sm btn-success">View Group</button></a></td>
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