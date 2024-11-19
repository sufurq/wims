<?php
require_once "../util/dbhelper.php";

$db = new DbHelper();

if (isset($_GET['purchase_order_id'])) {
    $purchase_order_id = intval($_GET['purchase_order_id']);
    
    $purchase_order_details = $db->get_purchase_order_details($purchase_order_id);
    
    if (!empty($purchase_order_details)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Page</title>
</head>
        <body>

            <h2>Order Information</h2>
    <?php foreach ($purchase_order_details as $row) : ?>
    <h2>Supplier Information</h2>
    <p><strong>Supplier:</strong> <?= htmlspecialchars($row->description); ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($row->address); ?></p>
    <p><strong>Order Date:</strong> <?= htmlspecialchars($row->order_date); ?></p>
    <p><strong>Mode of Procurement:</strong> <?= htmlspecialchars($row->mode_of_procurement); ?></p>
    <p><strong>Procurement Number:</strong> <?= htmlspecialchars($row->procurement_number); ?></p>
    <p><strong>Place of Delivery:</strong> <?= htmlspecialchars($row->place_of_delivery); ?></p>
    <p><strong>Delivery Date:</strong> <?= htmlspecialchars($row->delivery_date); ?></p>
    <p><strong>Term of Delivery:</strong> <?= htmlspecialchars($row->term_of_delivery); ?></p>
    <?php break; ?>
    <?php endforeach; ?>
    <a href="#"><button class="new-record-btn"><b>New Delivery</b></button></a>

    <h2>Purchase Order</h2>
            <?php if (!empty($purchase_order_details)) : ?>
                <table border="1" cellpadding="10">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Unit of Measure</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchase_order_details as $item) : ?>
                            <tr>
                                <td><?php echo $item->category; ?></td>
                                <td><?php echo $item->item_description; ?></td>
                                <td><?php echo $item->unit_of_measure; ?></td>
                                <td><?php echo $item->quantity; ?></td>
                                <td><?php echo $item->unit_price; ?></td>
                                <td><?php echo $item->amount; ?></td>
                                <td>
                                <button onclick="showAlertEdit(this);" class="btn btn-primary btn-sm" data-id="<?= $rows['id'] ?>">
                                                Deliveries
                                            </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No items found for this purchase order.</p>
            <?php endif; ?>

        </body>
        </html>
<?php
    } else {
        echo "<p>Purchase Order not found.</p>";
    }
} else {
    echo "<p>Purchase Order ID not specified.</p>";
}
?>
