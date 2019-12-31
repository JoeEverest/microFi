<?php
session_start();

include('alt_session.php');
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
if (isset($_GET['group'])) {
    $groupID = $_GET['group'];
    //select group name where group id = $groupID;
    //use group name to get all customer id in active loan where group name is equal to this
    //use that to filter incomes

    $retrieve = 'SELECT * FROM incomes ORDER BY date DESC';
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
    <link rel="stylesheet" href="assets/css/main.css">
    <title>All Branches</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
        <h4>All incomes</h4>
        <!-- <h5>Filter Dates</h5> -->
    <table class="table table-striped table-sm">
        <thead>
            <th>Description</th>
            <th>Reference</th>
            <th>Amount</th>
            <th>Date</th>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($retrieve)) {
            $description = $row['description'];
            $reference = $row['reference'];
            $amount = $row['amount'];
            $date = $row['date'];
        ?>
        <tr>
            <td><?php echo $description; ?></td>
            <td><?php echo $reference; ?></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $date; ?></td>
        </tr>
        <?php } ?>
    </table>
</div></body>
</html>
<?php
}else {
    $getGroup = 'SELECT * FROM groups ORDER BY id DESC';
    $getGroup = mysqli_query($connect, $getGroup);
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
    <link rel="stylesheet" href="assets/css/main.css">
    <title>All Branches</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
<form method="get">
<select class="form-control selectpicker" data-live-search="true" name="group">
    <?php
        while ($row = mysqli_fetch_array($getGroup)) {
            $id = $row['id'];
            $groupname = $row['group_name'];
            $centername = $row['center_name'];
            $groupId = $row['group_id'];
    ?>
    <option value="<?php echo $groupId; ?>"><?php echo $groupId.' - '.$groupname.' - '.$centername; ?></option>
    <?php } ?>
</select><br>
<button type="submit" class="btn btn-sm btn btn-success">Filter</button>
</form>
</div></body>
</html>
<?php
}
?>