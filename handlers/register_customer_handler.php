<?php
if (isset($_POST['submit'])) {
    if (!$_POST['name'] | !$_POST['businessTitle'] | !$_POST['phone'] | !$_POST['numberOfCycle'] | !$_POST['age'] | !$_POST['amount'] | !$_POST['disbarsmentDate']) {
        echo 'Some fields are empty';
    }
    else{
        $customerName = $_POST['name'];
        $businessTitle = $_POST['businessTitle'];
        $phoneNumber = $_POST['phone'];
        $cycleNumber = $_POST['numberOfCycle'];
        $age = $_POST['age'];
        $amount = $_POST['amount'];
        $date = date('y-m-d');
        $disbarsmentDate = $_POST['disbarsmentDate'];
        $i = 2;
        $amountToPay = $amount + ($amount * 0.2);
        
        $installmentAmount = $amountToPay/30;

        $center_values = $_POST['group_name'];
            $lastspace = strrpos($center_values, ' ');
            $lastword = substr($center_values, $lastspace);
            $firstchunk = substr($center_values, 0, $lastspace);
            $groupId = $lastword;
            $centerName = $firstchunk;
            $ls = strrpos($centerName, ' ');
            $lw = substr($centerName, $ls);
            $fc = substr($centerName, 0, $ls);        
            $n = 1;
            $groupName = $lw;
            $centerName = $fc;
            $lw = str_replace(" ", "", "$lw", $n);
            //echo $lw;
            //$group_name = $branchName.'_'.$centerName.'_'.$groupName;
            $group_name = $groupName;
            $centerid = "SELECT center_id FROM centers WHERE center_name = '$centerName'";
            $centerid = mysqli_query($connect, $centerid);
            $row = mysqli_fetch_array($centerid);
                $centerid = implode(",",$row);
                $centerid = substr($centerid, 0, strpos($centerid, ","));
                
                $getBranchName = "SELECT branch_name FROM centers WHERE center_name = '$centerName'";
                $getBranchName = mysqli_query($connect, $getBranchName);
                $branchName = mysqli_fetch_array($getBranchName);
                $branchName = implode(', ', $branchName);
                $branchName = substr($branchName, 0, strpos($branchName, ','));
                
                $getBranchId = "SELECT branch_id FROM branches WHERE branch_name = '$branchName'";
                $getBranchId = mysqli_query($connect, $getBranchId);
                $branchId = mysqli_fetch_array($getBranchId);
                $branchId = implode(', ', $branchId);
                $branchId = substr($branchId, 0, strpos($branchId, ','));
            
        $check_database_query = mysqli_query($connect, "SELECT * FROM customers ORDER BY id DESC");
        $check_login_query = mysqli_num_rows($check_database_query);
        $customerId = $check_login_query + 1;
        //define ID
        $id = $branchId.'/'.$centerid.'/'.$groupId.'/'.$customerId;
        //add to database
        $due_date = date('Y-m-d', strtotime($disbarsmentDate.'+35 Days'));

        $phone_check = mysqli_query($connect, "SELECT phone_number FROM customers WHERE phone_number='$phoneNumber'");
        $num_rows = mysqli_num_rows($phone_check);

        if ($num_rows > 0) {
            echo "Customer Already exists";
        }else {
            $query = "INSERT INTO customers VALUES ('', '$customerName', '$businessTitle', '$group_name', '$id', '$age', '$date', '$phoneNumber')";
        
        if (mysqli_query($connect, $query)) {
            echo "Customer Added Succesfully";
        }else {
            $error = mysqli_error($connect);
            echo 'There was an error '.$error;
        }
        $query = "INSERT INTO active_loans VALUES ('', '$customerName','$id', '$businessTitle', '$amount', '$amountToPay', '$installmentAmount', '$disbarsmentDate', '$due_date', '$cycleNumber')";
        
        if (mysqli_query($connect, $query)) {
            header('Location: customer_profile.php?id='.$customerId);
        }else {
            $error = mysqli_error($connect);
            echo 'There was an error '.$error;
        }
        }
    }
}
?>