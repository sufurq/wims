<?php
include "../util/dbhelper.php";
$db = new dbhelper();

if (isset($_POST["submit"])) {
    $purchase_order_id = $_POST['purchase_order_id'];
    $order_date = $_POST['order_date'];
    $purchase_order_number = $_POST['purchase_order_number'];
    $mode_of_procurement = $_POST['mode_of_procurement'];
    $procurement_number = $_POST['procurement_number'];
    $procurement_date = $_POST['procurement_date'];
    $place_of_delivery = $_POST['place_of_delivery'];
    $delivery_date = $_POST['delivery_date'];
    $term_of_delivery = $_POST['term_of_delivery'];

    // Check that all required fields are filled
    if (!empty(trim($purchase_order_id)) && !empty(trim($order_date)) && !empty(trim($purchase_order_number)) && !empty(trim($mode_of_procurement)) && !empty(trim($procurement_number)) && !empty(trim($procurement_date)) && !empty(trim($place_of_delivery)) && !empty(trim($delivery_date)) && !empty(trim($term_of_delivery))) {
        
        // Call the Edit_purchase_order function with the correct parameters
        $updatePod = $db->Edit_purchase_order($purchase_order_id, $purchase_order_number, $order_date, $mode_of_procurement, $procurement_number, $procurement_date, $place_of_delivery, $delivery_date, $term_of_delivery);

        if ($updatePod) {
            header("Location: ../pod.php");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+UPDATED");
            exit();
        }
    } else {
        header("Location: ../?m=ALL+FIELDS+ARE+REQUIRED");
        exit();
    }
} else {
    header("Location: ../");
    exit();
}
?>
