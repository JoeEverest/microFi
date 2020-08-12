<?php
include('session.php');
include('../config/config.php');

$errors = array();
if (isset($_POST['register'])) {
    if (!$_POST['loginId'] | !$_POST['password'] | !$_POST['password2'] | !$_POST['rank']) {

        $errors = array_push($errors, 'Some Fields are empty');
    } else {
        $loginId = $_POST['loginId'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $centerName = $_POST['centerName'];
        $rank = $_POST['rank'];

        if ($password != $password2) {
            $errors = array_push($errors, 'Passwords Do not match');
        } else {
            if (strlen($password > 30 || strlen($password) < 8)) {
                $errors = 'Password should be between 8 and 30 characters';
            } else {
                $password = sha1(md5($password));
                # Check loginId if it exists
                $loginId_check = mysqli_query($connect, "SELECT operator_name FROM operators WHERE operator_name = '$loginId'");
                $num_rows = mysqli_num_rows($loginId_check);
                if ($num_rows > 0) {
                    $errors = 'Operator already exists';
                } else {
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
    <link rel="stylesheet" href="../assets/css/floating-labels.css">
    <title>Register Operator</title>
</head>

<body>
    <form method="post" class="form-signin">
        <div class="text-center mb-4">
            <img src="../assets/images/yaniv_l.png">
            <h2 class="h3 mb-3 font-weight-normal">Register Operator</h2>
            <div class="errors">
                <?php
                if (count($errors) > 0) {
                    echo '<div class="alert alert-danger" role="alert">';
                    foreach ($errors as $value) {
                        echo "<span>" . $value . "</span>";
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="form-lable-group">
            <label for="loginId">Username</label>
            <input class="form-control" placeholder='Username' type="text" name="loginId">
        </div>
        <div class="form-lable-group">
            <label for="centerName">Center Name:</label>
            <select class="form-control" required name="centerName">
                <?php
                while ($row = mysqli_fetch_array($retrieve)) {
                    $id = $row['id'];
                    $branchname = $row['branch_name'];
                    $centername = $row['center_name'];
                    $centerId = $row['center_id'];
                ?>
                    <option value="<?php echo $centername . '_' . $branchname; ?>"><?php echo $centername; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-lable-group">
            <label for="rank">Rank:</label>
            <select name="rank" required class="form-control">
                <option value="OPERATOR">OPERATOR</option>
                <option value="AUTHORIZER">AUTHORIZER</option>
            </select>
        </div>
        <div class="form-lable-group">
            <label for="password">Password</label>
            <input class="form-control" placeholder='Password' type="password" name="password">
        </div>
        <div class="form-lable-group">
            <label for="password2">Confirm Password</label>
            <input class="form-control" placeholder='Confirm Password' type="password" name="password2">
        </div><br>
        <button class="btn btn-block btn-success" type="submit" name="register">Register Operator</button>
    </form>
</body>

</html>