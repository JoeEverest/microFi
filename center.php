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
    $extract = "SELECT * FROM centers WHERE id = '$id' ORDER BY id DESC";
            $execute = mysqli_query($connect, $extract);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $id = $dataRows['id'];
                $branchname = $dataRows['branch_name'];
                $centername = $dataRows['center_name'];
                $centerId = $dataRows['center_id'];
    
    ?>
    <p><?php echo $centername; ?></p>
    <?php } ?>
    <table class="table table-striped">
        <thead>
            <td>ID</td>
            <td>Group Name</td>
            <td>Group ID</td>
            <td>Action</td>
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
                <td><?php echo $id; ?></td>
                <td><?php echo $groupname; ?></td>
                <td><?php echo $groupId; ?></td>
                <td><a href="group.php?id=<?php echo $id; ?>"><button class="btn btn-primary">View Group</button></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div></body>
</html>