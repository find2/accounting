<?php
//session_start();
require '../lib.php';

function Get_PL(){
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
			if($create_left){
				$data.= $object->show_data_left($code['code'], $code['name'], $balance);
				$total2+=$balance;
			}
			else if($create_right1){
				$data.= $object->show_data_right($code['code'], $code['name'], $balance);
				$total1+=$balance;
			}
			else{
				$data.= $object->show_data_right($code['code'], $code['name'], $balance);
				
				if($code['code']=="61001" || $code['code']=="62001" || $code['code']=="63001" || $code['code']=="64001" || $code['code']=="65001" || $code['code']=="66001")
					$total3+=$balance;
				else if($code['code']=="61002" || $code['code']=="62002" || $code['code']=="63002" || $code['code']=="64002" || $code['code']=="65002" || $code['code']=="66002")
					$total3-=$balance;
			}
		}
	}
	$result=$total1-$total2;
	$result2=$result+$total3;
	return $result2;
}

$month=$_POST['month'];
$ledger=$_POST['ledger'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$object = new NRC();

$codes=$object->Read_Code($month, $year, $ledger);
$codes2=$object->Read_Code2($month, $year, $ledger);
$bank_list=$object->Read_Bank($month, $year, $ledger);
//PL
$codes_pl=$object->Read_Code_Pl($month, $year, $ledger);

$balance_pl=$debet_pl=$credit_pl=$total_balance_pl=$total_debet_pl=$total_credit_pl=$total_opening_pl=0; $temu_pl=false;

$total1_pl=$total2_pl=$total3_pl=0;$check1_pl=$check2_pl=true;$create_left_pl=$create_right_pl1=$create_right_pl2=false;

//End PL
$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; 
$temu=false; $end_table_left=false;
$total1=$total2=$total3=$total4=$total5=$total6=$total7=0;$check1=$check2=$check3=$check4=$check5=false;
$total_left_table=$total_right_table=0;
$left=$right=false;
$create_left=$create_right=$create_right2=$create_left2=false;
$data = $object->table_left($month, $year);
foreach($codes as $code){
	$temu=false;
	$debet=$credit=$balance=0;$create_left=$create_right=$create_left2=$create_right2=$left=$right=false;
	//Start Total Revenue
	if($code['code']<20000){
		$left=true;
		if($code['code']<10300){
			$create_right2=true;
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
					foreach($codes2 as $coa2){
						if($coa2['code']>"10200"){
							$cashs=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $coa2['code'], $ledger);
							foreach($cashs as $cash){
								if($cash['credit']>0)
									$credit+=$cash['credit'];
								else
									$debet+=$cash['debet'];
							}
						}
					}
				}
				if($code['type']== "Debet")
					$balance=$code['balance']+$debet-$credit;
				else
					$balance=$code['balance']+$credit-$debet;
			}
			$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
		}
		else if($code['code']>=10500)
			$create_left=true;
		else
			$create_right=true;
	}
	//Right Side Table
	else{
		$right=true;
		if(!$end_table_left){
			$end_table_left=true;
			$data .=$object->result_left($total_left_table);
			$data .= $object->table_right();
		}
		if($code['code']!=30103 || $code['code']!=30203 || $code['code']!=30303 || $code['code']!=30403 || $code['code']!=30503 || $code['code']!=30603)
			$create_left=true;
		else{
		}
	}
	
if($create_left || $create_right || $create_left2 || $create_right2){
		//From Cash
		if($create_left || $create_right){
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
			if($code['type']== "Debet")
				$balance=$code['balance']+$debet-$credit;
			else
				$balance=$code['balance']+$credit-$debet;
			
			$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
		}
		//Create Data left table
		if($left){
			if($create_left){
				if($balance!=0)
					$data.= $object->show_data_left($code['code'], $code['name'], $balance);
				if($code['code']==10501)
					$total1+=$balance;
				else if($code['code']==10503)
					$total2+=$balance;
				else if($code['code']==10505)
					$total3+=$balance;
				else if($code['code']==10507)
					$total4+=$balance;
				else if($code['code']==10509)
					$total5+=$balance;
				else if($code['code']==10502){
					$total1-=$balance;
					$total_left_table+=$total1;
					if($total1>0)
						$data.=$object->show1($total1);
				}
				else if($code['code']==10504){
					$total2-=$balance;
					$total_left_table+=$total2;
					if($total2>0)
						$data.=$object->show1($total2);
				}
				else if($code['code']==10506){
					$total3-=$balance;
					$total_left_table+=$total3;
					if($total3>0)
						$data.=$object->show1($total3);
				}
				else if($code['code']==10508){
					$total4-=$balance;
					$total_left_table+=$total4;
					if($total4>0)
						$data.=$object->show1($total4);
				}
				else if($code['code']==10510){
					$total5-=$balance;
					$total_left_table+=$total5;
					if($total5>0)
						$data.=$object->show1($total5);
				}
			}
			else{
				if($balance!=0)
					$data.= $object->show_data_right($code['code'], $code['name'], $balance);
				$total_left_table+=$balance;
			}
		}
		// DISINI
		else{
			if($create_left){
				if($balance!=0)
					$data.= $object->show_data_left($code['code'], $code['name'], $balance);
				if($code['code']>=20000 && $code['code']<=30000){
					$total6+=$balance;
					// if($code['code']==21090)
					// 	$data.=$object->show4($total6);
				}
				else if($code['code']==30103 || $code['code']==30203 || $code['code']==30303 || $code['code']==30403 || $code['code']==30503 || $code['code']==30603){
					// $pl = Get_PL();
					$pl = Get_PL();
					// $data.= $object->show_data_left($code['code'], $code['name'], $result2_pl);
					// $total7+=$result2_pl; 
					if($pl!=0)
						$data.= $object->show_data_left($code['code'], $code['name'], $pl);
					$total7+=$pl; 
				} 
				else{
					if($code['code']==30101 || $code['code']==30201 || $code['code']==30301 || $code['code']==30401 || $code['code']==30501 || $code['code']==30601)
						$total7+=$balance; // ubah
					else{
						// if($code['code']==32090){
						// 	$total7+=$balance;
						// 	// $data.=$object->show5($total7);
						// }
						// else
							$total7+=$balance;
					}
				}
			}
			//PL
			
		} 
	}
}
$total_right_table=$total6+$total7;
$data .=$object->result_right($total_right_table);
$data .=$object->end_data($total_left_table, $total_right_table);
// $pl = Get_PL();

echo $data;
 
?>