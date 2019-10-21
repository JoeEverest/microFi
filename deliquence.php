<?php
session_start();
include('config/config.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

$today = date('Y-m-d');
$sunday = date('Y-m-d', strtotime('Sunday'));
$yesterday = date('Y-m-d', strtotime('Yesterday'));

// if today is not sunday or public holidays
if ($today != $sunday) {
    
    $getPaymentsYesterday = "SELECT customer_id FROM payments WHERE next_payment = '$yesterday' AND payments_left != 0 ORDER BY id DESC";
    $getPaymentsYesterday = mysqli_query($connect, $getPaymentsYesterday);
    $getPaymentsYesterday = mysqli_fetch_array($getPaymentsYesterday);
    
    $getPaymentsToday = "SELECT customer_id FROM payments WHERE next_payment = '$today' ORDER BY id DESC";
    $getPaymentsToday = mysqli_query($connect, $getPaymentsToday);
    $getPaymentsToday = mysqli_fetch_array($getPaymentsToday);

    $deliquenceIDs = array_diff_assoc($getPaymentsYesterday, $getPaymentsToday);
    //print_r($deliquenceIDs);
    if (count($deliquenceIDs) == 0) {
    }else {
        //print_r($deliquenceIDs);
        //theres a problem
        foreach ($deliquenceIDs as $key => $customerID) {

            $getDetails = "SELECT * FROM customers WHERE unique_id = '$deliquenceIDs[customer_id]' ORDER BY id DESC";
            $getDetails = mysqli_query($connect, $getDetails);

            while ($row = mysqli_fetch_array($getDetails)) {
                $id = $row['id'];
                $name = $row['customer_name'];
                $businessTitle = $row['business_title'];
                $groupName = $row['group_name'];
                $customerId = $row['unique_id'];
                $age = $row['age'];
                $registrationDate = $row['registration_date'];
                $phoneNumber = $row['phone_number'];
            }

            $disbursementDate = "SELECT disbursment_date FROM active_loans WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
            $disbursementDate = mysqli_query($connect, $disbursementDate);
            $disbursementDate = mysqli_fetch_array($disbursementDate);
            $disbursementDate = $disbursementDate['disbursment_date'];

            $amountLeft = "SELECT amount_left FROM payments WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
            $amountLeft = mysqli_query($connect, $amountLeft);
            $amountLeft = mysqli_fetch_array($amountLeft);
            $amountLeft = $amountLeft['amount_left'];

            $maturityDate = "SELECT maturity_date FROM active_loans WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
            $maturityDate = mysqli_query($connect, $maturityDate);
            $maturityDate = mysqli_fetch_array($maturityDate);
            $maturityDate = $maturityDate['maturity_date'];

            $paymentsSkipped = "SELECT payments_skipped FROM deliquence WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
            $paymentsSkipped = mysqli_query($connect, $paymentsSkipped);
            $paymentsSkipped = mysqli_fetch_array($paymentsSkipped);
            $paymentsSkipped = $paymentsSkipped['payments_skipped'];
            $paymentsSkipped = $paymentsSkipped + 1;

            $query = "INSERT INTO deliquence VALUES ('', '$name', '$customerId', '$amountLeft', '$disbursementDate', '$maturityDate', '$paymentsSkipped', '$phoneNumber')";
            if (mysqli_query($connect, $query)) {
            }else {
                $error = mysqli_error($connect);
                echo 'There was an error '.$error;
            }
        }
    }
    
}
?>