<?php
include('../config/config.php');
session_start();
$errors = '';
$id = '';
$password = '';
if (isset($_POST['logIn'])) {
    if (!$_POST['loginId'] | !$_POST['password']) {
        $errors = 'All inputs are required';
    }else {
        $loginId = $_POST['loginId'];
        $password = sha1(md5($_POST['password']));
        //save loginId to session
        $_SESSION['loginId'] = $loginId;

        $check_database_query = mysqli_query($connect, "SELECT * FROM admin WHERE loginId = '$loginId' AND password='$password'");
        $check_login_query = mysqli_num_rows($check_database_query);
        
        if ($check_login_query == 1) {
            $row = mysqli_fetch_array($check_database_query);
            $loginId = $row['loginId'];
            
            $_SESSION['loginId'] = $loginId;

            header("Location: admin_panel.php");
            
            exit();
        }else {
            $errors = 'Username or Password is incorrect';
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
    <script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Admin Login</title>
</head>
<body>
<img src="../assets/images/yaniv_l.png">
    <div class="container">
    <?php
    if (!$errors) {    
    }else{
        echo $errors;
    }
    ?>
    <div class="formHolder">
    <form method="post">
        <h3>Admin Login</h3>
        <label for="loginId">Username</label>
        <input class="form-control" placeholder='Username' type="text" name="loginId">
        <label for="password">Password</label>
        <input class="form-control" placeholder='Password' type="password" name="password"><br>
        <button class="btn btn-success" type="submit" name="logIn">Login</button>
    </form>
    </div>
</div></body>
</html>