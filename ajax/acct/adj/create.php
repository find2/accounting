<?php
session_start();
if (isset($_POST['code']) ) {
    require("../lib.php");
	$time = date("Y-m-d h:i:sa");
    $item = $_POST['item'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $balance = $_POST['balance'];
    $type = $_POST['type'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $ledger = $_POST['ledger'];
	$debet=$credit=0;
	if($type=="Debet")
		$debet=$balance;
	else
		$credit=$balance;
    $object = new Adjustment();
    $object->Create($item, $code, $debet, $credit, $month, $year, $time, $ledger);
}
?>