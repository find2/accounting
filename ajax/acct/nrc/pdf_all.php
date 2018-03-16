<?php
require('../../../fpdf/fpdf.php');
require '../lib.php';
$month=$_GET['month'];
$year=$_GET['year'];
$filter=$_GET['filter'];
// $monarch=$_SESSION['monarch'];
class PDF extends FPDF
{
	// Page header
	
	function Header()
	{
		// Logo
		if($_SESSION['monarch']==01)
			$this->Image('../../images/header/dalung.jpg',10,6,190);
		else if($_SESSION['monarch']==02)
			$this->Image('../../images/header/candidasa.jpg',10,6,190);
		else if($_SESSION['monarch']==04)
			$this->Image('../../images/header/gianyar.jpg',10,6,190);
		else if($_SESSION['monarch']==03)
			$this->Image('../../images/header/singaraja.jpg',10,6,190);
		else if($_SESSION['monarch']==05)
			$this->Image('../../images/header/negara.jpg',10,6,190);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(80);
		// Title
		// Line break
		$this->Ln(30);
	}

	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function FancyTable($month, $year, $filter, $header)
	{
		// Colors, line width and bold font
		$this->SetFillColor(41, 128, 185);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(50, 50, 40, 40);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		$number=1;
		//FROM read.php
		$object = new CRUD();
		
		$codes=$object->Read_Code($month, $year);
		$codes2=$object->Read_Code2($month, $year);
		$bank_list=$object->Read_Bank($month, $year);
		//PL
		$codes_pl=$object->Read_Code_Pl($month, $year);

		$balance_pl=$debet_pl=$credit_pl=$total_balance_pl=$total_debet_pl=$total_credit_pl=$total_opening_pl=0; $temu_pl=false;

		$total1_pl=$total2_pl=$total3_pl=0;$check1_pl=$check2_pl=true;$create_left_pl=$create_right_pl1=$create_right_pl2=false;

		//End PL
		$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; 
		$temu=false; $end_table_left=false;
		$total1=$total2=$total3=$total4=$total5=0;$check1=$check2=$check3=$check4=$check5=false;
		$total_left_table=$total_right_table=0;
		$left=$right=false;
		$create_left=$create_right=$create_right2=$create_left2=false;
		foreach($codes as $code){
			$temu=false;
			$debet=$credit=$balance=0;$create_left=$create_right=$create_left2=$create_right2=$left=$right=false;
			//Start Total Revenue
			if($code['code']<20000){
				$left=true;
				if($code['code']<10030){
					$create_right2=true;
					foreach($bank_list as $bl){
						if($code['code'] == $bl['code']){
							$temu=true;
							foreach($codes2 as $coa){
								$banks=$object->Read_Bank_Data($month, $year, $filter, $object->month($month), $code['name'], $coa['code']);
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
						if($code['code']=="10011"){
							foreach($codes2 as $coa2){
								if($coa2['code']!="10011"){
									$cashs=$object->Read_Cash_Data($month, $year, $filter, $object->month($month), $coa2['code']);
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
						//$data.= $object->show_data_left($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						
						if($code['code']==13020)
							$total1+=$balance;
						else if($code['code']==13030)
							$total2+=$balance;
						else if($code['code']==13040)
							$total3+=$balance;
						else if($code['code']==13021){
							$total1-=$balance;
							$total_left_table+=$total1;
							//$data.=$object->show1($total1);
							$this->SetFont('Arial','',10);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total1,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
							$this->SetFont('Arial','',7);
						}
						else if($code['code']==13031){
							$total2-=$balance;
							$total_left_table+=$total2;
							//$data.=$object->show2($total2);
							$this->SetFont('Arial','',10);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total2,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
							$this->SetFont('Arial','',7);
						}
						else if($code['code']==13041){
							$total3-=$balance;
							$total_left_table+=$total3;
							//$data.=$object->show3($total3);
							$this->SetFont('Arial','',10);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total3,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
							$this->SetFont('Arial','',7);
						}
					}
					else{
						//$data.= $object->show_data_right($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,"",'LR',0,'L',$fill);
						$this->Cell($w[3],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						
						$total_left_table+=$balance;
					}
				}
				else{
					if($create_left){
						//$data.= $object->show_data_left($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						if($code['code']==21010 || $code['code']==21020 || $code['code']==21030 || $code['code']==21040 || $code['code']==21090){
							$total4+=$balance;
							if($code['code']==21090){
								//$data.=$object->show4($total4);
								$this->SetFont('Arial','',10);
								$this->Cell($w[0],6,"",'LR',0,'L',$fill);
								$this->Cell($w[1],6,"Subtotal Liabilities",'LR',0,'L',$fill);
								$this->Cell($w[2],6,"",'LR',0,'L',$fill);
								$this->Cell($w[3],6,number_format($total4,2,",","."),'LR',0,'L',$fill);
								$this->Ln();
								$fill = !$fill;
								$this->SetFont('Arial','',7);
							}
						}
						else{
							if($code['code']==31090)
								$total5-=$balance;
							else{
								if($code['code']==32090){
									$total5+=$balance;
									//$data.=$object->show5($total5);
									$this->SetFont('Arial','',10);
									$this->Cell($w[0],6,"",'LR',0,'L',$fill);
									$this->Cell($w[1],6,"Subtotal Liabilities",'LR',0,'L',$fill);
									$this->Cell($w[2],6,"",'LR',0,'L',$fill);
									$this->Cell($w[3],6,number_format($total5,2,",","."),'LR',0,'L',$fill);
									$this->Ln();
									$fill = !$fill;
									$this->SetFont('Arial','',7);
								}
								else
									$total5+=$balance;
							}
						}
					}
					//PL
					else{
						//$data.= $object->show_data_left($code['code'], $code['name'], $result2_pl);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($result2_pl,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
	
						$total5+=$result2_pl;
					}
				}
			}
		}
		$total_right_table=$total4+$total5;
		//$data .=$object->result_right($total_right_table);
		$this->SetFont('Arial','',10);
		$this->Cell($w[0],6,"Total",'LR',0,'L',$fill);
		$this->Cell($w[1],6,"",'LR',0,'L',$fill);
		$this->Cell($w[2],6,"",'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($total_left_table,2,",","."),'LR',0,'L',$fill);
		$this->Ln();
		$fill = !$fill;
		$this->SetFont('Arial','',7);
		//$data .=$object->end_data($total_left_table, $total_right_table);
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
		$this->Cell(2,5,"",0,1);
	}
	
	function FancyTable2($month, $year, $filter, $header)
	{
		// Colors, line width and bold font
		$this->SetFillColor(41, 128, 185);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(50, 50, 40, 40);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		$number=1;
		//FROM read.php
		$object = new CRUD();
		
		$codes=$object->Read_Code($month, $year);
		$codes2=$object->Read_Code2($month, $year);
		$bank_list=$object->Read_Bank($month, $year);
		//PL
		$codes_pl=$object->Read_Code_Pl($month, $year);

		$balance_pl=$debet_pl=$credit_pl=$total_balance_pl=$total_debet_pl=$total_credit_pl=$total_opening_pl=0; $temu_pl=false;

		$total1_pl=$total2_pl=$total3_pl=0;$check1_pl=$check2_pl=true;$create_left_pl=$create_right_pl1=$create_right_pl2=false;

		//End PL
		$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; 
		$temu=false; $end_table_left=false;
		$total1=$total2=$total3=$total4=$total5=0;$check1=$check2=$check3=$check4=$check5=false;
		$total_left_table=$total_right_table=0;
		$left=$right=false;
		$create_left=$create_right=$create_right2=$create_left2=false;
		foreach($codes as $code){
			$temu=false;
			$debet=$credit=$balance=0;$create_left=$create_right=$create_left2=$create_right2=$left=$right=false;
			if($code['code']>20000){
				$right=true;
				if(!$end_table_left){
					$end_table_left=true;
					//$data .=$object->result_left($total_left_table);
					
					//$data .= $object->table_right();
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
								//$data .=$object->show1($total1_pl);
								$this->SetFont('Arial','',10);
								$this->Cell($w[0],6,"",'LR',0,'L',$fill);
								$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
								$this->Cell($w[2],6,"",'LR',0,'L',$fill);
								$this->Cell($w[3],6,number_format($total1_pl,2,",","."),'LR',0,'L',$fill);
								$this->Ln();
								$fill = !$fill;
								$this->SetFont('Arial','',7);
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
						//$data.= $object->show_data_left($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						
						if($code['code']==13020)
							$total1+=$balance;
						else if($code['code']==13030)
							$total2+=$balance;
						else if($code['code']==13040)
							$total3+=$balance;
						else if($code['code']==13021){
							$total1-=$balance;
							$total_left_table+=$total1;
							//$data.=$object->show1($total1);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total1,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
						}
						else if($code['code']==13031){
							$total2-=$balance;
							$total_left_table+=$total2;
							//$data.=$object->show2($total2);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total2,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
						}
						else if($code['code']==13041){
							$total3-=$balance;
							$total_left_table+=$total3;
							//$data.=$object->show3($total3);
							$this->Cell($w[0],6,"",'LR',0,'L',$fill);
							$this->Cell($w[1],6,"Subtotal",'LR',0,'L',$fill);
							$this->Cell($w[2],6,"",'LR',0,'L',$fill);
							$this->Cell($w[3],6,number_format($total3,2,",","."),'LR',0,'L',$fill);
							$this->Ln();
							$fill = !$fill;
						}
					}
					else{
						//$data.= $object->show_data_right($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,"",'LR',0,'L',$fill);
						$this->Cell($w[3],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						
						$total_left_table+=$balance;
					}
				}
				else{
					if($create_left){
						//$data.= $object->show_data_left($code['code'], $code['name'], $balance);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						if($code['code']==21010 || $code['code']==21020 || $code['code']==21030 || $code['code']==21040 || $code['code']==21090){
							$total4+=$balance;
							if($code['code']==21090){
								//$data.=$object->show4($total4);
								$this->Cell($w[0],6,"",'LR',0,'L',$fill);
								$this->Cell($w[1],6,"Subtotal Liabilities",'LR',0,'L',$fill);
								$this->Cell($w[2],6,"",'LR',0,'L',$fill);
								$this->Cell($w[3],6,number_format($total4,2,",","."),'LR',0,'L',$fill);
								$this->Ln();
								$fill = !$fill;
							}
						}
						else{
							if($code['code']==31090)
								$total5-=$balance;
							else{
								if($code['code']==32090){
									$total5+=$balance;
									//$data.=$object->show5($total5);
									$this->SetFont('Arial','',10);
									$this->Cell($w[0],6,"",'LR',0,'L',$fill);
									$this->Cell($w[1],6,"Subtotal Liabilities",'LR',0,'L',$fill);
									$this->Cell($w[2],6,"",'LR',0,'L',$fill);
									$this->Cell($w[3],6,number_format($total5,2,",","."),'LR',0,'L',$fill);
									$this->Ln();
									$fill = !$fill;
									$this->SetFont('Arial','',7);
								}
								else
									$total5+=$balance;
							}
						}
					}
					//PL
					else{
						//$data.= $object->show_data_left($code['code'], $code['name'], $result2_pl);
						$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
						$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
						$this->Cell($w[2],6,number_format($result2_pl,2,",","."),'LR',0,'L',$fill);
						$this->Cell($w[3],6,"",'LR',0,'L',$fill);
						$this->Ln();
						$fill = !$fill;
						
						$total5+=$result2_pl;
					}
				}
			}
		}
		$total_right_table=$total4+$total5;
		//$data .=$object->result_right($total_right_table);
		$this->SetFont('Arial','',10);
		$this->Cell($w[0],6,"Total",'LR',0,'L',$fill);
		$this->Cell($w[1],6,"",'LR',0,'L',$fill);
		$this->Cell($w[2],6,"",'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($total_right_table,2,",","."),'LR',0,'L',$fill);
		$this->Ln();
		$fill = !$fill;
		//$data .=$object->end_data($total_left_table, $total_right_table);
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
		$this->Cell(2,5,"",0,1);
	}

	function LoadData($files)
	{
		// Read file lines
		//$lines = file($file);
		$data = array();
		foreach($files as $line)
			$data[] = explode(';',$line);
		return $data;
	}
}

$pdf = new PDF('P','mm','A4');
$object = new NRC();
// Column headings
$header = array('Account Code', 'Account Name', 'Nominal', 'Nominal');
// Data loading
$pdf->AliasNbPages();
//$datas = $object->Read_PDF_All($tahun, $per, $jur, $monarch);
//$data = $pdf->LoadData($datas);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->Cell(0,15,'Neraca '.$month.' - '.$year." ".$object->monarch($monarch),0,1,'C');
$pdf->SetFont('Arial','',7);
$pdf->FancyTable($month, $year, $filter, $header);
$pdf->AddPage();
$pdf->FancyTable2($month, $year, $filter, $header);
//$pdf->FancyTable2($month, $year, $filter, $header);
$pdf->Output();
?>