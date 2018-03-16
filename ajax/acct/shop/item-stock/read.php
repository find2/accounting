<?php
//session_start();
require '../lib.php';

$object = new Item_Stock();
$stocks = $object->Read();
$data = $object->table();
if (count($stocks) > 0) {
    $number = 1;
    foreach ($stocks as $stock) {
		$data .= $object->show_data($number, $stock['code'], $stock['name'], $stock['supplier_name'], $stock['qty'], $stock['buy'], $stock['sell'], $stock['id']);
		$number++;
    }
	if($number==1) {
		// records not found
		$data .= '<tr><td colspan="8">Records not found!</td></tr>';
	}
}
$data .= '</tbody></table></div>';
echo $data;
 
?>