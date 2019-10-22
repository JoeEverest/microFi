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

$paymentsYesterday = array();
$paymentsToday = array();
// if today is not sunday or public holidays
if ($today != $sunday) {

        $getPaymentsYesterday = "SELECT * FROM payments WHERE next_payment = '$yesterday'";
        $getPaymentsYesterday = mysqli_query($connect, $getPaymentsYesterday);
    
        while($nextPaymentsYesterday = mysqli_fetch_array($getPaymentsYesterday)){
            $idYesterday = $nextPaymentsYesterday['customer_id'];
            
            array_push($paymentsYesterday, $idYesterday);
        }
        
        $getPaymentsToday = "SELECT * FROM payments WHERE next_payment = '$today'";
        $getPaymentsToday = mysqli_query($connect, $getPaymentsToday);
    
        while($nextPaymentsToday = mysqli_fetch_array($getPaymentsToday)){
            $idToday = $nextPaymentsToday['customer_id'];
    
            array_push($paymentsToday, $idToday);
        }
        
        $deliquenceIDs = array_diff($paymentsYesterday, $paymentsToday);
        //print_r($deliquenceIDs);
        if (count($deliquenceIDs) == 0) {
        }else {
            print_r($deliquenceIDs);
            $n = count($deliquenceIDs);
            $n = $n + 1;
            echo $n;
            //theres a problem
            for ($i=1; $i < $n; $i++) { 
                
                $getDetails = "SELECT * FROM customers WHERE unique_id = '$deliquenceIDs[$i]' ORDER BY id DESC";
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
                // check if id already exists in deliquence if yes just update if no do below
                //then after change payments to a new one with reciept DELIQUENT and next payment = today
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