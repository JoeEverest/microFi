<?php
session_start();
include('alt_session.php');
include('config/config.php');

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
    <title>Document</title>
</head>
<body><div class="container">
    <table class="table table-striped">
        <thead>
            <th>Customer Name</th>
            <th>Customer ID</th>
            <th>Loan Amount</th>
            <th>Maturity Date</th>
            <th>Phone Number</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php
        $extract = "SELECT * FROM `customers` ORDER BY `group_name` ASC";
        $execute = mysqli_query($connect, $extract);
                while ($dataRows = mysqli_fetch_array($execute)) {
                    $id = $dataRows["id"];
                    $customerName = $dataRows["customer_name"];
                    $businessTitle = $dataRows["business_title"];
                    $groupname = $dataRows["group_name"];
                    $cycle = $dataRows["numberof_cycles"];
                    $uniqueId = $dataRows["unique_id"];
                    $age = $dataRows["age"];
                    $amount = $dataRows["loan_amount"];
                    $date = $dataRows["date"];
                    $disbursemantDate = $dataRows["disbursement_date"];
                    $maturityDate = $dataRows["due_date"];
                    $phone = $dataRows["phone_number"];
        ?>
            <tr>
                <td><?php echo $customerName; ?></td>
                <td><?php echo $uniqueId; ?></td>
                <td><?php echo $amount; ?></td>
                <td><?php echo $maturityDate; ?></td>
                <td><?php echo $phone; ?></td>
                <td><a href="center.php?id=<?php echo $id; ?>"><button class="btn btn-primary">View</button></a></td>
            </tr>
            <?php } echo mysqli_error($connect); ?>
        </tbody>
    </table>
</div></body>
</html>