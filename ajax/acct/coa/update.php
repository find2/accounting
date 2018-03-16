<?php
if (isset($_POST)) {
    require '../lib.php';
 
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];
 
    $object = new COA();
 
    $object->Update($code, $name, $type, $balance, $id);
}
?>