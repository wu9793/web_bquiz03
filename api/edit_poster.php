<?php include_once "db.php";

foreach($_POST['id'] as $idx => $id){
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $Poster->del($id);
    }else{
        $row=$Poster->find($id);
        $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;
        $row['name']=$_POST['name'][$idx];
        $row['ani']=$_POST['ani'][$idx];
        $Poster->save($row);
    }
}
to("../back.php?do=poster");