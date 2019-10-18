<?php
session_start();
include('config/config.php');
include('header.php');

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
}
include('handlers/register_customer_handler.php');
$retrieve = 'SELECT * FROM branches ORDER BY id DESC';
$retrieve = mysqli_query($connect, $retrieve);
    $getGroup = 'SELECT * FROM groups ORDER BY id DESC';
    $getGroup = mysqli_query($connect, $getGroup);
?>
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