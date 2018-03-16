<?php
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$ledger=$_POST['ledger'];
$object = new Bank(); 
$users = $object->Read_Bank($month, $year, $ledger);
if (count($users) > 0) {	
	$data='
	<div class="form-group">
	<label for="bank_name">Bank Name:</label>
	<select name="bank_name" id="bank_name" class="form-control">	
	<option value="">--</option>
	';
    foreach ($users as $user) {
		$name=$user['name'];
		$data.='
			<option value="'. $name .'">'. $name .'</option>
		';
    }
	$data.='
	</select>
	</div>
	';
}
else{
	$data="";
}
echo $data;
 
?>