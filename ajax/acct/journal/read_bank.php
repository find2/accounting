<?php
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$ledger=$_POST['ledger'];
$object = new Journal(); 
$users = $object->Read_Bank($month, $year, $ledger);
if (count($users) > 0) {	
	$data='
		<div class="form-group">
		<label for="name">Name:</label>
		<select name="name" id="name" class="form-control">	
		<option value="1">Cash on Hand</option>
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