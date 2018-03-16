<?php
if (isset($_POST['id_supplier']) ) {
    require("../lib.php");
    $object = new Item_Po_Inv();
	date_default_timezone_set('Asia/Brunei');
    $id_supplier = $_POST['id_supplier'];
    $date_created = date("Y-m-d h:i:sa");
    $status = 0;
    $id = $_POST['id'];
    $object->Delete($id);

    $title = $_POST['title'];
    $id_po_inv = $object->Create_Po_Inv($title, $id_supplier, $status, $date_created);
    
    $count = $_POST['count'];
    $id_master = $_POST['id_master'];
    $id_item_stock = $_POST['id_item_stock'];
    $qty = $_POST['qty'];
    $name = $_POST['name'];
    $buy = $_POST['buy'];
    $sell = $_POST['sell'];
    $i = 0;
    for($i;$i<$count;$i++){
        $object->Create_Item_Po_Inv($id_po_inv, array_pop($id_item_stock), array_pop($id_master), array_pop($qty), array_pop($buy), array_pop($sell), array_pop($name));
    }
}
?>