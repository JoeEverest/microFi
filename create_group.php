<?php
session_start();

include('alt_session.php');
include('config/config.php');

if (isset($_POST['createGroup'])) {
    if (!$_POST['groupName'] | !$_POST['centerName']) {
        echo 'All input fields are Required';
    } else {
        $groupName = $_POST['groupName'];
        $centerName = $_POST['centerName'];

        $grpID = rand(01, 99);

        $groupData = "SELECT * FROM groups WHERE group_id = '$grpID' AND center_name = '$centerName' ORDER BY id DESC";
        $groupData = mysqli_query($connect, $groupData);
        $numRows = mysqli_num_rows($groupData);
        if ($numRows > 0) {
            $groupId = $grpID;
        } else {
            $grpID = rand(01, 99);
            $groupId = $grpID + 1;
        }

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
    <?php include('css.php'); ?>
    <title>Create Group</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <form method="POST">
                    <div class="card-header">
                        <h4>Create Group</h4>
                    </div>
                    <div class="card-body">
                        <label for="groupName">Group Name</label>
                        <input class="form-control" type="text" name="groupName" placeholder="Group Name">
                        <label for="centerName">Center Name</label>
                        <select class="form-control" required name="centerName">
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
                        <!-- <label for="groupId">Group ID</label> -->
                        <!-- <input class="form-control" type="number" name="groupId" placeholder="Group ID"> --><br>
                        <button class="btn btn btn-success" type="submit" name="createGroup">Create Group</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>