<?php
include('session.php');
include('../config/config.php');

if (isset($_POST['loan_interest'])) {
    if (!$_POST['interest']) {
        echo '<script>alert("All input fields required")</script>';
    } else {
        $interest = $_POST['interest'];
        $query = "UPDATE `settings` SET `value` = '$interest' WHERE `settings`.`id` = '1'";
        if (mysqli_query($connect, $query)) {
        } else {
            echo mysqli_error($connect);
            echo 'There was an error ' . $error;
        }
    }
}
if (isset($_POST['loan_fee'])) {
    if (!$_POST['application_fee']) {
        echo '<script>alert("All input fields required")</script>';
    } else {
        $applFee = $_POST['application_fee'];
        $query = "UPDATE `settings` SET `value` = '$applFee' WHERE `settings`.`id` = '2'";
        if (mysqli_query($connect, $query)) {
        } else {
            echo mysqli_error($connect);
            echo 'There was an error ' . $error;
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
    <?php include("css.php"); ?>

    <title>All Branches</title>
</head>

<body>
    <?php
    include('sidebar.php');
    $getInterest = 'SELECT value FROM settings WHERE id = 1';
    $getInterest = mysqli_query($connect, $getInterest);
    while ($row = mysqli_fetch_array($getInterest)) {
        $interestVar = $row['value'];
    }
    ?>
    <div class="main-content">
        <?php include("../user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>Settings</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <label for="groupName">Loan Interest</label>
                        <input class="form-control" type="number" name="interest" value="<?php echo $interestVar; ?>" placeholder="Loan Interest"><br>
                        <button class="btn btn btn-success" type="submit" name="loan_interest">Update Loan</button><br>
                        <hr>
                        <label for="groupName">Loan Application Fee</label>
                        <input class="form-control" type="number" name="application_fee" value="<?php echo $applicationFee; ?>" placeholder="Loan Interest"><br>
                        <button class="btn btn btn-primary" type="submit" name="loan_fee">Update Loan Fee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>