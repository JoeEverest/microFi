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
    <title>Dashboard</title>
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="container">
    <nav>
        <span class="element">
            <h4>Operator Dashboard</h4>
        </span>
        <span class="element">
            <h4><?php echo $userLoggedIn; ?></h4>
        </span>
    </nav>
    <div class="body">
        <a href="create_center.php">Create new Center</a>
        <a href="create_gropu.php">Create new Group</a>
    </div>
</div>
</body>
</html>