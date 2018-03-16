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

		$balance=$debet=$credit=$total_balance=$total_debet=$total_credit=$total_opening=0; $temu=false;

		$total1=$total2=$total3=0;$check1=$check2=true;$create_left=$create_right1=$create_right2=false;
		//read show0
		$this->SetFont('Arial','',10);
		$this->Cell($w[0],6,"Total Revenue",'LR',0,'L',$fill);
		$this->Cell($w[1],6,"",'LR',0,'L',$fill);
		$this->Cell($w[2],6,"",'LR',0,'L',$fill);
		$this->Cell($w[3],6,"",'LR',0,'L',$fill);
		$this->Ln();
		$this->SetFont('Arial','',7);
		$fill = !$fill;
		//End show0
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
					//read show1
					$this->SetFont('Arial','',10);
					$this->Cell($w[0],6,"Subtotal Revenue",'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,number_format($total1,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					
					$this->Cell($w[0],6,"Costs and Expenses",'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,"",'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					$this->SetFont('Arial','',7);
					//End show1
				}
				$create_left=true;
			}
			else{
				if($check2){
					$check2=false;
					//$data .=$object->show2($total1, $total2);
					//read show2
					$this->SetFont('Arial','',10);
					$this->Cell($w[0],6,"Subtotal Costs and Expenses",'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,number_format($total2,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					
					$this->Cell($w[0],6,"Operation Profit",'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,number_format($total1-$total2,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					
					$this->Cell($w[0],6,"Other Revenue and Cost",'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,"",'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					$this->SetFont('Arial','',7);
					//End show2
				}
				$create_right2=true;
			}
			
			if($create_left || $create_right1 || $create_right2){
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
				if($code['type']== "Debet")
					$balance=$code['balance']+$debet-$credit;
				else
					$balance=$code['balance']+$credit-$debet;
				
				$total_debet+=$debet;$total_credit+=$credit;$total_balance+=$balance;$total_opening+=$code['balance'];
				//Create Data
				if($create_left){
					//$data.= $object->show_data_left($code['code'], $code['name'], $balance);
					$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
					$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
					$this->Cell($w[2],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
					$this->Cell($w[3],6,"",'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					$total2+=$balance;
				}
				else if($create_right1){
					//$data.= $object->show_data_right($code['code'], $code['name'], $balance);
					$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
					$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					$total1+=$balance;	
				}
				else{
					//$data.= $object->show_data_right($code['code'], $code['name'], $balance);
					$this->Cell($w[0],6,$code['code'],'LR',0,'L',$fill);
					$this->Cell($w[1],6,$code['name'],'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,number_format($balance,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					if($code['code']=="61010")
						$total3+=$balance;
					else
						$total3-=$balance;
						
				}
			}
		}
		//$data .=$object->show3($total1, $total2, $total3);
		$this->SetFont('Arial','',10);
		$this->Cell($w[0],6,"Subtotal Other Revenue and Expenses",'LR',0,'L',$fill);
		$this->Cell($w[1],6,"",'LR',0,'L',$fill);
		$this->Cell($w[2],6,"",'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($total3,2,",","."),'LR',0,'L',$fill);
		$this->Ln();
		$fill = !$fill;
		
		$result=$total1-$total2;
		$result2=$result+$total3;
		
		$this->Cell($w[0],6,"Current Profit Month",'LR',0,'L',$fill);
		$this->Cell($w[1],6,"",'LR',0,'L',$fill);
		$this->Cell($w[2],6,"",'LR',0,'L',$fill);
		$this->Cell($w[3],6,number_format($result2,2,",","."),'LR',0,'L',$fill);
		$this->Ln();
		$fill = !$fill;
		$this->SetFont('Arial','',7);
		// Closing line
		
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
$header = array('Account Code', 'Account Name', 'Nominal', 'Nominal');
// Data loading
$pdf->AliasNbPages();
//$datas = $object->Read_PDF_All($tahun, $per, $jur, $monarch);
//$data = $pdf->LoadData($datas);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->Cell(0,15,'Profit and Loss '.$month.' - '.$year." ".$object->monarch($monarch),0,1,'C');
$pdf->SetFont('Arial','',7);
$pdf->FancyTable($month, $year, $filter, $header);
$pdf->Output();
?>