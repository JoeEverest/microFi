<?php
include('session.php');
include('../config/config.php');

if (isset($_POST['createBranch'])) {
    if (!$_POST["branchName"] | !$_POST['branchId']) {
        $error = 'All input fields are required';
    }else{
        $branchName = $_POST["branchName"];
        $branchId = $_POST['branchId'];

        $registerBranch = mysqli_query($connect, "INSERT INTO branches VALUES ('', '$branchName', '$branchId')");


        // $query = "INSERT INTO movies VALUES ('', $branchName, $branchId)";
        
        // if (mysqli_query($connect, $query)) {
        //     echo '<script>alert("Branch added into database");</script>';
        // }else {
        //     echo '<script>alert("Something went wrong");</script>';            
        // }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Branch</title>
</head>
<body><div class="container">
    <p>Create new branch</p>
    <form action="" method="post">
        <input class="form-control" required type="text" name="branchName" placeholder="Branch Name">
        <input class="form-control" required type="number" name="branchId" placeholder="Branch ID">
        <button class="btn btn-primary" type="submit" name="createBranch">Create Branch</button>
    </form>
</div></body>
</html>