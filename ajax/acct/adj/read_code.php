<?php
require '../lib.php';
$month=$_POST['month'];
$year=$_POST['year'];
$type=$_POST['type'];
$ledger=$_POST['ledger'];
$object = new Adjustment(); 
$users = $object->Read_Code($month, $year, $ledger);
if (count($users) > 0) {
	if($type==1){
		$data='
		<div class="form-group">
		<label for="code">Code of Account</label>
		<select name="code" id="code" class="form-control">	
		<option value="">--</option>
		';
	}
	else{
		$data='
		<div class="form-group">
		<label for="update_code">Code of Account</label>
		<select name="update_code" id="update_code" class="form-control">	
		<option value="">--</option>
		';
	}
	
    foreach ($users as $user) {
		$code=$user['code'];
		$name=$user['code']."-".$user['name'];
		$data.='
			<option value="'. $code .'">'. $name .'</option>
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