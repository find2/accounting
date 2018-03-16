<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$ledger=$_POST['ledger'];

$object = new Cash();
$users = $object->Read($month, $year, $filter, $object->month($month), $ledger);
$cash= $object->Read_Cash($month, $year, $ledger);
$saldo=$debet=$credit=0;
$data = $object->table($month, $year);
$number = 1;
if(count($cash) > 0){
	foreach($cash as $c){
		$data .= $object->cash_data($c['balance']);
		$saldo+=$c['balance'];$debet+=$c['balance'];
		$number++;
	}
}
if(count($users) > 0) {
    foreach ($users as $user) {
		if($user['debet']!=0){
			$saldo+=$user['debet'];
			$debet+=$user['debet'];
		}
		else{
			$saldo-=$user['credit'];
			$credit+=$user['credit'];
		}
		$data .= $object->show_data($number, $user['date'], $user['kwit'], $user['item'], $user['code'], $object->Read_Name($month, $year, $user['code'], $ledger), $user['debet'], $user['credit'],$saldo, $user['id']);
		$number++;
    }
	if($number==1) {
		// records not found
		$data .= '<tr><td colspan="8">Records not found!</td></tr>';
	}
}
$data .= '</tbody></table></div>';

$data .=$object->result($debet, $credit, $saldo);

echo $data;
 
?>