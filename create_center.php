<?php
session_start();

include('alt_session.php');
include('config/config.php');

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