<?php
if (isset($_POST['id']) && isset($_POST['id']) != "") {
    require '../lib.php';
    $id = $_POST['id'];
 
    $object = new Supplier();
    $object->Delete($id);
}
?>