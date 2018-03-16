<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$ledger=$_POST['ledger'];
$object = new PL();

$codes=$object->Read_Code($month, $year, $ledger);

$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; $temu=false;

$total1=$total2=$total3=0;$check1=$check2=true;$create_left=$create_right1=$create_right2=false;
$data = $object->table($month, $year);
$data .=$object->show0();
foreach($codes as $code){
	$debet=$credit=$balance=0;$create_left=$create_right1=$create_right2=false;
	//Start Total Revenue
	if($code['code']>40000 && $code['code']<50000){
		$create_right1=true;
	}	
	//End Total Revenue	
	else if($code['code']>50000 && $code['code']<60000){
		if($check1){
			$check1=false;
			$data .=$object->show1($total1);
		}
		$create_left=true;
	}
	else{
		if($check2){
			$check2=false;
			$data .=$object->show2($total1, $total2);
		}
		$create_right2=true;
	}
	
	if($create_left || $create_right1 || $create_right2){
		//From Cash
		$cashs2=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $code['code'], $ledger);
		foreach($cashs2 as $cash2){
			if($cash2['debet']>0)
				$credit+=$cash2['debet'];
			else
				$debet+=$cash2['credit'];
		}
		//From Bank
		$banks2=$object->Read_Bank_Data2($month, $year, $filter, $object->month($month), $code['code'], $ledger);
		foreach($banks2 as $bank2){
			if($bank2['debet']>0)
				$credit+=$bank2['debet'];
			else
				$debet+=$bank2['credit'];
		}
		//From Adjustment
		$adjs=$object->Read_Adj_Data($month, $year, $code['code'], $ledger);
		foreach($adjs as $adj){
			if($adj['credit']>0)
				$credit+=$adj['credit'];
			else
				$debet+=$adj['debet'];
		}
		if($code['type'] == "Debet"){
			if($code['code']>60000)
				$balance=$code['balance']-$debet+$credit;
			else
				$balance=$code['balance']+$debet-$credit;
		}
		else{
			if($code['code']>60000)
				$balance=$code['balance']-$credit+$debet;
			else
				$balance=$code['balance']+$credit-$debet;
		}
		
		$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
		//Create Data
		if($create_left && $balance>0){
			$data.= $object->show_data_left($code['code'], $code['name'], $balance);
			$total2+=$balance;
		}
		else if($create_right1 && $balance>0){
			$data.= $object->show_data_right($code['code'], $code['name'], $balance);
			$total1+=$balance;
		}
		else if($create_right2 && $balance>0){
			$data.= $object->show_data_right($code['code'], $code['name'], $balance);
			
			if($code['code']=="61001" || $code['code']=="62001" || $code['code']=="63001" || $code['code']=="64001" || $code['code']=="65001" || $code['code']=="66001")
				$total3+=$balance;
			else if($code['code']=="61002" || $code['code']=="62002" || $code['code']=="63002" || $code['code']=="64002" || $code['code']=="65002" || $code['code']=="66002")
				$total3-=$balance;
		}
	}
}
$data .=$object->show3($total1, $total2, $total3);
$data .= '</tbody></table></div>';

echo $data;
 
?>