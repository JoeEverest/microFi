<?php 
$host = 'localhost';
$loginUser = 'root';
$loginPassword = '';
$dbName = 'microfinance';
$connect = mysqli_connect($host, $loginUser, $loginPassword, $dbName);//Connection variable

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}
	$getInterest = 'SELECT value FROM settings WHERE id = 1';
	$getInterest = mysqli_query($connect, $getInterest); 
	while ($row = mysqli_fetch_array($getInterest)) {
		$interestVar = $row['value'];
	}
	$_SESSION['interest'] = $interestVar;
	$intrest = $_SESSION['interest'];

	$getLoanFee = 'SELECT value FROM settings WHERE id = 2';
	$getLoanFee = mysqli_query($connect, $getLoanFee); 
	while ($row = mysqli_fetch_array($getLoanFee)) {
		$applicationFee = $row['value'];
	}
	$_SESSION['fee'] = $applicationFee;
	$applicationFee = $_SESSION['fee'];
?>