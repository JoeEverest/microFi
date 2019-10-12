<?php
$customerName ='';
$businessTitle ='';
$phoneNumber ='';
$cycleNumber ='';
$age ='';
$amount ='';
$date ='';
$disbarsmentDate ='';
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

        //define ID
        //add to database
        //$query = "INSERT INTO movies VALUES ('', '$name', '$year', '$dlink', '$imdb', '$tlink', '$description', '$category', '$image')";

    }
}
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