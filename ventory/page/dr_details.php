<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_status'])) {
    $status = $_POST['status'];
    $dr_id = $_POST['dr_id'];

    $status = htmlspecialchars(trim($status));
    $dr_id = intval($dr_id);

    $conn = $db->getConnection();  

    $sql = "UPDATE delivery_receipts SET status = ? WHERE dr_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("si", $status, $dr_id);

    if ($stmt->execute()) {
        echo "<p>Status updated successfully.</p>";
    } else {
        echo "<p>Error updating status: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("ID NOT SET");
}

$conn = $db->getConnection();  

$display = $db->display_checker($id, $conn);
$display3 = $db->display_receipt($id, $conn);
$displayStatus = $db->display_status($id, $conn);
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
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination button {
            margin: 5px;
            padding: 8px 16px;
            background-color: #2e3d56;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .pagination button:hover {
            background-color: #1f2b3a;
        }
        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Delivery Receipts</h2>
<?php if (!empty($display)): ?>
    <?php foreach ($display as $row): ?>
        <p><strong>Delivery Receipt Number:</strong><?= nl2br(htmlspecialchars($row->receipt_number)); ?></p>
        <p><strong>Sales Representative:</strong><?= nl2br(htmlspecialchars($row->sales_representative)); ?></p>
        <p><strong>Checked By:</strong><?= nl2br(htmlspecialchars($row->checked_by)); ?></p>
        <form method="POST" action="">
            <label for="status"><strong>Status:</strong></label>
            <select name="status" id="status">
                <option value="Pending" <?= $row->delivery_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Partial" <?= $row->delivery_status == 'Partial' ? 'selected' : '' ?>>Partial</option>
                <option value="Fully Delivered" <?= $row->delivery_status == 'Fully Delivered' ? 'selected' : '' ?>>Fully Delivered</option>
            </select>
            <input type="hidden" name="dr_id" value="<?= htmlspecialchars($row->dr_id); ?>">
            <button type="submit" name="confirm_status" class="new-record-btn">Confirm</button>
        </form>
        <?php break; ?>
    <?php endforeach; ?>
    <hr>
<?php else: ?>
    <p>No delivery receipts available for this purchase order.</p>
<?php endif; ?>

<center><h2>DELIVERIES</h2></center>
<table id="itemsTable">
<thead>
    <tr>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit of Measure</th>
        <th>Serial Id</th>
        <th>Date Expiry</th>
        <th>Unit Cost</th>
        <th>Amount</th>
        <th>Action</th>
    </tr> 
</thead>
<tbody>
    <?php if (!empty($display3)): ?>
        <?php foreach ($display3 as $row): ?>
            <?php if (!empty($row->serial_Id) && $row->serial_Id != 0 && !empty($row->date_expiry)): ?>
                <tr>
                    <td><?= htmlspecialchars($row->item_descriptions); ?></td>
                    <td><?= htmlspecialchars($row->quantities); ?></td>
                    <td><?= htmlspecialchars($row->units_of_measure); ?></td>
                    <td><?= htmlspecialchars($row->serial_Id); ?></td>
                    <td><?= htmlspecialchars(date("m-d-Y", strtotime($row->date_expiry))); ?></td>
                    <td><?= htmlspecialchars($row->unit_prices); ?></td>
                    <td><?= htmlspecialchars($row->amounts); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No items found for this purchase order.</td>
        </tr>
    <?php endif; ?>
</tbody>
</table>

<!-- Pagination Controls -->
<div class="pagination" id="paginationControls"></div>

<script>
    const rowsPerPage = 4;
    const table = document.getElementById('itemsTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.rows);
    const paginationControls = document.getElementById('paginationControls');

    let currentPage = 1;
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function renderTable() {
        tbody.innerHTML = '';
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const rowsToDisplay = rows.slice(start, end);

        rowsToDisplay.forEach(row => tbody.appendChild(row));
        renderPaginationControls();
    }

    function renderPaginationControls() {
        paginationControls.innerHTML = '';
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            currentPage--;
            renderTable();
        });

        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            currentPage++;
            renderTable();
        });

        paginationControls.appendChild(prevButton);
        paginationControls.appendChild(nextButton);
    }

    renderTable();
</script>
</body>
</html>
