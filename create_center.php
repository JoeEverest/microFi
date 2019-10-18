<?php
session_start();

include('alt_session.php');
include('config/config.php');
include('header.php');

if (isset($_POST['createCenter'])) {
    if (!$_POST['branchName'] | !$_POST['centerName'] | !$_POST['centerId']) {
        echo 'All input fields are Required';
    }
    else {
        $branchName = $_POST['branchName'];
        $centerName = $_POST['centerName'];
        $centerId = $_POST['centerId'];

        $createCenter = mysqli_query($connect, "INSERT INTO centers VALUES ('', '$branchName', '$centerName', '$centerId')");

    }
}

$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

?>
    <p>Create New Center</p>
    <form method="post">
        Branch Name:
        <select required name="branchName">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['branch_name'];
                $uniqueId = $row['branch_id'];
            
            ?>
            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>
        <input required type="text" name="centerName" placeholder="Center Name">
        <input required type="number" name="centerId" placeholder="Center ID">
        <button type="submit" name="createCenter">Create Center</button>
    </form>
</body>
</html>