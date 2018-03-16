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
                    <select name="id_master_'. $id .'" id="id_master_'. $id .'" class="form-control" onchange="addRadioButtonStock('. $id .')">
                        <option value=""> -- </option>                                    
                    </select>
                </div>
                <div id="stock_'. $id .'">
                </div>
                
                <div id="item_stock_'. $id .'"> 
                </div>
                
                <div id="buy_sell_'. $id .'"> 
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
                    <select name="u_id_master_'. $id .'" id="u_id_master_'. $id .'" class="form-control" onchange="u_addRadioButtonStock('. $id .')">
                        <option value=""> -- </option>                                    
                        '. $data_master .'
                    </select>
                </div>
                <div id="u_stock_'. $id .'">
                </div>
                
                <div id="u_item_stock_'. $id .'"> 
                </div>
                
                <div id="u_buy_sell_'. $id .'"> 
                </div>
            </div>
        </div>    
        ';
    }
    else{
        require '../lib.php';
        //Data Item Master
        $id_item_stock = $_POST['id_item_stock'];
        $id_master = $_POST['id_master'];
        $qty = $_POST['qty'];
        $buy = $_POST['buy'];
        $sell = $_POST['sell'];
        $name = $_POST['name'];
        
        $item_master = new Item_Master();
        $masters = $item_master->Read();
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
        $items = $Item_Po_Inv->Read_Item_Stock_Id($id_item_stock);
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
                <span class="pull-right clickable" data-effect="fadeOut" onclick=removePanel('. $id .');><i class="fa fa-times"></i></span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="u_id_master_'. $id .'">Item Master:</label>
                    <select name="u_id_master_'. $id .'" id="u_id_master_'. $id .'" class="form-control" onchange="u_addRadioButtonStock('. $id .')">
                        <option value=""> -- </option>  
                        '. $data_master .'                                     
                    </select>
                </div>

                <div id="u_stock_'. $id .'">    
                    <label for="type">Type of Stock:</label>
                    <div class="row form-group">
                        <div class="col-lg-6 col-md-6">
                            <label class="radio-inline"><input type="radio" name="u_type_'. $id .'" value="1" onclick="u_currentStock('. $id .')">Current Stock</label>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label class="radio-inline"><input type="radio" name="u_type_'. $id .'" value="2" onclick="u_newStock('. $id .')">New Stock</label>
                        </div>
                    </div>
                </div>
                
                <div id="u_item_stock_'. $id .'">
        ';
        if($id_item_stock != 0){
            $data .= '
            <div class="form-group">
                <label for="u_id_item_stock_'. $id .'">Item:</label>
                <select name="u_id_item_stock_'. $id .'" id="u_id_item_stock_'. $id .'" class="form-control" onchange="u_addBuySell('. $id .')">
                    <option value=""> -- </option>
                    '. $data_stock .'                                    
                </select>
            </div>
            ';

            foreach($items as $item){
                $data .= '
                
                </div>
                <div id="u_buy_sell_'. $id .'"> 
                    <input type="hidden" id="u_name_'. $id .'" value="" />
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <!-- Buy -->
                            <div class="form-group">
                                <label for="u_buy_'. $id .'">Purchase Price:</label>
                                <input type="text" class="form-control" name="u_buy_'. $id .'" id="u_buy_'. $id .'" value="'. $item['buy'] .'" disabled/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <!-- Sell -->
                            <div class="form-group">
                                <label for="u_sell_'. $id .'">Selling Price:</label>
                                <input type="text" class="form-control" name="u_sell_'. $id .'" id="u_sell_'. $id .'" value="'. $item['sell'] .'" disabled/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <!-- Qty -->
                            <div class="form-group">
                                <label for="u_qty_'. $id .'">Quantity:</label>
                                <input type="text" class="form-control" name="u_qty_'. $id .'" id="u_qty_'. $id .'" placeholder="" value='. $qty .' />
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
                ';
            }
        }
        else{
            $data .='
            </div>
                <div id="u_buy_sell_'. $id .'"> 
                    <input type="hidden" id="u_id_item_stock_'. $id .'" value="" />
                    <div class="form-group">
                        <label for="u_name_'. $id .'">Stock Name:</label>
                        <input type="text" class="form-control" name="u_name_'. $id .'" id="u_name_'. $id .'" placeholder="" value='. $name .' />
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <!-- Buy -->
                            <div class="form-group">
                                <label for="u_buy_'. $id .'">Purchase Price:</label>
                                <input type="text" class="form-control" name="u_buy_'. $id .'" id="u_buy_'. $id .'"  value='. $buy .' />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <!-- Sell -->
                            <div class="form-group">
                                <label for="u_sell_'. $id .'">Selling Price:</label>
                                <input type="text" class="form-control" name="u_sell_'. $id .'" id="u_sell_'. $id .'" value='. $sell .'  />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <!-- Qty -->
                            <div class="form-group">
                                <label for="u_qty_'. $id .'">Quantity:</label>
                                <input type="text" class="form-control" name="u_qty_'. $id .'" id="u_qty_'. $id .'" placeholder="" value='. $qty .' />
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
            ';
        }

        $data .='
            <script>
                $("#u_id_master_"+'. $id .').val('. $id_master .');
                if('. $id_item_stock .' != 0){
                    $("input:radio[name=u_type_'. $id .']")[0].checked = true;
                    $("#u_id_item_stock_"+'. $id .').val('. $id_item_stock .');
                }
                else{
                    $("input:radio[name=u_type_'. $id .']")[1].checked = true;
                    // u_newStock('. $id .');
                }    
            </script>    
        ';
    }
    
    echo $data;
?> 