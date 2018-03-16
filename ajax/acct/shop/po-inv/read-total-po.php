<?php
//session_start();
require '../lib.php';
$object = new Item_Po_Inv();
$id = $_POST['id'];
$data = $object->Read_Total_PO($id);
echo $data;
?>