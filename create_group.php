<?php
session_start();

include('alt_session.php');
include('config/config.php');
include('header.php');

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