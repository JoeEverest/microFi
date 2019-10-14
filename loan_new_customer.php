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
        //$date = str_replace("-", "", "$date", $i);
        //$disbarsmentDate = str_replace("-", "", "$disbarsmentDate", $i);

        $branch_values = $_POST['branchName'];
            $last_space = strrpos($branch_values, ' ');
            $last_word = substr($branch_values, $last_space);
            $first_chunk = substr($branch_values, 0, $last_space);

            $branchId = $last_word;
            $branchName = $first_chunk;

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
            echo $lw;
            //$group_name = $branchName.'_'.$centerName.'_'.$groupName;
            $group_name = $groupName;

            $centerid = "SELECT center_id FROM centers WHERE center_name = '$centerName'";
            $centerid = mysqli_query($connect, $centerid);

            $row = mysqli_fetch_array($centerid);
                $centerid = implode(",",$row);
                $centerid = substr($centerid, 0, strpos($centerid, ","));
            
        $check_database_query = mysqli_query($connect, "SELECT * FROM customers ORDER BY id DESC");
        $check_login_query = mysqli_num_rows($check_database_query);

        $customerId = $check_login_query + 1;
        //define ID
        $id = $branchId.'/'.$centerid.'/'.$groupId.'/'.$customerId;
        //add to database
        $due_date = date('y-m-d');

        $query = "INSERT INTO customers VALUES ('', '$customerName', '$businessTitle', '$group_name', '$cycleNumber', '$id', '$age', '$amount', '$date', '$disbarsmentDate', '$due_date', '$phoneNumber')";
        
        if (mysqli_query($connect, $query)) {
        }else {
            $error = mysqli_error($connect);
            echo 'There was an error '.$error;
        }
        $query = "INSERT INTO active_loans VALUES ('', '$customerName','$id', '$businessTitle', '$amount', '$disbarsmentDate', '$due_date')";
        
        if (mysqli_query($connect, $query)) {
        }else {
            $error = mysqli_error($connect);
            echo 'There was an error '.$error;
        }
    }
}
$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

    $getGroup = 'SELECT * FROM groups ORDER BY id DESC';
    $getGroup = mysqli_query($connect, $getGroup);

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
    <form method="post">
        <label for="name">Full Name:</label><br>
        <input required type="text" name="name" placeholder="John Alex Doe"><br>
        <label for="businessTitle">Business Title:</label><br>
        <input required type="text" name="businessTitle" placeholder="Business Title"><br>
        <label for="phone">Phone Number:</label><br>
        <input required type="number" name="phone" placeholder="Phone Number"><br>
        <label for="numberOfCycle">Number Of Cycle:</label><br>
        <input required type="number" name="numberOfCycle" placeholder="Number Of Cycle"><br>
        <label for="age">Age:</label><br>
        <input required type="number" name="age" placeholder="Age"><br>
        Branch Name:
        <select required name="branchName">
            <?php
            while ($row = mysqli_fetch_array($retrieve)) {
                $id = $row['id'];
                $name = $row['branch_name'];
                $uniqueId = $row['branch_id'];
            
            ?>
            <option value="<?php echo $name.' '.$uniqueId; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select><br>
        Group Name:
        <select name="group_name">
        <?php
            while ($row = mysqli_fetch_array($getGroup)) {
                $id = $row['id'];
                $groupname = $row['group_name'];
                $centername = $row['center_name'];
                $groupId = $row['group_id'];
               
        ?>
            <option value="<?php echo $centername.' '.$groupname.' '.$groupId; ?>"><?php echo $centername.'-'.$groupname; ?></option>
        <?php } ?>
        </select><br>
        <label for="amount">Loan Amount:</label><br>
        <input required type="number" name="amount" placeholder="Loan Amount"><br>
        <label for="disbarsmentDate">Disembursment Date:</label><br>
        <input required type="date" name="disbarsmentDate" placeholder=""><br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>