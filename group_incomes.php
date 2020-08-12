<?php
session_start();

include('alt_session.php');
include('config/config.php');

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
if (isset($_GET['group'])) {
    $groupID = $_GET['group'];

    $retrieve = 'SELECT * FROM incomes ORDER BY date DESC';
    $retrieve = mysqli_query($connect, $retrieve);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
        <?php include('css.php'); ?>
        <title>All Branches</title>
    </head>

    <body>
        <?php include('sidebar.php'); ?>
        <div class="main-content">
            <?php include("user-logged-in.php"); ?>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4>All incomes</h4>
                        <!-- <h5>Filter Dates</h5> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-0">
                            <table class="table table-sm table-nowrap card-table">
                                <thead>
                                    <th>Description</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </thead>
                                <?php
                                while ($row = mysqli_fetch_array($retrieve)) {
                                    $description = $row['description'];
                                    $reference = $row['reference'];
                                    $amount = $row['amount'];
                                    $date = $row['date'];

                                    //get group id from loanID in active loans
                                    $loanID = $reference;

                                    $getGroup = "SELECT customer_id FROM active_loans WHERE loan_id = '$loanID' ORDER BY id DESC";
                                    $getGroup = mysqli_query($connect, $getGroup);
                                    $data = mysqli_fetch_array($getGroup);
                                    $cusID = $data['customer_id'];
                                    $cusData = explode('/', $cusID);

                                    $branchid = $cusData[0];
                                    $centerid = $cusData[1];
                                    $groupid = $cusData[2];

                                    if ($groupid == $groupID) {
                                        //then filter using $groupID
                                ?>
                                        <tr>
                                            <td><?php echo $description; ?></td>
                                            <td><?php echo $reference; ?></td>
                                            <td><?php echo $amount; ?></td>
                                            <td><?php echo $date; ?></td>
                                        </tr>
                                <?php }
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    $getGroup = 'SELECT * FROM groups ORDER BY id DESC';
    $getGroup = mysqli_query($connect, $getGroup);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
        <?php include('css.php'); ?>
        <title>All Branches</title>
    </head>

    <body>
        <?php include('sidebar.php'); ?>
        <div class="main-content">
            <?php include("user-logged-in.php"); ?>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3>Select Group</h3>
                    </div>
                    <div class="card-body">

                        <form method="get">
                            <select class="form-control selectpicker" data-live-search="true" name="group">
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
                            <button type="submit" class="btn btn btn-success">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
}
?>