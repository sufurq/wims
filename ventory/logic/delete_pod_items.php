<?php
require_once "../util/dbhelper.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $purchase_order_id = isset($_GET["purchase_order_id"]) ? intval($_GET["purchase_order_id"]) : null;

    $db = new DbHelper();
    $result = $db->deletePod_Items($id); 
    header("Location: ../page/view_deatails_purchase_oder.php?id=$purchase_order_id");
    exit();
}
?>
