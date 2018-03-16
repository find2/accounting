<?php 

if ($_POST['id_item_stock'] !="" ) {
    require '../lib.php';
    $id_item_stock = $_POST['id_item_stock'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $object = new Billing();
    $qty = $object->Get_Current_Stock($id_item_stock);
    
    if($type == 1){
        $data = '
        <div class="form-group">
            <label for="qty_'. $id .'">Qty:</label>
            <input type="text" id="qty_'. $id .'" value="" name="qty_'. $id .'">        
        </div>
        <script>
            $("#qty_"+'. $id .').ionRangeSlider({
                min:1,
                max:'. $qty .',
                from:1    
            });
        </script>
        ';
    }
    else{
        $id_billing = $_POST['id_billing'];
        $current_qty = $object->Get_Qty_Item_Billing($id_billing, $id_item_stock);
        $current_qty += $qty;
        $data = '
        <div class="form-group">
            <label for="u_qty_'. $id .'">Qty:</label>
            <input type="text" id="u_qty_'. $id .'" value="" name="u_qty_'. $id .'">        
        </div>
        <script>
            $("#u_qty_"+'. $id .').ionRangeSlider({
                min:1,
                max:'. $current_qty .',
                from:1    
            });
        </script>
        ';
    }
    echo $data;
}
?>