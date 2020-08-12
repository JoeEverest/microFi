<?php
include('config/config.php');
session_start();
$errors = array();
$id = '';
$password = '';
if (isset($_POST['logIn'])) {
    if (!$_POST['username'] | !$_POST['password']) {
        $errors = array_push($errors, 'All inputs are required');
    } else {
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
        } else {
            $errors = array_push($errors, 'Username or Password is incorrect');
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
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="assets/css/floating-labels.css">
    <title>Operator Login</title>
</head>

<body>
    <form method="post" class="form-signin">
        <div class="text-center mb-4">
            <img src="assets/images/yaniv_l.png">
            <h2 class="h3 mb-3 font-weight-normal">Operator Login</h2>
            <div class="errors">
                <?php
                if ($errors) {
                    echo '<div class="alert alert-danger" role="alert">';
                    foreach ($errors as $value) {
                        echo "<span>" . $value . "</span>";
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="form-label-group">
            <label for="loginId">Username</label>
            <input class="form-control" placeholder='Username' type="text" name="username">
        </div>
        <div class="form-label-group">
            <label for="password">Password</label>
            <input class="form-control" placeholder='Password' type="password" name="password"><br>
        </div>
        <button class="btn btn-block btn-success" type="submit" name="logIn">Login</button>
    </form>
</body>

</html>