<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$ledger=$_POST['ledger'];
$object = new NS();

$codes=$object->Read_Code($month, $year, $ledger);
$codes2=$object->Read_Code($month, $year, $ledger);
$bank_list=$object->Read_Bank($month, $year, $ledger);

$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; $temu=false;

$data = $object->table($month, $year);

foreach($codes as $code){
	//Start of all
	$temu=false; $debet=$credit=$balance=0;
	//Mencari di Bank
	foreach($bank_list as $bl){
		if($code['code'] == $bl['code']){
			$temu=true;
			foreach($codes2 as $coa){
				$banks=$object->Read_Bank_Data($month, $year, $filter, $object->month($month), $code['name'], $coa['code'], $ledger);
				foreach($banks as $bank){
					if($bank['credit']>0)
						$credit+=$bank['credit'];
					else
						$debet+=$bank['debet'];
				}
			}
		}
	}
	//End Bank
	//Start cash on hands
	if($temu){
		if($code['type']=="Credit")
			$balance=$code['balance']+$credit+$debet;
		else
			$balance=$code['balance']+$debet-$credit;
	}
	//If Bank Tidak nemu
	else{
		if($code['code']<"10200"){
			foreach($codes as $coa2){
				if($coa2['code']>"10200"){
					$cashs=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $coa2['code'], $code['ledger']);
					foreach($cashs as $cash){
						if($cash['credit']>0)
							$credit+=$cash['credit'];
						else
							$debet+=$cash['debet'];
					}
				}
			}
		}
		else{
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
		}
		if($code['type']== "Debet")
			$balance=$code['balance']+$debet-$credit;
		else
			$balance=$code['balance']+$credit-$debet;
	}
	$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
	$data.= $object->show_data($code['code'], $code['name'], $code['type'], $code['balance'], $debet, $credit, $balance);
}
$data .= '</tbody></table></div>';
$data .=$object->result($total_opening, $total_debet, $total_credit, $total_balance);

echo $data;
 
?>