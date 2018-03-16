<?php 
    require '../lib.php';
    $id_master = $_POST['id_master'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $object = new Item_Po_Inv();
    $stocks = $object->Read_Item_Stock_Id_Master($id_master);
    $data2="";
    
    foreach($stocks as $stock){
        $data2 .='<option value="'. $stock['id'] .'">'. $stock['code'] .'_'. $stock['name'] .'</option>';    
    }
    if($type == 1){
        $data = '
        <div class="form-group">
            <label for="id_item_stock_'. $id .'">Item Stock:</label>
            <select name="id_item_stock_'. $id .'" id="id_item_stock_'. $id .'" class="form-control" onchange="addQty('. $id .')">
                <option value=""> -- </option>
                '. $data2 .'                                    
            </select>
        </div>
        ';
    }
    else{
        $data = '
        <div class="form-group">
            <label for="u_id_item_stock_'. $id .'">Item Stock:</label>
            <select name="u_id_item_stock_'. $id .'" id="u_id_item_stock_'. $id .'" class="form-control" onchange="u_addQty('. $id .')">
                <option value=""> -- </option>
                '. $data2 .'                                    
            </select>
        </div>
        ';
    }
    echo $data;
?>