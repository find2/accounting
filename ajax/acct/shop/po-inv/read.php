<?php
//session_start();
require '../lib.php';
$object = new Item_Po_Inv();
$type = $_POST['type_data'];
$n = 1;
if($type==1){
	$status = 0;
	$pos = $object->Read_PO($status);
	$data = '<h3 class="text-center"> Pre-Order</h3>
	<hr />
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
	foreach($pos as $po){
		$date = date("d-m-Y", strtotime($po['date_created']));
		$body_table = "";
		$items = $object->Read_PO_Item($po['id'], $status);
		$start_table = $object->Start_Table();	
		$end_table = $object->End_Table($po['id'], $status);	
		$number = 1;
		foreach($items as $item){
			$body_table .= $object->Show_Data($number, $item['code'], $item['name'], $item['qty'], $item['buy'], $item['sell']);
			$number ++;
		}

		$data .= '
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading_'. $n .'">
				<h4 class="panel-title text-center">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'. $n .'" aria-expanded="false" aria-controls="collapse_'. $n .'">
					#'. $po['id']  .' - '. $po['title'] .' - '. $po['name'] .' - '. $date .'
				</a>
				</h4>
			</div>
			<div id="collapse_'. $n .'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_'. $n .'">
				<div class="panel-body">
					'. $start_table .'
					'. $body_table .'
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
	$pos = $object->Read_PO($status);
	$data = '<h3 class="text-center"> Invoice</h3>
	<hr />
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
	foreach($pos as $po){
		$date = date("d-m-Y", strtotime($po['date_created']));
		$body_table = "";
		$items = $object->Read_PO_Item($po['id'], $status);
		$start_table = $object->Start_Table();	
		$end_table = $object->End_Table($po['id'], $status);	
		$number = 1;
		foreach($items as $item){
			$body_table .= $object->Show_Data($number, $item['code'], $item['name'], $item['qty'], $item['buy'], $item['sell']);
			$number ++;
		}

		$data .= '
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading_'. $n .'">
				<h4 class="panel-title text-center">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'. $n .'" aria-expanded="false" aria-controls="collapse_'. $n .'">
					#'. $po['id']  .' - '. $po['title'] .' - '. $po['name'] .' - '. $date .'
				</a>
				</h4>
			</div>
			<div id="collapse_'. $n .'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_'. $n .'">
				<div class="panel-body">
					'. $start_table .'
					'. $body_table .'
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