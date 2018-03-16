<?php
require('../../../fpdf/fpdf.php');
require '../lib.php';
$month=$_GET['month'];
$year=$_GET['year'];
$filter=$_GET['filter'];
$ledger=$_GET['ledger'];

class PDF extends FPDF
{
	// Page header

	function Header()
	{
		// Logo
		// if($_SESSION['monarch']==01)
		// 	$this->Image('../../images/header/dalung.jpg',10,6,250);
		// else if($_SESSION['monarch']==02)
		// 	$this->Image('../../images/header/candidasa.jpg',10,6,250);
		// else if($_SESSION['monarch']==04)
		// 	$this->Image('../../images/header/gianyar.jpg',10,6,250);
		// else if($_SESSION['monarch']==03)
		// 	$this->Image('../../images/header/singaraja.jpg',10,6,250);
		// else if($_SESSION['monarch']==05)
		// 	$this->Image('../../images/header/negara.jpg',10,6,250);
		// Arial bold 15
		
		// $this->SetFont('Arial','B',15);
		// Move to the right
		// $this->Cell(80);
		// Title
		// Line break
		// $this->Ln(30);
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
	function FancyTable($month, $year, $filter, $header, $ledger)
	{
		// Colors, line width and bold font
		$this->SetFillColor(41, 128, 185);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(6, 14, 30, 110, 10, 35, 24, 24, 24);
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
		$object = new Cash();
		$users = $object->Read($month, $year, $filter, $object->month($month), $ledger);
		$cash= $object->Read_Cash($month, $year, $ledger);
		$saldo=$debet=$credit=0;
		$number = 1;
		$write_cash=false;
		
		foreach($users as $user)
		{
			if(count($cash) > 0 && !$write_cash){
				foreach($cash as $c){
					$write_cash=true;
					$saldo+=$c['balance'];$debet+=$c['balance'];
					$this->Cell($w[0],6,$number,'LR',0,'L',$fill);
					$this->Cell($w[1],6,"",'LR',0,'L',$fill);
					$this->Cell($w[2],6,"",'LR',0,'L',$fill);
					$this->Cell($w[3],6,"Opening Balance",'LR',0,'L',$fill);
					$this->Cell($w[4],6," ",'LR',0,'L',$fill);
					$this->Cell($w[5],6,"Cash on Hand",'LR',0,'L',$fill);
					$this->Cell($w[6],6,number_format($c['balance'],2,",","."),'LR',0,'L',$fill);
					$this->Cell($w[7],6,"",'LR',0,'L',$fill);
					$this->Cell($w[8],6,number_format($saldo,2,",","."),'LR',0,'L',$fill);
					$this->Ln();
					$fill = !$fill;
					$number++;
				}
			}
			if($user['debet']!=0){
				$saldo+=$user['debet'];
				$debet+=$user['debet'];
			}
			else{
				$saldo-=$user['credit'];
				$credit+=$user['credit'];
			}
			
			$this->Cell($w[0],6,$number,'LR',0,'L',$fill);
			$this->Cell($w[1],6,$user['date'],'LR',0,'L',$fill);
			$this->Cell($w[2],6,$user['kwit'],'LR',0,'L',$fill);
			$this->Cell($w[3],6,$user['item'],'LR',0,'L',$fill);
			$this->Cell($w[4],6,$user['code'],'LR',0,'L',$fill);
			$this->Cell($w[5],6,$object->Read_Name($month, $year, $user['code'], $ledger),'LR',0,'L',$fill);
			$this->Cell($w[6],6,number_format($user['debet'],2,",","."),'LR',0,'L',$fill);
			$this->Cell($w[7],6,number_format($user['credit'],2,",","."),'LR',0,'L',$fill);
			$this->Cell($w[8],6,number_format($saldo,2,",","."),'LR',0,'L',$fill);
			$this->Ln();
			$fill = !$fill;
			$number++;
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
		$this->Cell(2,5,"",0,1);
		$this->Cell(2,5,'Total Debet              : Rp. '.number_format($debet,2,",","."),0,1);
		$this->Cell(2,5,'Total Credit              : Rp. '.number_format($credit,2,",","."),0,1);
		$this->Cell(2,5,'Total Saldo              : Rp. '.number_format($saldo,2,",","."),0,1);
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

$pdf = new PDF('L','mm','A4');
$object = new Cash();
// Column headings
$header = array('No.', 'Tanggal', 'No. Kwit.', 'Item', 'Kode', 'Nama', 'Debet', 'Credit', 'Saldo');
// Data loading
$pdf->AliasNbPages();
//$datas = $object->Read_PDF_All($tahun, $per, $jur, $monarch);
//$data = $pdf->LoadData($datas);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
// $pdf->Cell(0,15,'Cash '.$month.' - '.$year." ".$object->monarch($monarch),0,1,'C');
$ledger_name = $object->Get_Ledger($ledger);
$pdf->Cell(0,15,' '. $ledger_name .' ',0,1,'C');
$pdf->SetFont('Arial','',7);
$pdf->FancyTable($month, $year, $filter, $header, $ledger);
$pdf->Output();
?>