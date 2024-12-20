<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("ID NOT SET");
}
require_once "./util/dbhelper.php";
$db = new DbHelper();
$display_data = $db->dr_receive($id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Receipt Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/dr.css">
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

        <!-- Purchase Order Page -->
        <section class="purchase-order">
            <center>
                <h2>New Delivery Receipt</h2>
            </center>

    <form action="./logic/receipt_process.php" method="post">
    <input type="hidden" name="purchase_order_id" value="<?php echo $id; ?>">
        <label for="receipt_number">Receipt Number:</label>
        <input type="text" id="receipt_number" name="receipt_number" required>

        <label for="sales_representative">Sales Representative:</label>
        <input type="text" id="sales_representative" name="sales_representative" required>

        <label for="checked_by">Checked By:</label>
        <input type="text" id="checked_by" name="checked_by" required>

        <div class="form-group full-width">
            <div class="form-actions">
                <button type="submit" name="submit" class="submit-btn">Submit</button>
            </div>
        </div>
    </form>
    <?php require_once "./shared/layout.php" ?>
</body>
</html>