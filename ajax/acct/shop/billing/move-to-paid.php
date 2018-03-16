<?php
    require '../lib.php';
    $object = new Billing();
    $id = $_POST['id'];
    $object->Move_To_Paid($id);
    // $object->Move_Item($id);
?>