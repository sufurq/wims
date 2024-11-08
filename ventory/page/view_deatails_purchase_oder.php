<?php
require_once "../util/dbhelper.php";

// Check if 'id' is set in the query parameters
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID is not defined.");
}

$db = new DbHelper();
$unique_id = $db->display_all_pod_items_where_supplier_id($id);

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
    <div style="margin-right:87%; margin-top:10px;" class="logo-title text-center my-3">
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sub Menu -->
            <aside class="col-md-3 sub-menu bg-light p-3 d-flex flex-column align-items-center">
                <h1 class="text-center mb-4">
                    <img src="../img/box.png" height="60" alt="Icon">&nbsp;SIT.io
                </h1>
                <ul class="nav flex-column w-100 text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link selected" href="index.php">Purchase Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Delivery Receipt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">POWE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">RIS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Audit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reports</a>
                    </li>
                    <hr class="w-100">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Master Pages</a>
                    </li>
                    <hr class="w-100">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#">Log Out</a>
                    </li>
                </ul>
            </aside>

            <!-- Content -->
            <div class="col-md-9 content-wrapper p-5">
                <?php if (!empty($unique_id)) : ?>
                    <button class="details-btn btn btn-info btn-sm w-100 mb-3" style="height: 60px;" onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($unique_id[0]->supplier_id); ?>&purchase_order_id=<?= urlencode($unique_id[0]->purchase_order_id); ?>'">
                    <b>New Record</b>
                    </button>
                <?php endif; ?>

<<<<<<< HEAD
                <?php if (empty($unique_id)) : ?>
                    <p class="text-center text-muted font-weight-bold">No purchase records found</p>
                    <button class="details-btn btn btn-info btn-sm" onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($unique_id[0]->supplier_id); ?>&purchase_order_id=<?= urlencode($unique_id[0]->purchase_order_id); ?>'">
                        <b>New Record</b>
                    </button>
                <?php else : ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Unit of Issue #</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Cost</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Action</th>
=======
            <?php endif; ?>

            <?php if (empty($unique_id)) : ?>
                <p style="text-align: center; font-size: 1.5em; color: #555;">No purchase</p>
                <button class="details-btn btn btn-info btn-sm" onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($unique_id[0]->supplier_id); ?>&purchase_order_id=<?= urlencode($unique_id[0]->purchase_order_id); ?>'">
                    <b>New Record</b>
                </button>
            <?php else : ?>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Unit of Issue</th>
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
                                <td><?= htmlspecialchars($row->unit_of_measure); ?></td>
                                <td><?= htmlspecialchars($row->item_description); ?></td>
                                <td><?= htmlspecialchars($row->quantity); ?></td>
                                <td><?= htmlspecialchars($row->unit_price); ?></td>
                                <td><?= htmlspecialchars($row->amount); ?></td>
                                <td>DELETED</td>
>>>>>>> cc735e06445ad71e8b6d50e19e758d364630aea0
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unique_id as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row->category); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->item_description); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->quantity); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->unit_price); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->amount); ?></td>
                                    <td class="text-center">
                                        <button onclick="showAlertEdit(this);" class="btn btn-primary btn-sm" data-id="<?= $row->id ?>">Edit</button>
                                        <button onclick="showAlertDelete(this);" class="btn btn-danger btn-sm" data-id="<?= $row->id ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <!-- Pagination -->
               
            </div>
        </div>
    </div>
</body>

</html>
