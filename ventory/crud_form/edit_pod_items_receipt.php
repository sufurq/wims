<?php 
require_once "../util/dbhelper.php";
$db = new DbHelper();

$edit_receipt = $db->getRecord("pod_items", ["id" => $_GET["id"]]);

$formattedDate = !empty($edit_receipt["date_of_expiry"]) ? date("Y-m-d", strtotime($edit_receipt["date_of_expiry"])) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pod Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Pod Item</h2>
        <form action="../logic/edit_pod_items_receipt_side.php" method="post">
        <input type="hidden" name="pod_Id" value="<?= htmlspecialchars($edit_receipt['id']); ?>">            <div class="form-group">
                <label for="items">Description</label>
                <input type="text" id="items" name="items" class="form-control" value="<?= htmlspecialchars($edit_receipt["item_description"]); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?= htmlspecialchars($edit_receipt["quantity"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="uom">Unit of Measure</label>
                <input type="text" id="uom" name="uom" class="form-control" value="<?= htmlspecialchars($edit_receipt["unit_of_measure"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="serial_Id">Serial ID</label>
                <input type="number" id="serial_Id" name="serial_Id" class="form-control" value="<?= htmlspecialchars($edit_receipt["serial_Id"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="unit_cost">Unit Cost</label>
                <input type="number" id="unit_cost" name="unit_cost" step="0.01" class="form-control" value="<?= htmlspecialchars($edit_receipt["unit_price"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="date_of_exp">Date of Expiry</label>
                <input type="date" id="date_of_exp" name="date_of_exp" class="form-control" value="<?= htmlspecialchars($formattedDate); ?>" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" step="0.01" class="form-control" value="<?= htmlspecialchars($edit_receipt["amount"]); ?>" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
