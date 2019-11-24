<?php
session_start();
include('config/config.php');
// include('deliquence_handler.php');

// if (isset($_SESSION['operator_name'])) {
//     $userLoggedIn = $_SESSION['operator_name'];   
// }
// else{
// 	header("Location: login.php");
// }

// $quer = "SELECT * FROM payments ORDER BY id DESC";
// $quer = mysqli_query($connect, $quer);
// while ($data = mysqli_fetch_array($quer)) {
//     $name = $data['customer_name'];
//     $cusID = $data['customer_id'];
//     $date = $data['date'];
//     $nextPayment = $data['next_payment'];
//     $amountLeft = $data['amount_left'];
//     $paymentsLeft = $data['payments_left'];

//     $payments = "SELECT * FROM payments WHERE date = '$nextPayment' AND customer_id = '$cusID' ORDER BY id DESC";
//     $payments = mysqli_query($connect, $payments);
//     while ($var = mysqli_fetch_array($payments)) {
        
//         $payment = $var['next_payment'];
//         $presentDay = date("Y-m-d", strtotime('today'));
//         if($payment == $presentDay){
//             echo $payment;
//             $dates = array();

//             array_push($dates, $payment);
//         }
//         if (empty($dates)) {
//             //get last payment
//             $query = "SELECT * FROM payments WHERE customer_id = '$cusID' ORDER BY id DESC LIMIT 1";
//             $query = mysqli_query($connect, $query);
//             while ($variable = mysqli_fetch_array($query)) {
//                 $lastPayment = $variable['date'];
//                 $nextPayment = $variable['next_payment'];
//                 echo $lastPayment." ".$nextPayment." ".$cusID.'<br>';

//                 $dateInitial = $lastPayment;
//                 //insert deliquence
//             }

//         }
//     }
    
// }

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}

$today = date('Y-m-d');
$sunday = date('Y-m-d', strtotime('Sunday'));
$yesterday = date('Y-m-d', strtotime('Yesterday'));
$tomorrow = date('Y-m-d', strtotime('Tomorrow'));
$paymentsYesterday = array();
$paymentsToday = array();
$lastDate = date('Y-m-d', strtotime('1st january'));

//define initial day that will be equal to the day the last payment was made
    //select date from payments
    //for every date check if payment with same id and next payment as date exist
        //if it does check the next day untill the next day is yesterday as long as yesterday is not sunday
        //IF PAYMENT DOESNT EXIST add to deliquence

    //IMPORTANT FOR EVERY customer_id, get only last payment then start from there
for ($day=$lastDate; $day < $today; $day = date('Y-m-d', strtotime('+1 day', strtotime($day)))){   
    // if today is not sunday or public holidays
}

?>