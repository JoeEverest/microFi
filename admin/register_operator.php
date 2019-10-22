<?php
include('session.php');
include('../config/config.php');

$errors = '';
if (isset($_POST['register'])) {
    if (!$_POST['loginId'] | !$_POST['password'] | !$_POST['password2']) {
        
        $errors = 'Some Fields are empty';

    }else {
        $loginId = $_POST['loginId'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $centerName = $_POST['centerName'];

        if ($password != $password2) {
            $errors = 'Passwords Do not match';
        }else {
            if (strlen($password > 30 || strlen($password) < 8)) {
                $errors = 'Password should be between 8 and 30 characters';
            }else {
                $password = sha1(md5($password));
                # Check loginId if it exists
                $loginId_check = mysqli_query($connect, "SELECT operator_name FROM operators WHERE operator_name = '$loginId'");
                $num_rows = mysqli_num_rows($loginId_check);
                if ($num_rows > 0) {
                    $errors = 'Operator already exists';
                }else {
                    #Insert data to database
                    $register = mysqli_query($connect, "INSERT INTO operators VALUES ('', '$loginId', '$centerName', '$password')");
                    session_start();
                    $_SESSION['operatorId'] = $loginId;
                    header("Location: ../login.php");
                    exit();
                }
            }
        }
    }
}
$retrieve = 'SELECT * FROM centers ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

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
    <title>Register Operator</title>
</head>
<body>
    <div class="container">
    <?php
    if (!$errors) {    
    }else{
        echo $errors;
    }
    ?>
    <form method="post">
        <input class="form-control" placeholder='Username' type="text" name="loginId">
        Center Name:
        <select class="form-control" required name="centerName">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $branchname = $row['branch_name'];
                $centername = $row['center_name'];
                $centerId = $row['center_id'];
            ?>
            <option value="<?php echo $centername.'_'.$branchname; ?>"><?php echo $centername; ?></option>
            <?php } ?>
        </select>
        <input class="form-control" placeholder='Password' type="password" name="password">
        <input class="form-control" placeholder='Confirm Password' type="password" name="password2">
        <button class="btn btn-success" type="submit" name="register">Register Operator</button>
    </form>
</div></body>
</html>