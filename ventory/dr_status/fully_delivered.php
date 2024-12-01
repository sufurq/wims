<?php

require_once "../util/dbhelper.php";
$db = new DbHelper();

$dr_status = "Fully Delivered";

try {
    $display = $db->display_status2($dr_status);
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Deliveries</title>
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

    <!-- Main Section -->
    <div class="container">
        <aside class="sub-menu">
            <ul>
                <li><a href="../pod.php">Dashboard</a></li>
                <li><a href="../index.php">Purchase Order</a></li>
                <li><a href="../dr_page.php">Delivery Receipt</a></li>
                <li><a href="#">POWE</a></li>
                <li><a href="#">RIS</a></li>
                <li><a href="#">Audit</a></li>
                <li><a href="#">Reports</a></li>
                <hr>
                <div class="dropdown">
                    <button class="dropdown-btn">Master Pages<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Site</a>
                        <a href="#">Item Category</a>
                        <a href="#">Item</a>
                        <a href="#">Supplier</a>
                        <a href="#">Settings</a>
                    </div>
                </div>
                <hr>
                <li><a href="#">Log Out</a></li>
            </ul>
        </aside>

        <!-- Section for Pending Deliveries -->
        <section class="purchase-order">
            <center>
                <h2>Pending Deliveries</h2>
            </center>
            <div class="dropdown-container">
    <select class="status-dropdown" onchange="redirectToPage(this)">
        <option value="../dr_status/pending.php" <?= basename($_SERVER['PHP_SELF']) === 'pending.php' ? 'selected' : ''; ?>>Pending</option>
        <option value="../dr_status/partial.php" <?= basename($_SERVER['PHP_SELF']) === 'partial.php' ? 'selected' : ''; ?>>Partial</option>
        <option value="../dr_status/fully_delivered.php" <?= basename($_SERVER['PHP_SELF']) === 'fully_delivered.php' ? 'selected' : ''; ?>>Fully Delivered</option>
    </select>
</div>


            <!-- Table Content -->
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>P.O. ID</th>
                            <th>P.O. #</th>
                            <th>Supplier</th>
                            <th>Procurement No</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (!empty($display)) : ?>
        <?php foreach ($display as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row->purchase_order_id); ?></td>
                <td><?= htmlspecialchars($row->purchase_order_number); ?></td>
                <td><?= htmlspecialchars($row->supplier_description); ?></td>
                <td><?= htmlspecialchars($row->procurement_number); ?></td>
                <td><?= htmlspecialchars($row->delivery_date); ?></td>
                <td><?= htmlspecialchars($row->dr_status); ?></td>
                <td>
                    <button class="details-btn btn btn-info btn-sm" 
                        onclick="window.location.href='status_details.php?id=<?= htmlspecialchars($row->purchase_order_id); ?>'">
                        Details
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7" style="text-align: center;">No pending deliveries found.</td>
        </tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        function toggleDetails(button) {
            const detailsRow = button.closest("tr").nextElementSibling;
            detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
        }
    </script>
     <script>
    function redirectToPage(selectElement) {
        const selectedPage = selectElement.value; // Get the selected page's URL
        window.location.href = selectedPage; // Redirect to the selected page
    }
</script>

</body>

</html>
