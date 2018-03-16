<?php
session_start();
if (isset($_POST['name']) ) {
    require("../lib.php");
	//$tanggal = date("Y-m-d h:i:sa");
    $code = $_POST['code'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $ledger = $_POST['ledger'];
    $object = new COA();
    Echo $object->Create($code, $name, $type, $balance, $month, $year, $ledger);
}
?>