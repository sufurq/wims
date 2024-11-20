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




$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receipt_number = isset($_POST['receipt_number']) ? $_POST['receipt_number'] : null;
$sales_representative = isset($_POST['sales_representative']) ? $_POST['sales_representative'] : null;
$checked_by = isset($_POST['checked_by']) ? $_POST['checked_by'] : null;

if ($receipt_number && $sales_representative && $checked_by) {
    $stmt = $conn->prepare("INSERT INTO delivery_receipts (receipt_number, sales_representative, checked_by) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $receipt_number, $sales_representative, $checked_by);

    if ($stmt->execute()) {
        echo "Delivery receipt submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();

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
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"] {
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
    <form action="dr_receive.php" method="post">
        <label for="receipt_number">Receipt Number:</label>
        <input type="text" id="receipt_number" name="receipt_number" required>

        <label for="sales_representative">Sales Representative:</label>
        <input type="text" id="sales_representative" name="sales_representative" required>

        <label for="checked_by">Checked By:</label>
        <input type="text" id="checked_by" name="checked_by" required>

        <div class="form-group full-width">
            <div class="form-actions">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Item Id</th>
                <th class="text-center">Description</th>
                <th class="text-center">Unit Of Issue</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($display_data as $row) : ?>
                <tr>


                    <td class="text-center"><?= htmlspecialchars($row->id); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->item_description); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->unit_of_measure); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->quantity); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->unit_price); ?></td>
                    <td class="text-center"><?= htmlspecialchars($row->amount); ?></td>
                    <td class="text-center">
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm edit-button" data-id="<?= htmlspecialchars($row->id); ?>" data-description="<?= htmlspecialchars($row->item_description); ?>" data-category="<?= htmlspecialchars($row->category); ?>" data-unit="<?= htmlspecialchars($row->unit_of_measure); ?>" data-toggle="modal" data-target="#editModal">
                            Edit
                        </button>
                        </button>

                        <!-- Modal for Editing POD Item -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="../crud_form/edit_pod.php" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit POD Item</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="edit_id" name="id">

                                            <div class="form-group">
                                                <label for="edit_category">Category</label>
                                                <input type="text" id="edit_category" name="category" class="form-control" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="edit_unit">Unit of Measure</label>
                                                <input type="text" id="edit_unit" name="unit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).on('click', '.edit-button', function() {
            // Get data attributes from the clicked button
            const id = $(this).data('id');
            const description = $(this).data('description');
            const category = $(this).data('category');
            const unit = $(this).data('unit');

            // Set the data into modal inputs
            $('#edit_id').val(id);
            $('#edit_category').val(category);
            $('#edit_description').val(description);
            $('#edit_unit').val(unit);
        });
    </script>

</body>

</html>