<?php
require_once "../util/dbhelper.php";

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
    <link rel="stylesheet" href="../css/pod.css">
    <script defer src="../script/script.js"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo-title"><img src="../img/coclogo.png" width="300" alt="Company Logo"></div>
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
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1>
                <center><img src="../img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center>
            </h1>
            <ul>
                <center>
                    <li><a href="../pod.php">Dashboard</a></li>
                </center>
                <center>
                    <li class="selected"><a href="../index.php" style="color: white">Purchase Order</a></li>
                </center>
                <center>
                    <li><a href="../dr_page.php">Delivery Receipt</a></li>
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
                    <li><a href="#">Reports</a></li>
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

            <!-- Content -->
            <div class="col-md-9 content-wrapper p-4">
                <?php if (!empty($unique_id)) : ?>
                    <button class="details-btn btn btn-info btn-sm w-100 mb-3" style="height: 60px;" onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($unique_id[0]->supplier_id); ?>&purchase_order_id=<?= urlencode($unique_id[0]->purchase_order_id); ?>'">
                    <b>Add New Item</b>
                    </button>
                <?php endif; ?>

                <?php if (empty($unique_id)) : ?>
                    <p class="text-center text-muted font-weight-bold">No purchase records found</p>
                    <button class="details-btn btn btn-info btn-sm" onclick="window.location.href='../cnpod.php?supplier_id=<?= urlencode($unique_id[0]->supplier_id); ?>&purchase_order_id=<?= urlencode($unique_id[0]->purchase_order_id); ?>'">
                        <b>New Record</b>
                    </button>
                <?php else : ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Category</th>
                                <th class="text-center">Unit Of Issue</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Cost</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unique_id as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row->category); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->unit_of_measure); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->item_description); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->quantity); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->unit_price); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->amount); ?></td>
                                    <td class="text-center">
                                    <a href="../crud_form/edit_pod.php?id=<?= $row->id ?>&purchase_order_id=<?= $row->purchase_order_id ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="../logic/delete_pod_items.php?id=<?= $row->id ?>&purchase_order_id=<?= $row->purchase_order_id ?>" class="btn btn-danger btn-sm">Delete</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once "../shared/layout.php";?>
</body>
</html>
