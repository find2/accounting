<?php
require('../../fpdf/fpdf.php');
require 'lib.php';
$month=$_GET['month'];
$year=$_GET['year'];
$filter=$_GET['filter'];
$monarch=$_SESSION['monarch'];
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
		$w = array(10, 50, 14, 30, 30, 30, 30);
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
		$codes2=$object->Read_Code($month, $year);
		$bank_list=$object->Read_Bank($month, $year);

		$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; $temu=false;

		
		foreach($codes as $code){
			//Start of all
			$temu=false; $debet=$credit=$balance=0;
			//Mencari di Bank
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
					foreach($codes as $coa2){
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
				else{
					//From Cash
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
				}
				if($code['type']== "Debet")
					$balance=$code['balance']+$debet-$credit;
				else
					$balance=$code['balance']+$credit-$debet;
			}
			$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
			
			//Create ROW
			$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
			$this->Cell($w[2],6,$code['type'],'LR',0,'L',$fill);
			$this->Cell($w[3],6,number_format($code['balance'],2,",","."),'LR',0,'L',$fill);
			$this->Cell($w[4],6,number_format($debet,2,",","."),'LR',0,'L',$fill);
			$this->Cell($w[5],6,number_format($credit,2,",","."),'LR',0,'L',$fill);
			$this->Cell($w[6],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
		$this->Cell(2,5,"",0,1);
		$this->Cell(2,5,'Total Opening Balance          : Rp. '.number_format($total_opening,2,",","."),0,1);
		$this->Cell(2,5,'Total Debet                            : Rp. '.number_format($total_debet,2,",","."),0,1);
		$this->Cell(2,5,'Total Credit                            : Rp. '.number_format($total_credit,2,",","."),0,1);
		$this->Cell(2,5,'Total Balance                         : Rp. '.number_format($total_balance,2,",","."),0,1);
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
$object = new CRUD();
// Column headings
$header = array('Kode', 'Nama', 'Type Akun', 'Opening Balance', 'Debet', 'Credit', 'Balance');
// Data loading
$pdf->AliasNbPages();
//$datas = $object->Read_PDF_All($tahun, $per, $jur, $monarch);
//$data = $pdf->LoadData($datas);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->Cell(0,15,'Neraca Saldo '.$month.' - '.$year." ".$object->monarch($monarch),0,1,'C');
$pdf->SetFont('Arial','',7);
$pdf->FancyTable($month, $year, $filter, $header);
$pdf->Output();
?>