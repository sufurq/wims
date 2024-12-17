<?php

require_once "./util/dbhelper.php";
$db = new DbHelper();
$display = $db->display_status();
include('./search/searc_receipt.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Receipt Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script defer src="script/script.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo-title"><img src="img/coclogo.png" width="300" alt="Company Logo"></div>
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
                <center>
                    <li><a href="pod.php">Dashboard</a></li>
                </center>
                <center>
                <li><a href="index.php">Purchase Order</a></li>
                </center>
                <center>
                <li class="selected"><a href="dr_page.php" style="color: white">Delivery Receipt</a></li>
                </center>
                <center>
                    <li><a href="#">POWE</a></li>
                </center>
                <center>
                    <li><a href="#">RIS</a></li>
                </center>
                <center>
                    <li><a href="#">Audit</a></li>
                </center>
                <center>
                    <li><a href="report/reports.php">Reports</a></li>
                </center>
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
                <center>
                    <li><a href="#">Log Out</a></li>
                </center>
            </ul>
        </aside>

        <!-- Purchase Order Page -->
        <section class="purchase-order">
            <center>
                <h2>Delivery Receipt</h2>
            </center>
            <br>
            <center>
            <form method="GET" action="./dr_status/filter_status.php">
                <div class="dropdown-container">

                    <select class="status-dropdown" name="status" onchange="this.form.submit()">
                        <option value="deleted" <?= isset($_GET['status']) && $_GET['status'] == 'deleted' ? 'selected' : '' ?>>Deleted</option>
                        <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="partial" <?= isset($_GET['status']) && $_GET['status'] == 'partial' ? 'selected' : '' ?>>Partial</option>
                        <option value="fully-delivered" <?= isset($_GET['status']) && $_GET['status'] == 'fully-delivered' ? 'selected' : '' ?>>Fully Delivered</option>
                    </select>
                </div>
            </form>
            </center>

            <form method="GET" action="">
                    <div class="search-container">
                        <i class="fa fa-search search-icon"></i>
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input" 
                            placeholder="Search Purchase Orders" 
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        >
                        <button type="submit">Search</button>
                    </div>
            </form>

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
                        <?php foreach ($display as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row->purchase_order_id); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_numbers); ?></td>
                                <td><?= htmlspecialchars($row->suppliers_des); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_pn); ?></td>
                                <td><?= htmlspecialchars($row->purchase_orders_d_date); ?></td>
                                <td><?= htmlspecialchars($row->delivery_status); ?></td>
                                <td>
                                    <button class="toggle-btn btn btn-info btn-sm" onclick="toggleDetails(this)">+</button>
                                </td>
                            </tr>

                            <tr class="details-row" style="display:none;">
                                <td colspan="7">
                                    <div class="details-container p-3 bg-light">
                                        <div class="action-buttons mt-3">
                                        <button class="edit-btn btn btn-warning btn-sm" onclick="window.location.href='dr_receive.php?id=<?= $row->purchase_order_id; ?>'">Receive</button>
                                        <button class="details-btn btn btn-info btn-sm" onclick="window.location.href='./page/dr_details.php?id=<?= $row->purchase_order_id ?>'">Details</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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

        function editRecord(id) {
            alert(`Edit Record ID: ${id}`);
        }

        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {

                alert(`Record ID ${id} deleted.`);
            }
        }
    </script>
    <script>
    function redirectToPage(selectElement) {
        const selectedPage = selectElement.value;
        window.location.href = selectedPage;
    }
</script>
</body>
</html>