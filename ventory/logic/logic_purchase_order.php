<?php
session_start();
require_once "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_POST['submit'])) {
    purchase_order($db);
}

function purchase_order($db)
{

    $supplier_id = isset($_POST['supplier_id']) ? htmlspecialchars(trim($_POST['supplier_id'])) : null;
    $purchase_order_number = isset($_POST['purchase_order_number']) ? htmlspecialchars(trim($_POST['purchase_order_number'])) : null;
    $order_date = isset($_POST['order_date']) ? htmlspecialchars(trim($_POST['order_date'])) : null;
    $mode_of_procurement = isset($_POST['mode_of_procurement']) ? htmlspecialchars(trim($_POST['mode_of_procurement'])) : null;
    $procurement_number = isset($_POST['procurement_number']) ? htmlspecialchars(trim($_POST['procurement_number'])) : null;
    $procurement_date = isset($_POST['procurement_date']) ? htmlspecialchars(trim($_POST['procurement_date'])) : null;
    $place_of_delivery = isset($_POST['place_of_delivery']) ? htmlspecialchars(trim($_POST['place_of_delivery'])) : null;
    $delivery_date = isset($_POST['delivery_date']) ? htmlspecialchars(trim($_POST['delivery_date'])) : null;
    $term_of_delivery = isset($_POST['term_of_delivery']) ? htmlspecialchars(trim($_POST['term_of_delivery'])) : null;

    
    if (!$supplier_id || !$purchase_order_number || !$order_date) {
        $_SESSION["m"] = "Please fill in all required fields.";
        header("Location: ../page/np_order.php");
        exit();
    }

    // Data for insertion
    $table = "purchase_orders";
    $data = array(
        "supplier_id" => $supplier_id,
        "purchase_order_number" => $purchase_order_number,
        "order_date" => $order_date,
        "mode_of_procurement" => $mode_of_procurement,
        "procurement_number" => $procurement_number,
        "procurement_date" => $procurement_date,
        "place_of_delivery" => $place_of_delivery,
        "delivery_date" => $delivery_date,
        "term_of_delivery" => $term_of_delivery,
        "status" => "Pending"
    );

    
    $success = $db->addRecord($table, $data);

    if ($success) {
        $_SESSION["m"] = "Purchase order submitted successfully.";
        header("Location: ../page/cp_oder.php");
        exit();
    } else {
        $_SESSION["m"] = "Error processing your request. Please try again.";
        header("Location: ../user/fileComplaint.php");
        exit();
    }
}
