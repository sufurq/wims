<?php
require_once "../util/dbhelper.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
$purchase_order_id = isset($_GET["purchase_order_id"]) ? $_GET["purchase_order_id"] : null;

    $db = new DbHelper();
    $result = $db->deletePod_Items($id); 
    header("Location: ../page/view_details_purchase_order.php?message=" . urlencode($result) . "&purchase_order_id=" . urlencode($purchase_order_id));
        exit();
} else {
    header("Location: ./index.php?message=" . urlencode("Invalid ID provided for deletion."));
    exit();
}
?>

