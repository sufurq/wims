<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

// Check if the ID is set
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("ID NOT SET");
}

// Fetch the data
$display = $db->display_receipt($id);
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
    <?php if (!empty($display)): ?>
        <!-- Display Delivery Information -->
        <p><strong>Delivery Information:</strong></p>
        <?php foreach ($display as $row): ?>
            <?php if (!empty($row->delivery_info)): ?>
                <p><?= nl2br(htmlspecialchars($row->delivery_info)); ?></p>
            <?php break; // Display only once since it's grouped by purchase order ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <hr>
    <?php else: ?>
        <p>No delivery receipts available for this purchase order.</p>
    <?php endif; ?>

    <h2>Purchase Order Items</h2>
    <table>
        <thead>
            <tr>
                
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
            <?php if (!empty($display)): ?>
                <!-- Display Each Item -->
                <?php foreach ($display as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row->item_description); ?></td>
                        <td><?= htmlspecialchars($row->quantity); ?></td>
                        <td><?= htmlspecialchars($row->unit_of_measure); ?></td>
                        <td><?= htmlspecialchars($row->serial_Id); ?></td>
                        <td><?= htmlspecialchars($row->date_expiry); ?></td>
                        <td><?= htmlspecialchars($row->unit_price); ?></td>
                        <td><?= htmlspecialchars($row->amount); ?></td>
                        <td>
                            <button onclick="showAlertEdit(this);" class="btn btn-primary btn-sm" 
                                data-id="<?= htmlspecialchars($row->serial_Id); ?>">
                                Deliveries
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No items found for this purchase order.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Button for Creating a New Delivery -->
    <a href="create_delivery.php?purchase_order_id=<?= htmlspecialchars($id); ?>">
        <button class="new-record-btn"><b>New Delivery</b></button>
    </a>
</body>
</html>
