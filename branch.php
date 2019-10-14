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
    <title>Document</title>
</head>
<body>
    <?php
    $id = $_GET['id'];
    $extract = "SELECT * FROM branches WHERE id = '$id' ORDER BY id DESC";
            $execute = mysqli_query($connect, $extract);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $id = $dataRows["id"];
                $name = $dataRows["branch_name"];
                $uniqueId = $dataRows["branch_id"];    
    ?>
    <p><?php echo $name; ?></p>
    <?php } ?>
    <table>
        <thead>
            <td>ID</td>
            <td>Center Name</td>
            <td>Center ID</td>
            <td>Number of Groups</td>
            <td>Action</td>
        </thead>
        <tbody>
        <?php
        $extract = "SELECT * FROM centers WHERE branch_name = '$name' ORDER BY id DESC";
        $execute = mysqli_query($connect, $extract);
                while ($dataRows = mysqli_fetch_array($execute)) {
                    $id = $dataRows["id"];
                    $branchName = $dataRows["branch_name"];
                    $centername = $dataRows["center_name"];
                    $centerId = $dataRows["center_id"];
        $check_database_query = mysqli_query($connect, "SELECT * FROM groups WHERE center_name = '$centername'");
        $check_login_query = mysqli_num_rows($check_database_query);
        $numberOfGroups = $check_login_query;
        ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $centername; ?></td>
                <td><?php echo $centerId; ?></td>
                <td><?php echo $numberOfGroups; ?></td>
                <td><a href="center.php?id=<?php echo $id; ?>"><button>View Center</button></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>