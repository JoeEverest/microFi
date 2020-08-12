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
if (isset($_POST['submit'])) {
    if (!$_POST['customer_name'] | !$_POST['loan_amount'] | !$_POST['recieptNumber']) {
        echo "<script> alert ('All input fileds are required'); </script>";
    } else {
        //Check if loans exist
        $nm = $_POST['customer_name'];
        $last_space = strrpos($nm, ' ');
        $last_word = substr($nm, $last_space);
        $first_chunk = substr($nm, 0, $last_space);
        $customerId = $last_word;
        $nm = $first_chunk;
        $ret = "SELECT * FROM customers WHERE customer_name = '$nm' ORDER BY id DESC";
        $ret = mysqli_query($connect, $ret);
        while ($row = mysqli_fetch_array($ret)) {
            $uid = $row['unique_id'];
            $name = $row['customer_name'];
        }

        $qr = "SELECT amount_left FROM payments WHERE customer_id = '$uid' ORDER BY id DESC LIMIT 1";
        $qr = mysqli_query($connect, $qr);
        while ($amount = mysqli_fetch_array($qr)) {
            $amt = $amount['amount_left'];
        }

        $customerName = $_POST['customer_name'];
        $last_space = strrpos($customerName, ' ');
        $last_word = substr($customerName, $last_space);
        $first_chunk = substr($customerName, 0, $last_space);
        $customerId = $last_word;
        $customerName = $first_chunk;
        $loanAmount = $_POST['loan_amount'];
        $interest = $loanAmount * $intrest / 100;
        $amountToPay = $loanAmount + $interest;
        $installmentAmount = $amountToPay / 30;

        $reciept = $_POST['recieptNumber'];

        $customerDetails = "SELECT * FROM customers WHERE id = '$customerId' ORDER BY id DESC";
        $customerDetails = mysqli_query($connect, $customerDetails);

        while ($row = mysqli_fetch_array($customerDetails)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            $customerid = $row['unique_id'];
        }

        $loanCount = "SELECT id FROM pending_loans ORDER BY id DESC";
        $loanCount = mysqli_query($connect, $loanCount);
        $loanCount = mysqli_num_rows($loanCount);

        $year = date('Y');
        $loanCurrentNumber = $loanCount + 1;
        $loanID = "L-" . $loanCurrentNumber . "/" . $year;

        if ($amt == 0) {

            $query = "INSERT INTO pending_loans VALUES ('', '$loanID', '$customerName','$uid', '$loanAmount', '$amountToPay', '$installmentAmount', '$reciept', 'PENDING')";

            if (mysqli_query($connect, $query)) {
                $today = date("Y-m-d", strtotime('today'));
                $fee = "INSERT INTO incomes VALUES ('', 'NEW LOAN','$loanID', '$reciept', '$applicationFee', '$today')";
                if (mysqli_query($connect, $fee)) {
                    header('Location: customer_profile.php?id=' . $uid);
                } else {
                    $error = mysqli_error($connect);
                    echo 'There was an error ' . $error;
                }
            } else {
                $error = mysqli_error($connect);
                echo 'There was an error ' . $error;
            }
        } else {
            header("Location: prepayment.php?id=" . $uid);
        }
    }
}
$retrieve = 'SELECT * FROM customers ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('css.php'); ?>
    <title>New Loan: Existing Customer</title>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <?php include("user-logged-in.php"); ?>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>Loan for existing customer</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        Customer Name:
                        <select class="form-control selectpicker" data-live-search="true" required name="customer_name">
                            <option value=""></option>
                            <?php
                            while ($row = mysqli_fetch_array($retrieve)) {
                                $id = $row['unique_id'];
                                $name = $row['customer_name'];
                                $id = str_replace(' ', '', $id);
                            ?>
                                <option value="<?php echo $name . ' ' . $id; ?>"><?php echo $id . ' - ' . $name; ?></option>
                            <?php } ?>
                        </select><br><br>
                        Loan Amount:
                        <input class="form-control" type="number" name="loan_amount" placeholder="Loan Amount"><br>
                        Loan Fee:
                        <input class="form-control" type="number" name="loan_fee" readonly value="<?php echo $applicationFee; ?>"><br>
                        Reciept Number:
                        <input class="form-control" type="text" name="recieptNumber" placeholder="Reciept Number"><br>
                        <button class="btn btn btn-success" type="submit" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>