<?php
include('session.php');
include('../config/config.php');

$errors = '';
if (isset($_POST['register'])) {
    if (!$_POST['loginId'] | !$_POST['password'] | !$_POST['password2'] | !$_POST['rank']) {
        
        $errors = 'Some Fields are empty';

    }else {
        $loginId = $_POST['loginId'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $centerName = $_POST['centerName'];
        $rank = $_POST['rank'];

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
                    $register = mysqli_query($connect, "INSERT INTO operators VALUES ('', '$loginId', '$centerName', '$rank', '$password')");
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
    <img src="../assets/images/yaniv_l.png">
    <div class="formHolder">
        <form method="post">
        <h3>Register Operator</h3>
            <label for="loginId">Username</label>
            <input class="form-control" placeholder='Username' type="text" name="loginId">
            <label for="centerName">Center Name:</label>
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
            <label for="rank">Rank:</label>
            <select name="rank" required class="form-control">
                <option value="OPERATOR">OPERATOR</option>
                <option value="AUTHORIZER">AUTHORIZER</option>
            </select>
            <label for="password">Password</label>
            <input class="form-control" placeholder='Password' type="password" name="password">
            <label for="password2">Confirm Password</label>
            <input class="form-control" placeholder='Confirm Password' type="password" name="password2">
            <br>
            <button class="btn btn-sm btn btn-success" type="submit" name="register">Register Operator</button>
        </form>
    </div>
</div></body>
</html>