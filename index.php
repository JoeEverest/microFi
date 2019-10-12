<?php
session_start();

if (isset($_SESSION['operator_name'])) {
    $userLoggedIn = $_SESSION['operator_name'];   
}
else{
	header("Location: login.php");
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
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ex, alias! Temporibus dicta ad vel dolorum earum fuga minus vero accusantium veniam recusandae, dolorem necessitatibus, accusamus eos culpa excepturi ex praesentium.
</body>
</html>