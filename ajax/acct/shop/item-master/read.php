<?php
//session_start();
require '../lib.php';

$object = new Item_Master();
$masters = $object->Read();
$data = $object->table();
if (count($masters) > 0) {
    $number = 1;
    foreach ($masters as $master) {
		$data .= $object->show_data($number, $master['name'], $master['code'], $master['id']);
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