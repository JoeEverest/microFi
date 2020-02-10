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

?>