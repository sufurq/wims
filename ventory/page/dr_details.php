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
    <title>Purchase Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h2 {
            color: #2e3d56;
        }
        p {
            margin: 5px 0;
        }
        .new-record-btn {
            background-color: #2e3d56;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }
        .new-record-btn:hover {
            background-color: #1f2b3a;
        }
        hr {
            border: 1px solid #ccc;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h2>Delivery Receipts</h2>
    <?php
    $receiptsDisplayed = [];
    foreach ($purchase_order_details as $row) : 
        if (!in_array($row->dr_id, $receiptsDisplayed) && !empty($row->dr_id)) :
            $receiptsDisplayed[] = $row->dr_id;
    ?>
        <p><strong>Delivery Receipt Number:</strong> <?= htmlspecialchars($row->receipt_number); ?></p>
        <p><strong>Sales Representative:</strong> <?= htmlspecialchars($row->sales_representative); ?></p>
        <p><strong>Checked By:</strong> <?= htmlspecialchars($row->checked_by); ?></p>
        <p><strong>Created At:</strong> <?= htmlspecialchars($row->created_at); ?></p>
        <hr>
    <?php 
        endif;
    endforeach; 

    if (empty($receiptsDisplayed)) : ?>
        <p>No delivery receipts available for this purchase order.</p>
    <?php endif; ?>

    <h2>Purchase Order Items</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit of Measure</th>
                <th>Serial ID</th>
                <th>Date of Expiry</th>
                <th>Unit Cost</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchase_order_details as $item) : ?>
                <tr>
                    <td><?= htmlspecialchars($item->category); ?></td>
                    <td><?= htmlspecialchars($item->item_description); ?></td>
                    <td><?= htmlspecialchars($item->quantity); ?></td>
                    <td><?= htmlspecialchars($item->unit_of_measure); ?></td>
                    <td></td>
                    <td></td>
                    <td><?= htmlspecialchars($item->unit_price); ?></td>
                    <td><?= htmlspecialchars($item->amount); ?></td>
                    <td>
                        <button onclick="showAlertEdit(this);" class="btn btn-primary btn-sm" data-id="<?= $item->id ?>">
                            Deliveries
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="create_delivery.php?purchase_order_id=<?= $purchase_order_id; ?>">
        <button class="new-record-btn"><b>New Delivery</b></button>
    </a>
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