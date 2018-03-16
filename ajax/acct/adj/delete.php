<?php
if (isset($_POST['id']) && isset($_POST['id']) != "") {
    require '../lib.php';
    $user_id = $_POST['id'];
 
    $object = new Adjustment();
    $object->Delete($user_id);
}
?>