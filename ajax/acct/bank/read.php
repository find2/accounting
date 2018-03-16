<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$bank_name=$_POST['bank_name'];
$ledger=$_POST['ledger'];
$object = new Bank();
$users = $object->Read($month, $year, $filter, $object->month($month), $bank_name, $ledger);
$cash= $object->Read_Opening($month, $year, $bank_name, $ledger);
$saldo=$debet=$credit=0;
$data = $object->table($month, $year);
$number = 1;
if(count($cash) > 0){
	foreach($cash as $c){
		$data .= $object->bank_data($c['balance'], $bank_name);
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
		$data .= $object->show_data($number, $user['date'], $user['trx'], $user['item'], $user['code'], $object->Read_Name($month, $year, $user['code'], $ledger), $user['debet'], $user['credit'],$saldo, $user['remark'], $user['id']);
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