<?php
    require '../lib.php';
    $object = new Item_Po_Inv();
    $id = $_POST['id'];
    $object->Move_To_Inv($id);
    $object->Move_Item($id);
?>