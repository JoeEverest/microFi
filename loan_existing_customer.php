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
        echo "All input fileds are required";
    }else {
        $customerName = $_POST['customer_name'];
            $last_space = strrpos($customerName, ' ');
            $last_word = substr($customerName, $last_space);
            $first_chunk = substr($customerName, 0, $last_space);
            $customerId = $last_word;
            $customerName = $first_chunk;
        $loanAmount = $_POST['loan_amount'];
        $disbursementDate = $_POST['disbursement_date'];

        $maturityDate = date('y-m-d');

        $customerDetails = "SELECT * FROM active_loans WHERE customer_name = '$customerName' ORDER BY id DESC";
        $customerDetails = mysqli_query($connect, $customerDetails);

        while ($row = mysqli_fetch_array($customerDetails)) {
            $id = $row['id'];
            $name = $row['customer_name'];
            //$customerId = $row['customer_id'];
            $loan_amount = $row['loan_amount'];
            $disbursement_date = $row['disbursment_date'];
            $maturity_date = $row['maturity_date'];
            $cycleNumber = $row['number_ofcycle'];
        }
        $updateLoan = "UPDATE active_loans WHERE customer_id='$customerId' SET loan_amount='$loanAmount', disbursment_date = '$disbursementDate', maturity_date = '$maturityDate'";
        //cycleNumber = existing+1;
        if (mysqli_query($connect, $updateLoan)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connect);
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
    <title>Document</title>
</head>
<body>
    <p>Loan for existing customer</p>
    <form method="post">
    Customer Name:
        <select required name="customer_name">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['customer_name'];
            
            ?>
            <option value="<?php echo $name.' '.$id; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select><br>
        <input type="number" name="loan_amount" placeholder="Loan Amount"><br>
        Disbursement Date: <input type="date" name="disbursement_date"><br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>