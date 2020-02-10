<?php
// session_start();
// include('config/config.php');
include('date.php');
// // // include('deliquence_handler.php');

// if (isset($_SESSION['operator_name'])) {
//     $userLoggedIn = $_SESSION['operator_name'];   
// }
// else{
header("Location: index.php");
// }

// $today = date('Y-m-d');
// $yesterday = date('Y-m-d', strtotime('Yesterday'));

// $retrieve = 'SELECT * FROM active_loans WHERE amount_toPay > 0 ORDER BY id DESC';
// $retrieve = mysqli_query($connect, $retrieve);
// while ($row = mysqli_fetch_array($retrieve)) {
//     $id = $row['id'];
//     $loanID = $row['loan_id'];
//     $name = $row['customer_name'];
//     $disbursementDate = $row['disbursment_date'];
//     $maturityDate = $row['maturity_date'];
//     $uniqueId = $row['customer_id'];

//     $getPhone = "SELECT * FROM customers WHERE unique_id = '$uniqueId' ORDER BY id";
//     $getPhone = mysqli_query($connect, $getPhone);
//     while ($phn = mysqli_fetch_array($getPhone)) {
//         $phoneNumber = $phn['phone_number'];
//     }
        
//     $getLastPayment = "SELECT * FROM payments WHERE customer_id = '$uniqueId' ORDER BY id DESC LIMIT 1";
//     //Change customer_id = "$uniqueId" to loan_id = "$loanID"
//     $getLastPayment = mysqli_query($connect, $getLastPayment);
//     while ($data = mysqli_fetch_array($getLastPayment)) {
//         //$id = $data['id'];
//         //$loanID = $data['loan_id'];
//         $name = $data['customer_name'];
//         $customerId = $data['customer_id'];
//         $customerID = $customerId;
//         $nextPayment = $data['next_payment'];
//         $amountLeft = $data['amount_left'];
//         $paymentsLeft = $data['payments_left'];
        
//         if ($nextPayment < $today) {
            
//                 // if today is not sunday or public holidays
//                 for ($day=$nextPayment; $day < $today; $day = date('Y-m-d', strtotime('+1 day', strtotime($day)))){   
//                     //add to deliquence
//                     $sunday = date('Y-m-d', strtotime('Sunday', strtotime($day)));
//                     $saturday = date('Y-m-d', strtotime('Saturday', strtotime($day)));
//                     echo $day.'<br>';
//                     if ($day != $sunday) {
//                     $q = "SELECT * FROM deliquence WHERE customer_id = '$customerId' ORDER BY id DESC LIMIT 1";
//                     $q = mysqli_query($connect, $q);
//                     $numDel = mysqli_fetch_array($q);
//                     $numDel = $numDel['payments_skipped'];
//                     $ID = $numDel[0];
//                     $numDel = $numDel + 1;
//                     $num_rows = mysqli_num_rows($q);
//                     if ($num_rows > 0) {
//                         $query = "UPDATE `deliquence` SET `payments_skipped` = '$numDel' WHERE `deliquence`.`customer_id` = '$customerId'"; 
//                     }else{
//                         $query = "INSERT INTO deliquence VALUES ('', '$name', '$customerId', '$amountLeft', '$disbursementDate', '$maturityDate', '$numDel', '$phoneNumber')";
//                     }
//                     if (mysqli_query($connect, $query)) {
//                         if ($day == $saturday) {
//                             $nextDay = date('Y-m-d', strtotime('Monday', strtotime($day)));
//                         }else{
//                             $nextDay = date('Y-m-d', strtotime('+1 day', strtotime($day)));
//                         }
//                         $updatePayments = "INSERT INTO payments VALUES ('', '', '$name','$customerId', 0, 'DELIQUENCE', '$day', '0', '0', '$nextDay', '$amountLeft', '$paymentsLeft', '$userLoggedIn')";
//                         if (mysqli_query($connect, $updatePayments)) {
//                         }else {
//                             $error = mysqli_error($connect);
//                             echo 'There was an error '.$error;
//                         }
//                     }else {
//                         $error = mysqli_error($connect);
//                         echo 'There was an error '.$error;
//                     }
//                 }
//             }

//         }
//     }
// }
// // //define initial day that will be equal to the day the last payment was made
// //     //select date from payments
// //     //for every date check if payment with same id and next payment as date exist
// //         //if it does check the next day untill the next day is yesterday as long as yesterday is not sunday
// //         //IF PAYMENT DOESNT EXIST add to deliquence

//     //IMPORTANT FOR EVERY customer_id, get only last payment then start from there


?>