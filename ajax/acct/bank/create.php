<?php
session_start();
if (isset($_POST['date']) ) {
    require("../lib.php");
	$time = date("Y-m-d h:i:sa");
    $date = $_POST['date'];
    $trx = $_POST['trx'];
    $item = $_POST['item'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $balance = $_POST['balance'];
    $type = $_POST['type'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $remark = $_POST['remark'];
    $bank_name = $_POST['bank_name'];
    $ledger = $_POST['ledger'];
	$debet=$credit=0;
	if($type=="Debet")
		$debet=$balance;
	else
		$credit=$balance;
    $object = new Bank();
    $object->Create($date, $trx, $item, $code, $debet, $credit, $month, $year, $time, $remark, $bank_name, $_SESSION['username'], $ledger);
}
?>