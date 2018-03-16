<?php
if (isset($_POST['code']) && isset($_POST['code']) != "") {
    require '../lib.php';
    $code = $_POST['code'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    
    $object = new Cash();
 
    echo $object->Select_Type($code, $month, $year);
}
?>