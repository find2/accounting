<?php
if (isset($_POST['name']) ) {
    require("../lib.php");
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $object = new Supplier();
    $object->Create($name, $phone);
}
?>