<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$name=$_POST['name'];
$type=$_POST['type'];
$ledger=$_POST['ledger'];

$object = new Journal();

$saldo=$debet=$credit=0;
$data = $object->table($month, $year, $type, $name);
$number = 1;

if($name==1){
	$coas= $object->Read_Coa_Cash($month, $year, $ledger);
	if($type==1){
		foreach($coas as $coa){
			$cashs = $object->Read_Cash_Data($month, $year, $filter, $object->month($month), $coa['code'], $type, $ledger);
			foreach($cashs as $cash)
				$credit+=$cash['debet'];
			$data.=$object->show_data("Incoming Cash on Hand", $coa['code'], $coa['name'], $debet, $credit);
			$saldo+=$credit;
			$credit=0;
		}
	}
	else{
		foreach($coas as $coa){
			$cashs = $object->Read_Cash_Data($month, $year, $filter, $object->month($month), $coa['code'], $type, $ledger);
			foreach($cashs as $cash)
				$debet+=$cash['credit'];
			$data.=$object->show_data("Outgoing Cash on Hand", $coa['code'], $coa['name'], $debet, $credit);
			$saldo+=$debet;
			$debet=0;
		}
	}
}
else{
	$coas= $object->Read_Coa_Bank($month, $year, $name, $ledger);
	if($type==1){
		foreach($coas as $coa){
			$banks = $object->Read_Bank_Data($month, $year, $filter, $object->month($month), $name, $coa['code'], $type, $ledger);
			foreach($banks as $bank)
				$credit+=$bank['debet'];
			$data.=$object->show_data("Incoming ".$name, $coa['code'], $coa['name'], $debet, $credit);
			$saldo+=$credit;
			$credit=0;
		}
	}
	else{
		foreach($coas as $coa){
			$banks = $object->Read_Bank_Data($month, $year, $filter, $object->month($month), $name, $coa['code'], $type, $ledger);
			foreach($banks as $bank)
				$debet+=$bank['credit'];
			$data.=$object->show_data("Outgoing ".$name, $coa['code'], $coa['name'], $debet, $credit);
			$saldo+=$debet;
			$debet=0;
		}
	}
}

$data .= '</tbody></table></div>';
$data .=$object->result($debet, $credit, $name, $type, $saldo);

echo $data;
 
?>