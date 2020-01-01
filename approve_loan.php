<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $extract = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $rank = $dataRows["rank"];
        if ($rank != 'AUTHORIZER') {
	        header("Location: index.php");
        }
    }
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
    <title>Pending Loans</title>
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="container">
    
</div>
</body>
</html>