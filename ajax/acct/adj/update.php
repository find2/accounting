<?php
if (isset($_POST)) {
    require '../lib.php';
	
	$time = date("Y-m-d h:i:sa");
    $id = $_POST['id'];
    $item = $_POST['item'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];
	$debet=$credit=0;
	if($type=="Debet")
		$debet=$balance;
	else
		$credit=$balance;
    $object = new Adjustment();
 
    $object->Update($item, $code, $debet, $credit, $time, $id);
}