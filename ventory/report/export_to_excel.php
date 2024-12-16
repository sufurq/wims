<?php
session_start();
require_once "../util/dbhelper.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["purchase_order_id"])) {
    $purchaseOrderId = filter_input(INPUT_POST, "purchase_order_id", FILTER_SANITIZE_NUMBER_INT);

    if ($purchaseOrderId) {
        $db = new DbHelper();

        // Fetch the report data
        $data = $db->report($purchaseOrderId);

        // Fetch PO # and Total Amount (Cost)
        $purchaseOrderDetails = $db->display_value_all_purchas($purchaseOrderId); // Pass purchase_order_id to the function

        if (!empty($data) && !empty($purchaseOrderDetails)) {
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=purchase_order_{$purchaseOrderId}.xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            // Output the PO # and Total Cost in Excel format
            echo "PO #\t" . htmlspecialchars($purchaseOrderDetails['purchase_order_number']) . "\n";
            echo "P.O. Total Cost\t" . htmlspecialchars($purchaseOrderDetails['Total_Amount']) . "\n\n";

            // Output the table header
            echo "Item Code\tDescription\tUnit of Measure\tQuantity\tAmount\tDelivered UoM\tDelivered Qty\tDelivered Amount\tRemaining Quantity\tRemarks\n";

            // Output the table data
            foreach ($data as $row) {
                echo implode("\t", [
                    htmlspecialchars($row->id),
                    htmlspecialchars($row->description),
                    htmlspecialchars($row->unit_of_measure),
                    htmlspecialchars($row->quantity),
                    htmlspecialchars($row->amount),
                    htmlspecialchars($row->uom),
                    htmlspecialchars($row->del_quantity),
                    htmlspecialchars($row->del_amount),
                    htmlspecialchars($row->remaining_quantity),
                    htmlspecialchars($row->delivery_status)
                ]) . "\n";
            }

            exit;
        } else {
            echo "No data found for the selected Purchase Order.";
        }
    } else {
        echo "Invalid Purchase Order ID.";
    }
} else {
    echo "No Purchase Order ID provided.";
}
?>
