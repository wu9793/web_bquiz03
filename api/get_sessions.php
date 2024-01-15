<?php include_once 'db.php';
$movie = $_GET['movie'];
$date=$_GET['date'];
$H=date("G");
$start=($H>=14 && $date==date("Y-m-d"))?7-ceil((24-$H)/2):1;

for($i=$start;$i<=5;$i++){
    echo "<option value='{$sess[$i]}'>{$sess[$i]} 剩餘座位 20</option>";
}



