<?php

require_once "./util/dbhelper.php";
$db = new DbHelper();
$display = $db->display_value_all_purchase();
$display1 = $db->display_status();
include('./search/serach_pod_tables.php');

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

    <header>
        <div class="logo-title"><img src="img/coclogo.png" width="300" alt="Company Logo"></div>
    </header>

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


    <div class="container">
        <aside class="sub-menu">
            <h1>
                <center><img src="img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center>
            </h1>
            <ul>
                <center>
                    <li><a href="pod.php">Dashboard</a></li>
                </center>
                <center>
                    <li class="selected"><a href="index.php" style="color: white">Purchase Order</a></li>
                </center>
                <center>
                    <li><a href="dr_page.php">Delivery Receipt</a></li>
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
                    <li><a href="./report/reports.php">Reports</a></li>
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

        <section class="purchase-order">
            <center>
                <h2>Purchase Order</h2>
            </center>
            <a href="npo.php"><button class="new-record-btn"><b>New Record</b></button></a>

            <br>
            <form method="GET" action="filter_purchase_orders.php">
                <div class="dropdown-container">

                    <select class="status-dropdown" name="status" onchange="this.form.submit()">
                        <option value="deleted" <?= isset($_GET['status']) && $_GET['status'] == 'deleted' ? 'selected' : '' ?>>Deleted</option>
                        <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="partial" <?= isset($_GET['status']) && $_GET['status'] == 'partial' ? 'selected' : '' ?>>Partial</option>
                        <option value="fully-delivered" <?= isset($_GET['status']) && $_GET['status'] == 'fully-delivered' ? 'selected' : '' ?>>Fully Delivered</option>
                    </select>
                </div>
            </form>

            <br>

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
                            <?php foreach ($display as $row) :
                                $delivery_status = 'Pending';
                                foreach ($display1 as $row1) {
                                    if ($row1->purchase_order_id == $row->purchase_order_id) {
                                        $delivery_status = $row1->delivery_status;
                                        break;
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row->purchase_order_id); ?></td>
                                    <td><?= htmlspecialchars($row->purchase_order_number); ?></td>
                                    <td><?= htmlspecialchars($row->order_date); ?></td>
                                    <td><?= htmlspecialchars($row->procurement_number); ?></td>
                                    <td><?= htmlspecialchars($row->description); ?></td>
                                    <td><?= htmlspecialchars($row->Total_Amount); ?></td>
                                    <td><?= htmlspecialchars($delivery_status); ?></td>
                                    <td>
                                        <button class="toggle-btn btn btn-info btn-sm" onclick="toggleDetails(this)">+</button>
                                    </td>
                                </tr>

                                <tr class="details-row" style="display:none;">
                                    <td colspan="7">
                                        <div class="details-container p-3 bg-light">
                                            <p><strong>Procurement Model:</strong> <?= htmlspecialchars($row->mode_of_procurement); ?></p>
                                            <p><strong>Procurement Date:</strong> <?= htmlspecialchars($row->procurement_date); ?></p>
                                            <p><strong>Place of Delivery:</strong> <?= htmlspecialchars($row->place_of_delivery); ?></p>
                                            <p><strong>Date of Delivery:</strong> <?= htmlspecialchars($row->delivery_date); ?></p>
                                            <p><strong>Term of Delivery:</strong> <?= htmlspecialchars($row->term_of_delivery); ?></p>
                                            <p><strong>Status:</strong> <?= htmlspecialchars($delivery_status); ?></p>
                                            <br>
                                            <div class="action-buttons mt-3">
                                                <button class="edit-btn btn btn-warning btn-sm" onclick="window.location.href='./crud_form/purchase_order_edit.php?purchase_order_id=<?= $row->purchase_order_id; ?>&supplier_id=<?= $row->supplier_id; ?>'">Edit</button>
                                                <button class="details-btn btn btn-info btn-sm" onclick="window.location.href='./page/view_deatails_purchase_oder.php?id=<?= $row->purchase_order_id ?>'">Details</button>
                                                <button class="delete-btn btn btn-danger btn-sm" onclick="window.location.href='./logic/sample.delete.php?id=<?= $row->purchase_order_id; ?>'">Delete</button>
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


</body>

</html>