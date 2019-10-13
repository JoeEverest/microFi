<?php
include('config/config.php');

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
    <?php
    $id = $_GET['id'];
    $extract = "SELECT * FROM branches WHERE id = '$id' ORDER BY id DESC";
            $execute = mysqli_query($connect, $extract);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $id = $dataRows["id"];
                $name = $dataRows["branch_name"];
                $uniqueId = $dataRows["branch_id"];
    
    ?>
    <p><?php echo $name; ?></p>
    <?php } ?>
</body>
</html>