<?php
include('../config/config.php');
include('session.php');

$id = '';
$password = '';
$password2 = '';
$errors = '';
if (isset($_POST['register'])) {
    if (!$_POST['loginId'] | !$_POST['password'] | !$_POST['password2']) {
        
        $errors = 'Some Fields are empty';

    }else {
        $loginId = $_POST['loginId'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if ($password != $password2) {
            $errors = 'Passwords Do not match';
        }else {
            if (strlen($password > 30 || strlen($password) < 8)) {
                $errors = 'Password should be between 8 and 30 characters';
            }else {
                $password = sha1(md5($password));
                # Check loginId if it exists
                $loginId_check = mysqli_query($connect, "SELECT loginId FROM admin WHERE loginId='$loginId'");
                $num_rows = mysqli_num_rows($loginId_check);
                if ($num_rows > 0) {
                    $errors = 'loginId already exists';
                }else {
                    #Insert data to database
                    $register = mysqli_query($connect, "INSERT INTO admin VALUES ('$loginId', '$password')");
                    session_start();
                    $_SESSION['loginId'] = $loginId;
                    header("Location: admin_login.php");
                    exit();
                }
            }
        }
    }
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
    <title>Document</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <?php
    if (!$errors) {    
    }else{
        echo $errors;
    }
    ?>
    <form method="post">
        <input class="form-control" placeholder='Username' type="text" name="loginId">
        <input class="form-control" placeholder='Password' type="password" name="password">
        <input class="form-control" placeholder='Confirm Password' type="password" name="password2">
        <button class="btn btn-primary" type="submit" name="register">Register Admin</button>
    </form>
</div></body>
</html>