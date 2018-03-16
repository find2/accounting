<?php
    require '../lib.php';
    $object3 = new Supplier();
    $suppliers = $object3->Read();
    $data = "";
    if(count($suppliers) > 0){
        foreach($suppliers as $supplier){
            $data .= '<option value="'. $supplier['id'] .'">'. $supplier['name'] .'</option>';
        }
    }
    echo $data;
?>