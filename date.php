<?php
$holidays = array();
$today = date('Y-m-d');
$year = date('Y');
$ny = date('Y-m-d', strtotime('first day of january'.$year));
$revolutionZnz = date('Y-m-d', strtotime('12 january'.$year));
$karume = date('Y-m-d', strtotime('7 april'.$year));
$union = date('Y-m-d', strtotime('26 april'.$year));
$workers = date('Y-m-d', strtotime('first day of may'.$year));
$sabasaba = date('Y-m-d', strtotime('7 july'.$year));
$nanenane = date('Y-m-d', strtotime('8 august'.$year));
$nyerere = date('Y-m-d', strtotime('14 october'.$year));
$freedom = date('Y-m-d', strtotime('9 december'.$year));
$christmas = date('Y-m-d', strtotime('25 december'.$year));
$boxing = date('Y-m-d', strtotime('26 december'.$year));

array_push($holidays, $ny, $revolutionZnz, $karume, $union, $workers, $sabasaba, $nanenane, $nyerere, $freedom, $christmas, $boxing);
if(isset($_POST['add_date'])){
    if (!$_POST['add_date']) {
        echo "Date Required";
    }else {
        $d = $_POST['add_date'];
        array_push($holidays, $d);
    }
}

if (in_array($today, $holidays)) {
    echo 'Today is a holiday';
}else{
    echo 'Get TF to work';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Public holiday</title>
</head>
<body>
    <form method="post">
        <label for="date">Holiday Date</label>
        <input required type="date" name="date">
        <button type="submit" name="add_date">Add Holiday</button>
    </form>
</body>
</html>