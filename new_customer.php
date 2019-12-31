<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');
if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
include('handlers/register_customer_handler.php');
$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="assets/css/main.css">
    <title>New Customer</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <form method="post">
    <label for="name">Customer Name:</label><br>
        <div class="input-group">
            <div class="input-group-text">First Name:</div>
            <input class="form-control" required type="text" name="first_name" placeholder="First Name">
            <div class="input-group-text">Middle Name:</div>
            <input class="form-control" required type="text" name="middle_name" placeholder="Middle Name">
            <div class="input-group-text">Last Name:</div>
            <input class="form-control" required type="text" name="last_name" placeholder="Last Name">
        </div><br>
        <label for="businessTitle">Business Title:</label><br>
        <input class="form-control" required type="text" name="businessTitle" placeholder="Business Title"><br>
        <label for="phone">Phone Number:</label><br>
        <input class="form-control" required type="number" name="phone" placeholder="Phone Number"><br>
        <label for="age">Date of Birth:</label><br>
        <input class="form-control" required type="date" name="age" placeholder="Age"><br>
        Group ID:
        <select class="form-control selectpicker" data-live-search="true" name="group_name">
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
        <button class="btn btn-sm btn btn-success" type="submit" name="submit">Submit</button>
    </form>
</div></body>
</html>