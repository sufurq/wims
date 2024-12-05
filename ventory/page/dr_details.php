<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("ID NOT SET");
}
require_once "./util/dbhelper.php";
$db = new DbHelper();
$display_data = $db->dr_receive($id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Receipt Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;

            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-actions {
            margin-top: 20px;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>New Delivery Receipt</h1>
    <form action="./logic/receipt_process.php" method="post">
    <input type="hidden" name="purchase_order_id" value="<?php echo $id; ?>">
        <label for="receipt_number">Receipt Number:</label>
        <input type="text" id="receipt_number" name="receipt_number" required>

        <label for="sales_representative">Sales Representative:</label>
        <input type="text" id="sales_representative" name="sales_representative" required>

        <label for="checked_by">Checked By:</label>
        <input type="text" id="checked_by" name="checked_by" required>

        <div class="form-group full-width">
            <div class="form-actions">
                <button type="submit" name="submit" class="submit-btn">Submit</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Item Id</th>
                <th class="text-center">Description</th>
                <th class="text-center">PO Details</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($display_data as $row) : ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($row->id); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->item_description); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->quantity) . " " . htmlspecialchars($row->unit_of_measure); ?></td>
                    <td class="text-center">
                        <a href="./crud_form/edit_pod_items_receipt.php?id=<?= urlencode($row->id); ?>" class="btn btn-primary btn-sm">+</a>
                    </td>
                </tr>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    </script>
</body>

</html>