<?php
if (isset($_POST['month']) && isset($_POST['month']) != "") {
    require '../lib.php';
    $month = $_POST['month'];
    $year = $_POST['year'];
    $ledger = $_POST['ledger'];
 
    $object = new COA();
    $object->Delete_month($month, $year, $ledger);
}
?>