<?php
include('session.php');
include('../config/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("css.php"); ?>
    <title>Admin Panel</title>
</head>

<body>
    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <?php include("../user-logged-in.php"); ?>

        <div class="cards">
            <a href="create_branch.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/ios/200/000000/add-column.png">
                    <p>Create new Branch</p>
                </div>
            </a>
            <a href="../create_center.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/wired/200/000000/add-property.png">
                    <p>Create new Center</p>
                </div>
            </a>
            <a href="register_operator.php">
                <div class="card home-cards">
                    <img src="https://img.icons8.com/wired/200/000000/add-user-male.png">
                    <p>Register New Operator</p>
                </div>
            </a>
            <a href="admin_register.php"></a>
        </div>
    </div>
</body>

</html>