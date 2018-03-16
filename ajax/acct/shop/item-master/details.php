<?php
if (isset($_POST['id']) && isset($_POST['id']) != "") {
    require '../lib.php';
    $user_id = $_POST['id'];
 
    $object = new Item_Master();
 
    echo $object->Details($user_id);
}
?>