<?php
include('config/config.php');
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

        $check_database_query = mysqli_query($connect, "SELECT * FROM operators WHERE operator_name = '$loginId' AND password='$password'");
        $check_login_query = mysqli_num_rows($check_database_query);
        
        if ($check_login_query == 1) {
            $row = mysqli_fetch_array($check_database_query);
            $loginId = $row['operator_name'];
            
            $_SESSION['operator_name'] = $loginId;

            header("Location: index.php");
            
            exit();
        }else {
            $errors = 'Username or Password is incorrect';
        }

    }
}
include('header.php');

    if (!$errors) {    
    }else{
        echo $errors;
    }
    ?>
    <form method="post">
        <input placeholder='Username' type="text" name="loginId">
        <input placeholder='Password' type="password" name="password">
        <button type="submit" name="logIn">Login</button>
    </form>
</body>
</html>