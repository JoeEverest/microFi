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

    $deliquenceIDs = array_diff($getPaymentsYesterday, $getPaymentsToday);
    
    if (count($deliquenceIDs) == 0) {
    }else {
        foreach ($deliquenceIDs as $key => $customerID) {
            //echo $customerID.'<br>';
            $getDetails = "SELECT * FROM customers WHERE unique_id = '$customerID' ORDER BY id DESC";
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