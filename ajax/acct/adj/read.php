<?php
//session_start();
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$ledger=$_POST['ledger'];
$object = new Adjustment();
$users = $object->Read($month, $year, $ledger);
$data = $object->table($month, $year);
$number = 1;
if(count($users) > 0) {
    foreach ($users as $user) {
		$data .= $object->show_data($number, $user['item'], $user['code'], $object->Read_Name($month, $year, $user['code'], $ledger), $user['debet'], $user['credit'], $user['id']);
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