<?php include_once 'db.php';
$movie = $_GET['movie'];
$date=$_GET['date'];

for($i=1;$i<=5;$i++){
    echo "<option value='{$sess[$i]}'>{$sess[$i]} 剩餘座位 20</option>";
}



