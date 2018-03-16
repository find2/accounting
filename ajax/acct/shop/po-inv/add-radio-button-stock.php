<?php 
    $id = $_POST['id'];
    $type = $_POST['type'];
    if($type==1){
        $data = '
        <label for="type">Type of Stock:</label>
        <div class="row form-group">
            <div class="col-lg-6 col-md-6">
                <label class="radio-inline"><input type="radio" name="type_'. $id .'" value="1" onclick="currentStock('. $id .')">Current Stock</label>
            </div>
            <div class="col-lg-6 col-md-6">
                <label class="radio-inline"><input type="radio" name="type_'. $id .'" value="2" onclick="newStock('. $id .')">New Stock</label>
            </div>
        </div>';
    }
    else{
        $data = '
        <label for="type">Type of Stock:</label>
        <div class="row form-group">
            <div class="col-lg-6 col-md-6">
                <label class="radio-inline"><input type="radio" name="u_type_'. $id .'" value="1" onclick="u_currentStock('. $id .')">Current Stock</label>
            </div>
            <div class="col-lg-6 col-md-6">
                <label class="radio-inline"><input type="radio" name="u_type_'. $id .'" value="2" onclick="u_newStock('. $id .')">New Stock</label>
            </div>
        </div>';
    }
    echo $data;
?>