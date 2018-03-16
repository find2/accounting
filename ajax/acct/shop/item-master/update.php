<?php
if (isset($_POST)) {
    require '../lib.php';
    $object = new Item_Master();
 
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
 
    $object->Update($id, $name, $code);
}