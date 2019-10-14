<?php
session_start();

include('alt_session.php');
include('config/config.php');

$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
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
            <td>Branch Name</td>
            <td>Branch ID</td>
            <td>Action</td>
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
            <td><a href="branch.php?id=<?php echo $id; ?>"><button>View Branch</button></a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>