<?php
session_start();
if (isset($_POST['date']) ) {
    require '../lib.php';
	$time = date("Y-m-d h:i:sa");
    $date = $_POST['date'];
    $kwit = $_POST['kwit'];
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
    $object = new Cash();
    $object->Create($date, $kwit, $item, $code, $debet, $credit, $month, $year, $time, $_SESSION['username'], $ledger);
    
}
?>