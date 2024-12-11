<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();
$purchaseOrders = $db->getAllRecords("purchase_orders");
$display = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["purchase_order_id"])) {
    $id = filter_input(INPUT_POST, "purchase_order_id", FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $display = $db->report($id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/reports.css">

</head>

<body>

    <header>
        <div class="logo-title">
            <img src="img/coclogo.png" width="300" alt="Company Logo">
        </div>
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
                <li><a href="pod.php">Dashboard</a></li>
                <li class="selected"><a href="index.php" style="color: white;">Purchase Order</a></li>
                <li><a href="dr_page.php">Delivery Receipt</a></li>
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

        <section class="purchase-order">
            <h1 style="text-align: center; background-color: powderblue;">LSB Purchase Order Status Report</h1>

            <form method="POST" style="text-align: center; margin: 20px;">
                <label for="purchase_order_id">Select Purchase Order:</label>
                <select name="purchase_order_id" id="purchase_order_id" required>
                    <option value="" disabled selected>-- Select PO # --</option>
                    <?php if (!empty($purchaseOrders)) : ?>
                        <?php foreach ($purchaseOrders as $order) : ?>
                            <option value="<?= htmlspecialchars($order['purchase_order_id']); ?>">
                                <?= htmlspecialchars($order['purchase_order_id']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="" disabled>No Purchase Orders Found</option>
                    <?php endif; ?>
                </select>
                <button type="submit">Submit</button>
            </form>

            <?php if (!empty($display)) : ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">PO #</th>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th colspan="2">P.O. Total Cost</th>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th rowspan="2">Item Code</th>
                                <th rowspan="2">Description</th>
                                <th colspan="3" class="sub-header">Purchased Order</th>
                                <th colspan="3" class="sub-header-green">Delivery Receipt</th>
                                <th rowspan="2">Balance</th>
                                <th rowspan="2">Remarks</th>
                            </tr>
                            <tr>
                                <th class="sub-header">Unit of Issue</th>
                                <th class="sub-header">Qty</th>
                                <th class="sub-header">Amount</th>
                                <th class="sub-header-green">Unit of Issue</th>
                                <th class="sub-header-green">Qty</th>
                                <th class="sub-header-green">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($display as $row) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row->id); ?></td>
                                    <td><?= htmlspecialchars($row->description); ?></td>
                                    <td><?= htmlspecialchars($row->unit_of_measure); ?></td>
                                    <td><?= htmlspecialchars($row->quantity); ?></td>
                                    <td><?= htmlspecialchars($row->amount); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST") : ?>
                <p style="text-align: center; color: red;">No data found for the selected Purchase Order.</p>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>