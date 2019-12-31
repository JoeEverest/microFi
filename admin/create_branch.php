<?php
include('session.php');
include('../config/config.php');

if (isset($_POST['createBranch'])) {
    if (!$_POST["branchName"]) {
        $error = 'All input fields are required';
    }else{
        $branchName = $_POST["branchName"];

        $brID = "SELECT * FROM branches ORDER BY id DESC";
        $brID = mysqli_query($connect, $brID);

        $branchId = mysqli_num_rows($brID);
        $branchId = $branchId + 1;
        $branchId = $branchId * 1000;

        $registerBranch = mysqli_query($connect, "INSERT INTO branches VALUES ('', '$branchName', '$branchId')");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <title>Create New Branch</title>
</head>
<body>
    <div class="container">
    <form action="" method="post">
        <h3>Create new Branch</h3>
        <label for="branchName">Branch Name</label>
        <input class="form-control" required type="text" name="branchName" placeholder="Branch Name">
        <!-- <label for="branchid">Branch ID</label> -->
        <!-- <input class="form-control" required type="number" name="branchId" placeholder="Branch ID">--><br> 
        <button class="btn btn-sm btn btn-success" type="submit" name="createBranch">Create Branch</button>
    </form>
</div></body>
</html>