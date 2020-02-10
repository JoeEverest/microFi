<?php
session_start();

include('alt_session.php');
include('config/config.php');
include('date.php');

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

$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
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
    <title>All Branches</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <table class="table table-striped table-sm">
        <thead>
            <th>Branch Name</th>
            <th>Branch ID</th>
            <th>Action</th>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $id = $row['id'];
            $name = $row['branch_name'];
            $uniqueId = $row['branch_id'];
        ?>
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $uniqueId; ?></td>
            <td><a href="branch.php?id=<?php echo $id; ?>"><button class="btn btn-sm btn btn-success">View Branch</button></a></td>
        </tr>
        <?php } ?>
    </table>
</div></body>
</html>