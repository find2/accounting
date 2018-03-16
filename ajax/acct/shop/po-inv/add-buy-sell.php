<?php
    require '../lib.php';
    $object = new Item_Po_Inv();
    $id = $_POST['id'];
    $type = $_POST['type'];
    $id_item_stock = $_POST['id_item_stock'];
    $data = "";
    if($type==1){
        if($id_item_stock != 0){
            $stocks = $object->Read_Item_Stock_Id($id_item_stock);
            foreach($stocks as $stock){
                $data .= '
                <input type="hidden" id="name_'. $id .'" value="" />
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <!-- Buy -->
                        <div class="form-group">
                            <label for="buy_'. $id .'">Purchase Price:</label>
                            <input type="text" class="form-control" name="buy_'. $id .'" id="buy_'. $id .'" value="'. $stock['buy'] .'" disabled/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <!-- Sell -->
                        <div class="form-group">
                            <label for="sell_'. $id .'">Selling Price:</label>
                            <input type="text" class="form-control" name="sell_'. $id .'" id="sell_'. $id .'" value="'. $stock['sell'] .'" disabled/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <!-- Qty -->
                        <div class="form-group">
                            <label for="Qty_'. $id .'">Quantity:</label>
                            <input type="text" class="form-control" name="qty_'. $id .'" id="qty_'. $id .'" placeholder="0" />
                        </div>
                    </div>
                </div>
                ';
            }
        }
        else{
            $data .= '
            
            <input type="hidden" id="id_item_stock_'. $id .'" value="" />
            <div class="form-group">
                <label for="name_'. $id .'">Stock Name:</label>
                <input type="text" class="form-control" name="name_'. $id .'" id="name_'. $id .'" placeholder="Stock Name" />
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <!-- Buy -->
                    <div class="form-group">
                        <label for="buy_'. $id .'">Purchase Price:</label>
                        <input type="text" class="form-control" name="buy_'. $id .'" id="buy_'. $id .'"  />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <!-- Sell -->
                    <div class="form-group">
                        <label for="sell_'. $id .'">Selling Price:</label>
                        <input type="text" class="form-control" name="sell_'. $id .'" id="sell_'. $id .'"  />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <!-- Qty -->
                    <div class="form-group">
                        <label for="Qty_'. $id .'">Quantity:</label>
                        <input type="text" class="form-control" name="qty_'. $id .'" id="qty_'. $id .'" placeholder="0" />
                    </div>
                </div>
            </div>
            ';
        }
    }
    else{
        if($id_item_stock != 0){
            $stocks = $object->Read_Item_Stock_Id($id_item_stock);
            foreach($stocks as $stock){
                $data .= '
                <input type="hidden" id="u_name_'. $id .'" value="" />
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <!-- Buy -->
                        <div class="form-group">
                            <label for="u_buy_'. $id .'">Purchase Price:</label>
                            <input type="text" class="form-control" name="u_buy_'. $id .'" id="u_buy_'. $id .'" value="'. $stock['buy'] .'" disabled/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <!-- Sell -->
                        <div class="form-group">
                            <label for="u_sell_'. $id .'">Selling Price:</label>
                            <input type="text" class="form-control" name="u_sell_'. $id .'" id="u_sell_'. $id .'" value="'. $stock['sell'] .'" disabled/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <!-- Qty -->
                        <div class="form-group">
                            <label for="u_qty_'. $id .'">Quantity:</label>
                            <input type="text" class="form-control" name="u_qty_'. $id .'" id="u_qty_'. $id .'" placeholder="0" />
                        </div>
                    </div>
                </div>
                ';
            }
        }
        else{
            $data .= '
            
            <input type="hidden" id="u_id_item_stock_'. $id .'" value="" />
            <div class="form-group">
                <label for="u_name_'. $id .'">Stock Name:</label>
                <input type="text" class="form-control" name="u_name_'. $id .'" id="u_name_'. $id .'" placeholder="Stock Name" />
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <!-- Buy -->
                    <div class="form-group">
                        <label for="u_buy_'. $id .'">Purchase Price:</label>
                        <input type="text" class="form-control" name="u_buy_'. $id .'" id="u_buy_'. $id .'"  />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <!-- Sell -->
                    <div class="form-group">
                        <label for="u_sell_'. $id .'">Selling Price:</label>
                        <input type="text" class="form-control" name="u_sell_'. $id .'" id="u_sell_'. $id .'"  />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <!-- Qty -->
                    <div class="form-group">
                        <label for="u_qty_'. $id .'">Quantity:</label>
                        <input type="text" class="form-control" name="u_qty_'. $id .'" id="u_qty_'. $id .'" placeholder="0" />
                    </div>
                </div>
            </div>
            ';
        }
    }
    
    echo $data;
?>