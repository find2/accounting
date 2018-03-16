<?php
if (isset($_POST)) {
    require '../lib.php';
 
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $object = new Supplier();
 
    $object->Update($id, $name, $phone);
}