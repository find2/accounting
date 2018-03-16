<?php
    $id = $_POST['item_number'];
    $type = $_POST['type'];
    if($type==1){
        $data = 
        '
        <div class="panel panel-success" id="id_panel_'. $id .'"> 
            <div class="panel-heading">
                <h3 class="panel-title">Item</h3>
                <span class="pull-right clickable" data-effect="fadeOut" onclick=removePanel('. $id .');><i class="fa fa-times"></i></span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="id_master_'. $id .'">Item Master:</label>
                    <select name="id_master_'. $id .'" id="id_master_'. $id .'" class="form-control" onchange="itemStock('. $id .')">
                        <option value=""> -- </option>                                    
                    </select>
                </div>
                
                <div id="item_stock_'. $id .'"> 
                </div>
                
                <div id="qty_content_'. $id .'"> 
                </div>
            </div>
        </div>    
        ';
    }
    else if($type==3){
        require '../lib.php';
        $item_master = new Item_Master();
        $masters = $item_master->Read();
        $data_master = "";
        if(count($masters) > 0){
            foreach($masters as $master){
                $data_master .= '<option value="'. $master['id'] .'">'. $master['code'] .'</option>';
            }
        }
        $data = 
        '
        <div class="panel panel-success" id="u_id_panel_'. $id .'"> 
            <div class="panel-heading">
                <h3 class="panel-title">Item</h3>
                <span class="pull-right clickable" data-effect="fadeOut" onclick=u_removePanel('. $id .');><i class="fa fa-times"></i></span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="u_id_master_'. $id .'">Item Master:</label>
                    <select name="u_id_master_'. $id .'" id="u_id_master_'. $id .'" class="form-control" onchange="u_itemStock('. $id .')">
                        <option value=""> -- </option>
                        '. $data_master .'                                    
                    </select>
                </div>
                
                <div id="u_item_stock_'. $id .'"> 
                </div>
                
                <div id="u_qty_content_'. $id .'"> 
                </div>
            </div>
        </div>  
        ';
    }
    else{
        require '../lib.php';
        //Data Item Master
        $id_item_stock = $_POST['id_item_stock'];
        $qty = $_POST['qty'];
        $object = new Billing();
        $current_qty = $object->Get_Current_Stock($id_item_stock);
        $current_qty += $qty;
        $item_master = new Item_Master();
        $masters = $item_master->Read();
        $id_master = $item_master->Get_Id_Master($id_item_stock);
        $data_master = "";
        if(count($masters) > 0){
            foreach($masters as $master){
                $data_master .= '<option value="'. $master['id'] .'">'. $master['code'] .'</option>';
            }
        }
        //END
        // Data Item Stock
        $Item_Po_Inv = new Item_Po_Inv();
        $stocks = $Item_Po_Inv->Read_Item_Stock_Id_Master($id_master);
        // $items = $Item_Po_Inv->Read_Item_Stock_Id($id_item_stock);
        $data_stock="";
        foreach($stocks as $stock){
            $data_stock .='<option value="'. $stock['id'] .'">'. $stock['code'] .'_'. $stock['name'] .'</option>';    
        }
        // End
        
        $data = 
        '
        <div class="panel panel-success" id="u_id_panel_'. $id .'"> 
            <div class="panel-heading">
                <h3 class="panel-title">Item</h3>
                <span class="pull-right clickable" data-effect="fadeOut" onclick=u_removePanel('. $id .');><i class="fa fa-times"></i></span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="u_id_master_'. $id .'">Item Master:</label>
                    <select name="u_id_master_'. $id .'" id="u_id_master_'. $id .'" class="form-control" onchange="u_itemStock('. $id .')">
                        <option value=""> -- </option>  
                        '. $data_master .'                                     
                    </select>
                </div>
                
                <div id="u_item_stock_'. $id .'">
        ';

        $data .= '
        <div class="form-group">
            <label for="u_tem_stock_'. $id .'">Item:</label>
            <select name="u_id_item_stock_'. $id .'" id="u_id_item_stock_'. $id .'" class="form-control" onchange="u_addQty('. $id .')">
                <option value=""> -- </option>
                '. $data_stock .'                                    
            </select>
        </div>
        ';

        $data .= '
        
                </div>
                <div id="u_qty_content_'. $id .'"> 
                    <div class="form-group">
                        <label for="u_qty_'. $id .'">Qty:</label>
                        <input type="text" id="u_qty_'. $id .'" name="u_qty_'. $id .'">        
                    </div>
                    <script>
                        $("#u_qty_"+'. $id .').ionRangeSlider({
                            min:1,
                            max:'. $current_qty .',
                            from:'. $qty .'    
                        });
                    </script>
                </div> 
            </div>
        </div>
        ';
        
        

        $data .='
            <script>
                $("#u_id_master_"+'. $id .').val('. $id_master .');
                $("#u_id_item_stock_"+'. $id .').val('. $id_item_stock .'); 
            </script>    
        ';
    }
    
    echo $data;
?> 