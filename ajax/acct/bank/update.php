<?php
if (isset($_POST)) {
    require '../lib.php';
	
	$time = date("Y-m-d h:i:sa");
    $id = $_POST['id'];
    $date = $_POST['date'];
    $trx = $_POST['trx'];
    $item = $_POST['item'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];
    $remark = $_POST['remark'];
	$debet=$credit=0;
	if($type=="Debet")
		$debet=$balance;
	else
		$credit=$balance;
    $object = new Bank();
 
    $object->Update($date, $trx, $item, $code, $debet, $credit, $time, $remark, $_SESSION['username'], $id);
}