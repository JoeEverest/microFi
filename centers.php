<?php
session_start();

include('alt_session.php');
include('config/config.php');

$retrieve = 'SELECT * FROM centers ORDER BY id ASC';
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
    <title>Centers</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <table class="table table-striped table-sm">
            <thead>
                <th>ID</th>
                <th>Center Name</th>
                <th>Branch Name</th>
                <th>Center ID</th>
                <th>Action</th>
            </thead>
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $branchname = $row['branch_name'];
                $centername = $row['center_name'];
                $centerId = $row['center_id'];
            ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $centername; ?></td>
                    <td><?php echo $branchname; ?></td>
                    <td><?php echo $centerId; ?></td>
                    <td><a href="center.php?id=<?php echo $id; ?>"><button class="btn btn btn-success">View</button></a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>