<?php
session_start();
include('config/config.php');
include('date.php');
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
}
else{
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
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Pending Loans</title>
</head>
<body>
<?php include('sidebar.php'); ?>
<div class="container">
    <table class="table table-striped table-sm">
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
                        <button class="btn btn-sm btn btn-success">Approve Loan</button>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>