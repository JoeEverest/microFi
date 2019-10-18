<?php
session_start();

include('alt_session.php');
include('config/config.php');

if (isset($_POST['createGroup'])) {
    if (!$_POST['groupName'] | !$_POST['centerName'] | !$_POST['groupId']) {
        echo 'All input fields are Required';
    }
    else {
        $groupName = $_POST['groupName'];
        $centerName = $_POST['centerName'];
        $groupId = $_POST['groupId'];

        $createCenter = mysqli_query($connect, "INSERT INTO groups VALUES ('', '$groupName', '$centerName', '$groupId')");

    }
}

$retrieve = 'SELECT * FROM centers ORDER BY id DESC';
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
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="groupName" placeholder="Group Name">
        Center Name:
        <select required name="centerName">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $branchname = $row['branch_name'];
                $centername = $row['center_name'];
                $centerId = $row['center_id'];
            
            ?>
            <option value="<?php echo $centername; ?>"><?php echo $centername; ?></option>
            <?php } ?>
        </select>
        <input type="number" name="groupId" placeholder="Group ID">
        <button type="submit" name="createGroup">Create Group</button>
    </form>
</body>
</html>