<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');
if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $getCenter = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn'";
    $getCenter = mysqli_query($connect, $getCenter);
    while ($centerName = mysqli_fetch_array($getCenter)) {
        $centerDetails = $centerName['center_name'];
        $cname = explode("_", $centerDetails);
        $center__name = $cname[0];
        $branch__name = $cname[1];
    }
} else {
    header("Location: login.php");
}
include('handlers/register_customer_handler.php');
$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);
$getGroup = 'SELECT * FROM groups ORDER BY id DESC';
$getGroup = mysqli_query($connect, $getGroup);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('css.php'); ?>
    <title>New Customer</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>New Customer</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <label for="first_name">First Name:</label>
                        <input class="form-control" required type="text" name="first_name" placeholder="First Name">
                        <label for="middle_name">Middle Name:</label>
                        <input class="form-control" required type="text" name="middle_name" placeholder="Middle Name">
                        <label for="last_name">Last Name:</label>
                        <input class="form-control" required type="text" name="last_name" placeholder="Last Name">
                        <label for="businessTitle">Business Title:</label><br>
                        <input class="form-control" required type="text" name="businessTitle" placeholder="Business Title"><br>
                        <label for="phone">Phone Number:</label><br>
                        <input class="form-control" required type="number" name="phone" placeholder="Phone Number"><br>
                        <label for="age">Date of Birth:</label><br>
                        <input class="form-control" required type="date" name="age" placeholder="Age"><br>
                        Group ID:
                        <select class="form-control selectpicker" data-live-search="true" name="group_name">
                            <?php
                            while ($row = mysqli_fetch_array($getGroup)) {
                                $id = $row['id'];
                                $groupname = $row['group_name'];
                                $centername = $row['center_name'];
                                $groupId = $row['group_id'];

                            ?>
                                <option value="<?php echo $groupId; ?>"><?php echo $groupId . ' - ' . $groupname . ' - ' . $centername; ?></option>
                            <?php } ?>
                        </select><br>
                        <button class="btn btn-success" type="submit" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>