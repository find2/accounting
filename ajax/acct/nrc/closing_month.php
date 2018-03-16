<?php
require 'lib.php';

$object = new CRUD();

$month=$_POST['month'];
$year=$_POST['year'];
$filter=$_POST['filter'];
$ledger=$_POST['ledger'];

$month2=$object->check_month($month);
$year2=$year+$object->check_year($month2);
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
$total1=$total2=$total3=$total4=$total5=0;$check1=$check2=$check3=$check4=$check5=false;
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
		if($code['code']<12000){
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
			// Checkpoint
			else{
				if($code['code']=="10011"){
					foreach($codes2 as $coa2){
						if($coa2['code']!="10000"){
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
		else if($code['code']>=13020)
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
		if($code['code']!=32010)
			$create_left=true;
		else{
			//PL Start
			$create_left2=true;
			foreach($codes_pl as $code_pl){
				$debet_pl=$credit_pl=$balance_pl=0;$create_left_pl=$create_right_pl1=$create_right_pl2=false;
				//Start Total Revenue
				if($code_pl['code']>40000 && $code_pl['code']<50000){
					$create_right_pl1=true;
				}	
				//End Total Revenue	
				else if($code_pl['code']>50000 && $code_pl['code']<60000){
					if($check1_pl){
						$check1_pl=false;
						$data .=$object->show1($total1_pl);
					}
					$create_left_pl=true;
				}
				else{
					if($check2_pl){
						$check2_pl=false;
					}
					$create_right_pl2=true;
				}
				
				if($create_left_pl || $create_right_pl1 || $create_right_pl2){
					//From Cash
					$cashs2=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $code_pl['code']);
					foreach($cashs2 as $cash2){
						if($cash2['debet']>0)
							$credit_pl+=$cash2['debet'];
						else
							$debet_pl+=$cash2['credit'];
					}
					//From Bank
					$banks2=$object->Read_Bank_Data2($month, $year, $filter, $object->month($month), $code_pl['code']);
					foreach($banks2 as $bank2){
						if($bank2['debet']>0)
							$credit_pl+=$bank2['debet'];
						else
							$debet_pl+=$bank2['credit'];
					}
					//From Adjustment
					$adjs=$object->Read_Adj_Data($month, $year, $code_pl['code']);
					foreach($adjs as $adj){
						if($adj['credit']>0)
							$credit_pl+=$adj['credit'];
						else
							$debet_pl+=$adj['debet'];
					}
					if($code_pl['type']== "Debet")
						$balance_pl=$code_pl['balance']+$debet_pl-$credit_pl;
					else
						$balance_pl=$code_pl['balance']+$credit_pl-$debet_pl;
					
					$total_debet_pl+=$debet_pl;$total_credit_pl+=$credit_pl;$total_balance_pl+=$balance_pl;$total_opening_pl+=$code_pl['balance'];
					//Create Data
					if($create_left_pl){
						$total2_pl+=$balance_pl;
					}
					else if($create_right_pl1){
						$total1_pl+=$balance_pl;
					}
					else{
						if($code_pl['code']=="61010")
							$total3_pl+=$balance_pl;
						else
							$total3_pl-=$balance_pl;
							
					}
				}
			}
			$result_pl=$total1_pl-$total2_pl;
			$result2_pl=$result_pl+$total3_pl+$code['balance'];
			// End PL
		}
		
	}
	
if($create_left || $create_right || $create_left2 || $create_right2){
		//From Cash
		if($create_left || $create_right){
			$cashs2=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $code['code']);
			foreach($cashs2 as $cash2){
				if($cash2['debet']>0)
					$credit+=$cash2['debet'];
				else
					$debet+=$cash2['credit'];
			}
			//From Bank
			$banks2=$object->Read_Bank_Data2($month, $year, $filter, $object->month($month), $code['code']);
			foreach($banks2 as $bank2){
				if($bank2['debet']>0)
					$credit+=$bank2['debet'];
				else
					$debet+=$bank2['credit'];
			}
			//From Adjustment
			$adjs=$object->Read_Adj_Data($month, $year, $code['code']);
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
				$object->Create($code['code'], $code['name'], $code['type'], $balance,"", $month2, $year2);
				if($code['code']==13020)
					$total1+=$balance;
				else if($code['code']==13030)
					$total2+=$balance;
				else if($code['code']==13040)
					$total3+=$balance;
				else if($code['code']==13021){
					$total1-=$balance;
					$total_left_table+=$total1;
					$data.=$object->show1($total1);
				}
				else if($code['code']==13031){
					$total2-=$balance;
					$total_left_table+=$total2;
					$data.=$object->show2($total2);
				}
				else if($code['code']==13041){
					$total3-=$balance;
					$total_left_table+=$total3;
					$data.=$object->show3($total3);
				}
			}
			else{
				$object->Create($code['code'], $code['name'], $code['type'], $balance,"", $month2, $year2);
				$total_left_table+=$balance;
			}
		}
		else{
			if($create_left){
				$object->Create($code['code'], $code['name'], $code['type'], $balance,"", $month2, $year2);
				if($code['code']==21010 || $code['code']==21020 || $code['code']==21030 || $code['code']==21040 || $code['code']==21090){
					$total4+=$balance;
					if($code['code']==21090)
						$data.=$object->show4($total4);
				}
				else{
					if($code['code']==31090)
						$total5-=$balance;
					else{
						if($code['code']==32090){
							$total5+=$balance;
							$data.=$object->show5($total5);
						}
						else
							$total5+=$balance;
					}
				}
			}
			//PL
			else{
				$object->Create($code['code'], $code['name'], $code['type'], $result2_pl,"", $month2, $year2);
				$total5+=$result2_pl;
			}
		}
	}
}
$total_right_table=$total4+$total5;
$data .=$object->result_right($total_right_table);
$data .=$object->end_data($total_left_table, $total_right_table);

$codes=$object->Read_Code_Closing($month, $year);
foreach($codes as $code){
	$object->Create($code['code'], $code['name'], $code['type'], 0,"", $month2, $year2);
}

//echo $data;
 
?>