<?php
    require '../lib.php';
    $object2 = new Item_Master();
    $masters = $object2->Read();
    $data = "";
    if(count($masters) > 0){
        foreach($masters as $master){
            $data .= '<option value="'. $master['id'] .'">'. $master['code'] .'</option>';
        }
    }
    echo $data;
?>