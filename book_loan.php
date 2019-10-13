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
    if (!$_POST['name'] | !$_POST['businessTitle'] | !$_POST['phone'] | !$_POST['numberOfCycle'] | !$_POST['age'] | !$_POST['amount'] | !$_POST['date'] | !$_POST['disbarsmentDate']) {
        echo 'Some fields are empty';
    }
    else{
        $customerName = $_POST['name'];
        $businessTitle = $_POST['businessTitle'];
        $phoneNumber = $_POST['phone'];
        $cycleNumber = $_POST['numberOfCycle'];
        $age = $_POST['age'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $disbarsmentDate = $_POST['disbarsmentDate'];

        $i = 2;
        $date = str_replace("-", "", "$date", $i);
        $disbarsmentDate = str_replace("-", "", "$disbarsmentDate", $i);

        $branch_values = $_POST['branchName'];
        echo $branch_values;

        $last_space = strrpos($branch_values, ' ');
        $last_word = substr($branch_values, $last_space);
        $first_chunk = substr($branch_values, 0, $last_space);

        $branchId = $last_word;
        $branchName = $first_chunk;

        $center_values = $_POST['centerName'];
        echo $center_values;

        $lastspace = strrpos($center_values, ' ');
        $lastword = substr($center_values, $lastspace);
        $firstchunk = substr($center_values, 0, $lastspace);

        $centerid = $lastword;
        $centerName = $firstchunk;

        //define ID
        //$id = $branchId.$centerid.$groupId.$customerId
        //add to database
        //$query = "INSERT INTO movies VALUES ('', '$name', '$year', '$dlink', '$imdb', '$tlink', '$description', '$category', '$image')";

    }
}
$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);

    $getCenter = 'SELECT * FROM centers ORDER BY id DESC';
    $getCenter = mysqli_query($connect, $getCenter);

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
        Center Name:
        <select required name="centerName">
            <?php
            while ($row = mysqli_fetch_array($getCenter)) {
                $id = $row['id'];
                $branchname = $row['branch_name'];
                $centername = $row['center_name'];
                $centerId = $row['center_id'];
            
            ?>
            <option value="<?php echo $centername.' '.$centerId; ?>"><?php echo $centername; ?></option>
            <?php } ?>
        </select><br>
        <label for="amount">Loan Amount:</label><br>
        <input required type="number" name="amount" placeholder="Loan Amount"><br>
        <label for="date">Date:</label><br>
        <input required type="date" name="date" placeholder=""><br>
        <label for="disbarsmentDate">Disembursment Date:</label><br>
        <input required type="date" name="disbarsmentDate" placeholder=""><br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>