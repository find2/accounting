<?php
if (isset($_POST)) {
    require '../lib.php';
    $object = new Item_Stock();
 
    $id = $_POST['id'];
    $id_master = $_POST['id_master'];
    $id_supplier = $_POST['id_supplier'];
    $qty = $_POST['qty'];
    $buy = $_POST['buy'];
    $sell = $_POST['sell'];
    $name = $_POST['name'];
 
    $object->Update($id, $id_master, $id_supplier, $qty, $buy, $sell, $name);
}