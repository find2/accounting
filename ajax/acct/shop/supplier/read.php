<?php
//session_start();
require '../lib.php';

$object = new Supplier();
$suppliers = $object->Read();
$data = $object->table();
if (count($suppliers) > 0) {
    $number = 1;
    foreach ($suppliers as $supplier) {
		$data .= $object->show_data($number, $supplier['name'], $supplier['phone'], $supplier['id']);
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