<?php
//session_start();
require '../lib.php';
$object = new Billing();
$type = $_POST['type_data'];
$n = 1;
if($type==1){
	$status = 0;
	$billings = $object->Read_Billing($status);
	$data = '<h3 class="text-center"> Billing</h3>
	<hr />
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
	foreach($billings as $billing){
		$total = 0;
		$date = date("d-m-Y", strtotime($billing['date_created']));
		$body_table = "";
		$items = $object->Read_Billing_Item($billing['id'], $status);
		$start_table = $object->Start_Table();	
		$end_table = $object->End_Table($billing['id'], $status);	
		$number = 1;
		foreach($items as $item){
			$body_table .= $object->Show_Data($number, $item['code'], $item['name'], $item['qty'], $item['sell']);
			$total += $item['qty'] * $item['sell'];
			$number ++;
		}
		$total_table = '
		<tr>
			<td colspan="4">Grand Total</td>
			<td><strong>' . number_format($total,2,",",".") . '</strong></td>
		</tr>
		';
		$data .= '
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading_'. $n .'">
				<h4 class="panel-title text-center">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'. $n .'" aria-expanded="false" aria-controls="collapse_'. $n .'">
					#'. $billing['id']  .' - '. $billing['title'] .' - '. $object->Monarch($billing['monarch']) .' - '. $date .'
				</a>
				</h4>
			</div>
			<div id="collapse_'. $n .'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_'. $n .'">
				<div class="panel-body">
					'. $start_table .'
					'. $body_table .'
					'. $total_table .'
					'. $end_table .'
				</div>
			</div>
		</div>
		';
		$n++;
	}
	$data .= '</div>';
}

else{
	$status = 1;
	$billings = $object->Read_Billing($status);
	$data = '<h3 class="text-center">Paid-Bill</h3>
	<hr />
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
	foreach($billings as $billing){
		$total = 0;
		$date = date("d-m-Y", strtotime($billing['date_created']));
		$body_table = "";
		$items = $object->Read_Billing_Item($billing['id'], $status);
		$start_table = $object->Start_Table();	
		$end_table = $object->End_Table($billing['id'], $status);	
		$number = 1;
		foreach($items as $item){
			$body_table .= $object->Show_Data($number, $item['code'], $item['name'], $item['qty'], $item['sell']);
			$total += $item['qty'] * $item['sell'];
			$number ++;
		}
		$total_table = '
		<tr>
			<td colspan="4">Grand Total</td>
			<td><strong>' . number_format($total,2,",",".") . '</strong></td>
		</tr>
		';
		$data .= '
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading_'. $n .'">
				<h4 class="panel-title text-center">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'. $n .'" aria-expanded="false" aria-controls="collapse_'. $n .'">
					#'. $billing['id']  .' - '. $billing['title'] .' - '. $object->Monarch($billing['monarch']) .' - '. $date .'
				</a>
				</h4>
			</div>
			<div id="collapse_'. $n .'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_'. $n .'">
				<div class="panel-body">
					'. $start_table .'
					'. $body_table .'
					'. $total_table .'
					'. $end_table .'
				</div>
			</div>
		</div>
		';
		$n++;
	}
	$data .= '</div>';
}

echo $data;
?>