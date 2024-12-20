<?php
session_start();
require_once "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("ID NOT SET");
}

$conn = $db->getConnection();  

$display = $db->display_checker($id);
$display3 = $db->display_receipt($id);
$display_data = $db->dr_receive($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <?php break; ?>
    <?php endforeach; ?>
    <hr>
<?php else: ?>
    <p>No delivery receipts available for this purchase order.</p>
<?php endif; ?>

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
                    <a href="../crud_form/edit_pod_items_receipt.php?id=<?php echo urlencode($row->id); ?>" class="btn btn-primary btn-sm">+</a>
                    </td>
                </tr>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
    </tr> 
</thead>
<tbody>
    <?php if (!empty($display3)): ?>
        <?php foreach ($display3 as $row): ?>
            <?php if (!empty($row->delivery_receipts_dr_id) && $row->delivery_serial_id != 0 && !empty($row->delivery_date_of_exp)): ?>
                <tr>
                    <td><?= htmlspecialchars($row->delivery_items); ?></td>
                    <td><?= htmlspecialchars($row->delivery_quantity); ?></td>
                    <td><?= htmlspecialchars($row->delivery_uom); ?></td>
                    <td><?= htmlspecialchars($row->delivery_serial_id); ?></td>
                    <td><?= htmlspecialchars(date("m-d-Y", strtotime($row->delivery_date_of_exp))); ?></td>
                    <td><?= htmlspecialchars($row->delivery_unit_cost); ?></td>
                    <td><?= htmlspecialchars($row->delivery_amount); ?></td>
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
<?php require_once "../shared/layout.php"; ?>
</body>
</html>
