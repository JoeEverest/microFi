<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $extract = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $rank = $dataRows["rank"];
        if ($rank != 'AUTHORIZER') {
            header("Location: index.php");
        }
    }
} else {
    header("Location: login.php");
}

if (isset($_POST['createCenter'])) {
    if (!$_POST['branchName'] | !$_POST['centerName']) {
        echo 'All input fields are Required';
    } else {
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
    <?php include('css.php'); ?>
    <title>Create New Center</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>Create New Center</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <label for="branchName">Branch Name</label>
                        <select class="form-control" required name="branchName">
                            <?php
                            while ($row = mysqli_fetch_array($retrieve)) {
                                $id = $row['id'];
                                $name = $row['branch_name'];
                                $uniqueId = $row['branch_id'];
                            ?>
                                <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        <label for="centerName">Center Name</label>
                        <input class="form-control" required type="text" name="centerName" placeholder="Center Name">
                        <!-- <label for="centerId">Center ID</label> -->
                        <!-- <input class="form-control" required type="number" name="centerId" placeholder="Center ID"> --><br>
                        <button class="btn btn btn-success" type="submit" name="createCenter">Create Center</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>