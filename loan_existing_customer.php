<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
if (isset($_POST['submit'])) {
    if (!$_POST['customer_name'] | !$_POST['loan_amount'] | !$_POST['disbursement_date']) {
        echo "<script> alert ('All input fileds are required'); </script>";
    }else {
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
            $interest = $loanAmount * 0.2;
            $amountToPay = $loanAmount + $interest;
            $installmentAmount = $amountToPay/30;
    
            $disbarsmentDate = $_POST['disbursement_date'];
            
            $due_date = date('Y-m-d', strtotime('+35 days', strtotime($disbarsmentDate)));
            $nextday = date('Y-m-d', strtotime('+1 day', strtotime($disbarsmentDate)));
    
            $sunday = date('Y-m-d', strtotime('sunday', strtotime($disbarsmentDate)));
    
            if ($nextday != $sunday) {
                $nextPayment = date('Y-m-d', strtotime('+1 day', strtotime($disbarsmentDate)));
            }else {
                $nextPayment = date('Y-m-d', strtotime('+2 days', strtotime($disbarsmentDate)));
            }
            
            $maturityDate = date('y-m-d');
    
            $customerDetails = "SELECT * FROM customers WHERE id = '$customerId' ORDER BY id DESC";
            $customerDetails = mysqli_query($connect, $customerDetails);
    
            while ($row = mysqli_fetch_array($customerDetails)) {
                $id = $row['id'];
                $name = $row['customer_name'];
                $businessTitle = $row['business_title'];
                $customerid = $row['unique_id'];
            }
    
            $loanCount = "SELECT id FROM active_loans ORDER BY id DESC";
            $loanCount = mysqli_query($connect, $loanCount);
            $loanCount = mysqli_num_rows($loanCount);
            
            $year = date('Y');
            $loanCurrentNumber = $loanCount + 1;
            $loanID = "L-".$loanCurrentNumber."/".$year;
    
            // $updateLoan= "UPDATE loans SET loanstatus_id = '$loan_status', loan_issued = '1', loan_dateout = '$loan_dateout', loan_principalapproved = '$loan_princp_approved', loan_fee = '$loan_fee', loan_fee_receipt = '$loan_fee_receipt', loan_insurance = '$loan_insurance', loan_insurance_receipt = '$loan_fee_receipt' WHERE loan_id = '$_SESSION[loan_id]'";
            // $query_issue = mysqli_query($connect, $updateLoan);
            // checkSQL($connect, $query_issue);
            if ($amt == 0) {

                $query = "INSERT INTO active_loans VALUES ('', '$loanID', '$customerName','$uid', '$businessTitle', '$loanAmount', '$amountToPay', '$installmentAmount', '$disbarsmentDate', '$due_date')";
                
                if (mysqli_query($connect, $query)) {
                    $qu = "INSERT INTO payments VALUES ('', '$customerName','$uid', '0', 'NEW CUSTOMER', '$disbarsmentDate', '0', '0', '$nextPayment', '$amountToPay', '30', '$userLoggedIn')";
                    if (mysqli_query($connect, $qu)) {
                        header('Location: customer_profile.php?id='.$uid);
                    }else {
                        $error = mysqli_error($connect);
                        echo 'There was an error '.$error;
                    }
                }else {
                    $error = mysqli_error($connect);
                    echo 'There was an error '.$error;
                }
                
        }else {
            header("Location: prepayment.php?id=".$uid);
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
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>New Loan: Existing Customer</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="container">
    <p>Loan for existing customer</p>
    <form method="post">
    Customer Name:
        <select class="form-control" required name="customer_name">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['unique_id'];
                $name = $row['customer_name'];
                $id = str_replace(' ', '', $id);
            ?>
            <option value="<?php echo $name.' '.$id; ?>"><?php echo $id.' - '.$name; ?></option>
            <?php } ?>
        </select><br>
        <input class="form-control" type="number" name="loan_amount" placeholder="Loan Amount"><br>
        Disbursement Date: <input class="form-control" type="date" name="disbursement_date"><br>
        <button class="btn btn-success" type="submit" name="submit">Submit</button>
    </form>
</div></body>
</html>