<?php
session_start();

include('alt_session.php');
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
    <title>All Branches</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Branches</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table table-striped">
                            <thead class="thead-dark">
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
                                    <td><a href="branch.php?id=<?php echo $id; ?>"><button class="btn btn-sm btn-success">View Branch</button></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>