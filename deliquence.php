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
    $getPaymentsYesterday = "SELECT * FROM payments WHERE next_payment = '$yesterday' AND amount_left > 0 ORDER BY id DESC";
    $getPaymentsYesterday = mysqli_query($connect, $getPaymentsYesterday);

    while ($row = mysqli_fetch_array($getPaymentsYesterday)) {
        $idYesterday = $row['customer_id'];
        // $name = $row['customer_name'];
        // $amountLeft = $row['amount_left'];
        // $paymentsLeft = $row['payments_left'];

        $getPaymentsToday = "SELECT * FROM payments WHERE next_payment = '$today' AND customer_id != '$idYesterday' ORDER BY id DESC";
        $getPaymentsToday = mysqli_query($connect, $getPaymentsToday);

        while ($data = mysqli_fetch_array($getPaymentsToday)) {
            $idToday = $data['customer_id'];
            $name = $data['customer_name'];
            $amountLeft = $data['amount_left'];
            $paymentsLeft = $data['payments_left'];

            echo $idToday.'<br>';
        }
    }

}
//         get * from payments where next payment = yesterday
//             loop for customer id
//         get * from payments where next payment = today
//             loop for customer id

//         check for customer id that are in yesterday but not today.
//             check for those who amount_left > 0
//                 add their details to deliquence table
//                 echo their details

//         $results = !empty(array_intersect($yesterday, $today));

//         if(array_intersect($yesterday, $today)){
//             if(amountLeft > 0){
//                 add their details to deliquence table
//                 add empty payment for yesterday and new payment day to be today
//                 add number of deliquence days
//                 echo their details
//             }
//         }

?>