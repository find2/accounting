<?php
//session_start();
require '../lib.php';
$object = new Billing();
$id = $_POST['id'];
$data = $object->Read_Total_Billing($id);
echo $data;
?>