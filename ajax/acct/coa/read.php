<?php
//session_start();
require '../lib.php';
$month = $_POST['month'];
$year = $_POST['year'];
$ledger = $_POST['ledger']; 

$object = new COA();
$coas = $object->Read($month, $year, $ledger);
$debet=$debet2=$debet3=$credit=$credit2=$credit3=0;

$data = $object->table($month, $year);
$status="Not Balance";
if (count($coas) > 0) {
    $number = 1;
    foreach ($coas as $coa) {
		$data .= $object->show_data($number, $coa['code'], $coa['name'], $coa['type'], $coa['balance'], $coa['id'], $coa['ledger']);
		$number++;
		if($coa['code']<20000){
			if($coa['type']=="Debet")
				$debet2+=$coa['balance'];
			else
				$credit2+=$coa['balance'];
		}
		else{
			if($coa['type']=="Debet")
				$debet3+=$coa['balance'];
			else
				$credit3+=$coa['balance'];
		}
    }
	if($number==1) {
		// records not found
		$data .= '<tr><td colspan="8">Records not found!</td></tr>';
	}
}
$data .= '</tbody></table></div>';

$debet=$debet2-$credit2;
$credit=$credit3-$debet3;
if($debet==$credit)
	$status="Balance";
if($debet>$credit)
	$defisit=$debet-$credit;
else
	$defisit=$credit-$debet;

$data2 =$object->result($number, $status, $debet, $credit, $defisit);
$data .= '
	<div id="result">
		'. $data2 .'
	</div>
';
echo $data;

?>