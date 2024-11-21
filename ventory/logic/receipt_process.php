<?php
require_once "../util/dbhelper.php"; 
$db = new DbHelper();

if (isset($_POST["submit"])) {
    $purchase_order_id = isset($_POST["purchase_order_id"]) ? trim($_POST["purchase_order_id"]) : null;
    $receipt_number = isset($_POST["receipt_number"]) ? trim($_POST["receipt_number"]) : null;
    $sales_representative = isset($_POST["sales_representative"]) ? trim($_POST["sales_representative"]) : null;
    $checked_by = isset($_POST["checked_by"]) ? trim($_POST["checked_by"]) : null;

    if (!empty($receipt_number) && !empty($sales_representative) && !empty($checked_by)) {
        $addReceipt = $db->addrecord("delivery_receipts", [
            "purchase_order_id" => $purchase_order_id, 
            "receipt_number" => $receipt_number,
            "sales_representative" => $sales_representative,
            "checked_by" => $checked_by
        ]);


        if ($addReceipt > 0) {
            header("Location: ../dr_page.php");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+ADDED");
            exit();
        }
    } else {
        header("Location: ../?m=REQUIRED+FIELDS+MISSING");
        exit();
    }
}
?>
