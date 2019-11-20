<?php
// session_start();
// include('config/config.php');
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
//         $today = date("Y-m-d", strtotime('today'));
//         if($payment == $today){
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
?>