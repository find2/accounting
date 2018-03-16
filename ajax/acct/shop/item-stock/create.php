<?php
if (isset($_POST['name']) ) {
    require("../lib.php");
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $buy = $_POST['buy'];
    $sell = $_POST['sell'];
    $id_supplier = $_POST['id_supplier'];
    $id_master = $_POST['id_master'];
    $object = new Item_Stock();
    $object->Create($id_master, $id_supplier, $qty, $buy, $sell, $name);
}
?>