<?php
include('config/config.php');
include('date.php');
session_start();
$errors = '';
$id = '';
$password = '';
if (isset($_POST['logIn'])) {
    if (!$_POST['username'] | !$_POST['password']) {
        $errors = 'All inputs are required';
    }else {
        $username = $_POST['username'];
        $password = sha1(md5($_POST['password']));
        //save username to session
        $_SESSION['username'] = $username;

        $check_database_query = mysqli_query($connect, "SELECT * FROM operators WHERE operator_name = '$username' AND password='$password'");
        $check_login_query = mysqli_num_rows($check_database_query);
        
        if ($check_login_query == 1) {
            $row = mysqli_fetch_array($check_database_query);
            $username = $row['operator_name'];
            
            $_SESSION['operator_name'] = $username;

            header("Location: index.php");
            
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
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Operator Login</title>
</head>
<body>
    <img src="assets/images/yaniv_l.png">
    <div class="container">
    <?php
    if (!$errors) {    
    }else{
        echo $errors;
    }
    ?>
    <div class="formHolder">
        <form method="post">
            <h3>Operator Login</h3>
            <label for="username">Username</label>
            <input required class="form-control" placeholder='Username' type="text" name="username">
            <label for="password">Password</label>
            <input required class="form-control" placeholder='Enter Your Password' type="password" name="password">
            <br>
            <button class="btn btn-sm btn btn-success" type="submit" name="logIn">Login</button>
        </form>
    </div>
</div></body>
</html>