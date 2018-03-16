<?php
if (isset($_POST['monarch']) ) {
    require("../lib.php");
    $object = new Billing();
	date_default_timezone_set('Asia/Brunei');
    $monarch = $_POST['monarch'];
    $id = $_POST['id'];
    // Mengembalikan Qty pada item_billing
    $object->Restore_Qty($id);
    $object->Delete($id);
    $date_created = date("Y-m-d h:i:sa");
    $status = 0;
    $title = $_POST['title'];
    $id_billing = $object->Create_Billing($title, $monarch, $status, $date_created);
    
    $count = $_POST['count'];
    $id_item_stock = $_POST['id_item_stock'];
    $qty = $_POST['qty'];
    $i = 0;
    for($i;$i<$count;$i++){
        $object->Create_Item_Billing($id_billing, array_pop($id_item_stock), array_pop($qty));
    }
}
?>