<?php 
require_once "../util/dbhelper.php";

// Check if 'id' is set in the query parameters
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID is not defined.");
}

$db = new DbHelper();
$unique_id = $db->join_pod_items_purchase_order_andSupplier($id);

$supplier_id = isset($_GET['supplier_id']) ? $_GET['supplier_id'] : null;
$purchase_order_id = isset($_GET['purchase_order_id']) ? $_GET['purchase_order_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/index.css">
    <script defer src="../script/script.js"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo-title">
            <img src="../img/coclogo.png" width="300" alt="Company Logo">
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <ul>
            <li>Home</li>
            <li>Groups</li>
            <li>Users</li>
        </ul>
        <div class="profile-section">
            <img src="../img/avatar.png" alt="Profile" class="profile-avatar">
            <span>Jcolonia</span>
        </div>
    </nav>

    <div class="container">
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1>
                <center>
                    <img src="../img/box.png" height="60" alt="Icon">&nbsp;SIT.io
                </center>
            </h1>
            <ul>
                <center><li><a href="dashboard.php">Dashboard</a></li></center>
                <center><li class="selected"><a href="index.php">Purchase Order</a></li></center>
                <center><li><a href="#">Delivery Receipt</a></li></center>
                <center><li><a href="#">POWE</a></li></center>
                <center><li><a href="#">RIS</a></li></center>
                <center><li><a href="#">Audit</a></li></center>
                <center><li><a href="#">Reports</a></li></center>
                <hr>
                <center><li><a href="#">Master Pages</a></li></center>
                <hr>
                <center><li><a href="#">Log Out</a></li></center>
            </ul>
        </aside>

        <!-- New Record Button -->
        <?php if (!empty($unique_id)): ?>
    <?php foreach ($unique_id as $index => $uni): ?>
        <?php if ($index == 0): // Only display the first button ?>
            <button class="details-btn btn btn-info btn-sm" 
                    onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($uni->supplier_id); ?>&purchase_order_id=<?= urlencode($uni->purchase_order_id); ?>'">
                <b>New Record</b>
            </button>
            <?php break; // Stop the loop after displaying one button ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

        <div class="table-container">
            <?php if (empty($unique_id)) : ?>
                <!-- Display message if there are no purchase orders -->
                <p style="text-align: center; font-size: 1.5em; color: #555;">No purchase</p>
            <?php else : ?>
                <!-- Display the table if there are purchase orders -->
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Unit of Issue #</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unique_id as $row) : ?>   
                            <tr>
                                <td><?= htmlspecialchars($row->category); ?></td>
                                <td><?= htmlspecialchars($row->item_description); ?></td>
                                <td><?= htmlspecialchars($row->quantity); ?></td>
                                <td><?= htmlspecialchars($row->unit_price); ?></td>
                                <td><?= htmlspecialchars($row->amount); ?></td>
                                <td>DELETED</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="nav-container">
            <button class="nav-btn" id="prev-btn">Previous</button>
            <div class="number-box" id="number-display">1</div>
            <button class="nav-btn" id="next-btn">Next</button>
        </div>
    </div>
</body>
</html>
