<?php
session_start();
include('config/config.php');
include('deliquence_handler.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];

    $extract = "SELECT * FROM operators WHERE operator_name = '$userLoggedIn' ORDER BY id DESC";
    $execute = mysqli_query($connect, $extract);
    while ($dataRows = mysqli_fetch_array($execute)) {
        $rank = $dataRows["rank"];
        if ($rank != 'AUTHORIZER') {
            header("Location: index.php");
        }
    }
} else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <?php include('css.php'); ?>
    <title>Pending Loans</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Loans Pending Approval</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                                <th>Loan ID</th>
                                <th>Customer Name</th>
                                <th>Customer ID</th>
                                <th>Loan Amount</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $getData = "SELECT * FROM pending_loans WHERE status = 'PENDING' ORDER BY id DESC";
                                $data = mysqli_query($connect, $getData);
                                while ($rows = mysqli_fetch_array($data)) {
                                    $loanID = $rows["loan_id"];
                                    $customerName = $rows["customer_name"];
                                    $customerID = $rows["customer_id"];
                                    $loanAmount = $rows["loan_amount"];
                                    $id = $rows["id"];
                                ?>
                                    <tr>
                                        <td><?php echo $loanID; ?></td>
                                        <td><?php echo $customerName; ?></td>
                                        <td><?php echo $customerID; ?></td>
                                        <td><?php echo $loanAmount; ?></td>
                                        <td>
                                            <a href="approve_loan.php?reqID=<?php echo $id; ?>">
                                                <button class="btn btn btn-success">Approve Loan</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>