<?php
if (isset($_POST['id']) && isset($_POST['id']) != "") {
    require '../lib.php';
    $id = $_POST['id'];
 
    $object = new Item_Stock();
 
    echo $object->Details($id);
}
?>