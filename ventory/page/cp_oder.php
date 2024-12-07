<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

$suppliers = $db->getAllRecords("suppliers");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Form</title>
</head>
<body>

<h2>Purchase Order Form</h2>

<form action="../logic/logic_purchase_order.php" method="POST">


    <label for="supplier_id">Supplier ID:</label><br>
    <select id="supplier_id" name="supplier_id" required>
        <option value="">Select Supplier</option>
        <?php
        if ($suppliers) {
            foreach ($suppliers as $supplier) {
                echo "<option value=\"" . htmlspecialchars($supplier['supplier_id']) . "\">" 
                     . htmlspecialchars($supplier['description']) . "</option>";
            }
        } else {
            echo "<option value=\"\">No suppliers found</option>";
        }
        ?>
    </select><br><br>

    <label for="purchase_order_number">Purchase Order Number:</label><br>
    <input type="text" id="purchase_order_number" name="purchase_order_number" required><br><br>

    <label for="order_date">Order Date:</label><br>
    <input type="date" id="order_date" name="order_date" required><br><br>

    <label for="mode_of_procurement">Mode of Procurement:</label><br>
    <input type="text" id="mode_of_procurement" name="mode_of_procurement" required><br><br>

    <label for="procurement_number">Procurement Number:</label><br>
    <input type="text" id="procurement_number" name="procurement_number" required><br><br>

    <label for="procurement_date">Procurement Date:</label><br>
    <input type="date" id="procurement_date" name="procurement_date" required><br><br>

    <label for="place_of_delivery">Place of Delivery:</label><br>
    <input type="text" id="place_of_delivery" name="place_of_delivery" required><br><br>

    <label for="delivery_date">Delivery Date:</label><br>
    <input type="date" id="delivery_date" name="delivery_date" required><br><br>

    <label for="term_of_delivery">Term of Delivery:</label><br>
    <input type="text" id="term_of_delivery" name="term_of_delivery" required><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php require_once "../shared/layout.php";?>
</body>
</html>
