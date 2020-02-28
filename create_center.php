<?php
session_start();

include('alt_session.php');
include('config/config.php');

if (isset($_POST['createCenter'])) {
    if (!$_POST['branchName'] | !$_POST['centerName']) {
        echo 'All input fields are Required';
    }
    else {
        $branchName = $_POST['branchName'];
        $centerName = $_POST['centerName'];

        $crID = "SELECT * FROM centers  WHERE branch_name = '$branchName' ORDER BY id DESC";
        $crID = mysqli_query($connect, $crID);

        $centerId = mysqli_num_rows($crID);
        $centerId = $centerId + 1;
        $centerId = $centerId * 100;

        $createCenter = mysqli_query($connect, "INSERT INTO centers VALUES ('', '$branchName', '$centerName', '$centerId')");

    }
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
    <title>Create New Center</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <h3>Create New Center</h3>
    <form method="post">
        <label for="branchName">Branch Name</label>
        <select class="form-control" required name="branchName">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['branch_name'];
                $uniqueId = $row['branch_id'];
            // add branch ID to centers
            ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>
        <label for="centerName">Center Name</label>
        <input class="form-control" required type="text" name="centerName" placeholder="Center Name">
        <!-- <label for="centerId">Center ID</label> -->
        <!-- <input class="form-control" required type="number" name="centerId" placeholder="Center ID"> --><br>
        <button class="btn btn-sm btn btn-success" type="submit" name="createCenter">Create Center</button>
    </form>
</div></body>
</html>