<?php
session_start();

include('alt_session.php');
include('config/config.php');

$retrieve = 'SELECT * FROM centers ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <td>ID</td>
            <td>Branch Name</td>
            <td>Center Name</td>
            <td>Center ID</td>
            <td>Action</td>
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
            <td><?php echo $branchname; ?></td>
            <td><?php echo $centername; ?></td>
            <td><?php echo $centerId; ?></td>
            <td><a href="center.php?id=<?php echo $id; ?>"><button>View</button></a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>