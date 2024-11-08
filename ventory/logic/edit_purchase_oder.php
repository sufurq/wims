<?php
include "../util/dbhelper.php";
$db = new dbhelper();

if (isset($_POST["submit"])) {
    $supplier_Id = $_POST['supplier_Id'];
    $purchase_order_id = $_POST['purchase_order_id'];
    $purchase_order_number = $_POST['po_number'];
    $po_date = $_POST['po_date'];
    $procurement_model = $_POST['procurement_model'];
    $procurement_number = $_POST['procurement_number'];
    $procurement_date = $_POST['procurement_date'];
    $delivery_place = $_POST['delivery_place'];
    $delivery_date = $_POST['delivery_date'];
    $terms_delivery = $_POST['terms_delivery'];
  
    // Check if required fields are not empty
    if (!empty(trim($purchase_order_number)) && !empty(trim($po_date)) && !empty(trim($procurement_model)) && !empty(trim($procurement_number)) && !empty(trim($procurement_date)) && !empty(trim($delivery_place)) && !empty(trim($delivery_date)) && !empty(trim($terms_delivery))) {
        
        // Update record with supplier_Id and purchase_order_id as conditions
        $updatePod = $db->updateRecord(
            "purchase_orders",
            [
                "purchase_order_number" => $purchase_order_number,
                "order_date" => $po_date, // Fixed variable name
                "mode_of_procurement" => $procurement_model, // Ensure this matches your database column
                "procurement_number" => $procurement_number,
                "procurement_date" => $procurement_date,
                "place_of_delivery" => $delivery_place,
                "delivery_date" => $delivery_date,
                "term_of_delivery" => $terms_delivery
            ], 
            
        );

        // Redirect based on the update result
        if ($updatePod > 0) {
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+UPDATED");
            exit();
        }
    } else {
        header("Location: ../?m=PLEASE+FILL+IN+ALL+REQUIRED+FIELDS");
        exit();
    }
} else {
    header("Location: ../");
    exit();
}
?>
