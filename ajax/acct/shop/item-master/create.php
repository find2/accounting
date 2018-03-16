<?php
if (isset($_POST['name']) ) {
    require("../lib.php");
    $name = $_POST['name'];
    $code = $_POST['code'];
    $object = new Item_Master();
    $object->Create($name, $code);
}
?>