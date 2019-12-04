<?php
if (isset($_POST['submit'])) {
    if (!$_POST['first_name'] | !$_POST['middle_name'] | !$_POST['last_name'] | !$_POST['businessTitle'] | !$_POST['phone'] | !$_POST['age']) {
        echo 'Some fields are empty';
    }
    else{
        $customerName = $_POST['first_name']." ".$_POST['middle_name']." ".$_POST['last_name'];
        $businessTitle = $_POST['businessTitle'];
        $businessTitle = urlencode($businessTitle);
        $phoneNumber = $_POST['phone'];
        $age = $_POST['age'];
        $date = date('y-m-d');

        $groupId = $_POST['group_name'];
        //get center name and id using group id
        $getGroup = "SELECT * FROM groups WHERE group_id = '$groupId' ORDER BY id DESC";
        $getGroup = mysqli_query($connect, $getGroup);
        while ($grp = mysqli_fetch_array($getGroup)) {
            $centername = $grp['center_name'];
            $group_name = $grp['group_name'];

            $getCenter = "SELECT * FROM centers WHERE center_name = '$centername' ORDER BY id DESC";
            $getCenter = mysqli_query($connect, $getCenter);
            while ($cntr = mysqli_fetch_array($getCenter)) {
                $branchname = $cntr['branch_name'];
                $centerId = $cntr['center_id'];
                
                $getBranch = "SELECT * FROM branches WHERE branch_name = '$branchname' ORDER BY id DESC";
                $getBranch = mysqli_query($connect, $getBranch);
                while ($row = mysqli_fetch_array($getBranch)) {
                    $branchId = $row['branch_id'];
                }

            }

        }

        
        
        
        
        $check_database_query = mysqli_query($connect, "SELECT * FROM customers ORDER BY id DESC");
        $check_login_query = mysqli_num_rows($check_database_query);
        $customerId = $check_login_query + 1;
        //define ID
        $id = $branchId.'/'.$centerId.'/'.$groupId.'/'.$customerId;
        //add to database

        $phone_check = mysqli_query($connect, "SELECT phone_number FROM customers WHERE phone_number='$phoneNumber'");
        $num_rows = mysqli_num_rows($phone_check);

        if ($num_rows > 0) {
            echo "Customer Already exists";
        }else {
            $query = "INSERT INTO customers VALUES ('', '$customerName', '$businessTitle', '$group_name', '$centername', '$branchname','$id', '$age', '$date', '$phoneNumber')";
        
        if (mysqli_query($connect, $query)) {
            header("Location: customer_profile.php?id=$id");
        }else {
            $error = mysqli_error($connect);
            echo 'There was an error '.$error;
        }
        }
    }
}
?>