<?php 
require_once "../util/dbhelper.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID is not defined.");
}

$db = new DbHelper();
$unique_id = $db->Purchase_order($id);

// Debugging: Check if $unique_id is empty
if (empty($unique_id)) {
    die("No data found for the provided ID.");
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

    <div class="container">
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1><center><img src="../img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center></h1>
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
        <a href="../cnpod.php?id=<?= urlencode($id); ?>"><button class="new-record-btn"><b>New Record</b></button></a>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
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
                    <?php foreach ($unique_id as $row) : ?>   
                        <tr>
                    

                            <td><?= htmlspecialchars($row->purchase_order_number); ?></td>
                            <td><?= htmlspecialchars($row->order_date); ?></td>
                            <td><?= htmlspecialchars($row->procurement_number); ?></td>
                            <td><?= htmlspecialchars($row->description); ?></td>
                            <td><?= "Total Amount Placeholder"; ?></td>
                            <td><?= htmlspecialchars($row->status); ?></td>
                            <td>Action</td>
                            <td>
    <a href="../cnpod.php?id=<?= urlencode($row->supplier_id); ?>">
        <button class="new-record-btn"><b>New Record</b></button>
    </a>
</td>
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
    </div>
</body>
</html>
