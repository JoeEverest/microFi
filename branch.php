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
        $centerName = $cname[0];
        $branchName = $cname[1];
    }
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
    }else {
        header('Location: branches.php');
    }   
    
    $extract = "SELECT * FROM branches WHERE id = '$id' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $id = $dataRows["id"];
        $name = $dataRows["branch_name"];
        $uniqueId = $dataRows["branch_id"];
    }
    ?>
    <title><?php echo $name; ?></title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <h3>Branch Name: <?php echo $name; ?></h3>
    <table class="table table-striped table-sm">
        <thead>
            <th>Center Name</th>
            <th>Center ID</th>
            <th>Number of Groups</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php
        $extract = "SELECT * FROM centers WHERE branch_name = '$name' ORDER BY id DESC";
        $execute = mysqli_query($connect, $extract);
                while ($dataRows = mysqli_fetch_array($execute)) {
                    $id = $dataRows["id"];
                    $branchName = $dataRows["branch_name"];
                    $centername = $dataRows["center_name"];
                    $centerId = $dataRows["center_id"];
        $check_database_query = mysqli_query($connect, "SELECT * FROM groups WHERE center_name = '$centername'");
        $check_login_query = mysqli_num_rows($check_database_query);
        $numberOfGroups = $check_login_query;
        ?>
            <tr>
                <td><?php echo $centername; ?></td>
                <td><?php echo $centerId; ?></td>
                <td><?php echo $numberOfGroups; ?></td>
                <td><a href="center.php?id=<?php echo $centerId; ?>"><button class="btn btn-sm btn btn-success">View Center</button></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div></body>
</html>