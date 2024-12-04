<?php
require_once "./util/dbhelper.php";
$db = new DbHelper();

// Get the status from the dropdown or default to 'all'
$status = isset($_GET['status']) ? $_GET['status'] : 'all';

// Fetch the filtered purchase orders

$display = $db->status_fully_delivered($status);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo-title">
            <img src="img/coclogo.png" width="300" alt="Company Logo">
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
            <img src="img/avatar.png" alt="Profile" class="profile-avatar">
            <span>Jcolonia</span>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="container">
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1>
                <center><img src="img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center>
            </h1>
            <ul>
                <center><li><a href="pod.php">Dashboard</a></li></center>
                <center><li class="selected"><a href="index.php" style="color: white">Purchase Order</a></li></center>
                <center><li><a href="dr_page.php">Delivery Receipt</a></li></center>
                <center><li><a href="#">POWE</a></li></center>
                <center><li><a href="#">RIS</a></li></center>
                <center><li><a href="#">Audit</a></li></center>
                <center><li><a href="#">Reports</a></li></center>
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
                <center><li><a href="#">Log Out</a></li></center>
            </ul>
        </aside>

        <section class="purchase-order">
            <center>
                <h2>Purchase Order</h2>
            </center>
            <a href="npo.php">
                <button class="new-record-btn"><b>New Record</b></button>
            </a>
            <br>
            <center>
                <form method="GET" action="index.php">
                    <div class="dropdown-container">
                        <select class="status-dropdown" name="status" onchange="this.form.submit()">
                            <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>All</option>
                            <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="partial" <?= $status == 'partial' ? 'selected' : '' ?>>Partial</option>
                            <option value="fully-delivered" <?= $status == 'fully-delivered' ? 'selected' : '' ?>>Fully Delivered</option>
                            <option value="deleted" <?= $status == 'deleted' ? 'selected' : '' ?>>Deleted</option>
                        </select>
                    </div>
                </form>
            </center>
            <br>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>P.O #</th>
                            <th>Date Created</th>
                            <th>Procurement No</th>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($display as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row->purchase_order_id); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_numbers); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_date); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_pn); ?></td>
                                <td><?= htmlspecialchars($row->suppliers_des); ?></td>
                                <td><?= htmlspecialchars($row->total_delivery_quantity); ?></td>
                                <td><?= htmlspecialchars($row->delivery_status); ?></td>
                                <td>
                                    <button class="toggle-btn btn btn-info btn-sm" onclick="toggleDetails(this)">+</button>
                                </td>
                            </tr>
                            <tr class="details-row" style="display:none;">
                                <td colspan="8">
                                    <div class="details-container p-3 bg-light">
                                        <p><strong>Place of Delivery:</strong> <?= htmlspecialchars($row->place_of_delivery); ?></p>
                                        <p><strong>Date of Delivery:</strong> <?= htmlspecialchars($row->delivery_date); ?></p>
                                        <p><strong>Term of Delivery:</strong> <?= htmlspecialchars($row->term_of_delivery); ?></p>
                                        <p><strong>Status:</strong> <?= htmlspecialchars($row->delivery_status); ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="nav-container">
                <button class="nav-btn" id="prev-btn">Previous</button>
                <div class="number-box" id="number-display">1</div>
                <button class="nav-btn" id="next-btn">Next</button>
            </div>
        </section>
    </div>

    <script>
        function toggleDetails(button) {
            const detailsRow = button.closest("tr").nextElementSibling;
            detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
        }

        function editRecord(id) {
            alert(`Edit Record ID: ${id}`);
        }

        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                alert(`Record ID ${id} deleted.`);
            }
        }
    </script>
</body>

</html>
