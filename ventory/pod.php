<?php
$conn = new mysqli("localhost", "root", "", "inventory_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $item = $_POST['item'];
    $uom = $_POST['uom'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO pod_items (category, item_description, unit_of_measure, quantity, unit_price, amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssidd", $category, $item, $uom, $quantity, $unit_price, $amount);
    $stmt->execute();
    $stmt->close();
}

// Deleting a record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM pod_items WHERE id = $id");
    header("Location: index.php"); // Redirect back to the page after deletion
}

$result = $conn->query("SELECT * FROM pod_items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script defer src="script/script.js"></script>
</head>
<style>
        /* General Body Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Form Container */
.form-container {
    max-width: 1200px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
}

/* Form Title */
.form-container h2 {
    font-size: 24px;
    color: #2e3d56;
    text-align: left;
    margin-bottom: 20px;
}

/* Form Layout */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 20px;
    align-items: start;
}

/* Form Group */
.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
}

.form-group input,
.form-group select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #4a6fa1;
    background-color: #fff;
}

/* Full Width Fields */
.form-group.full-width {
    grid-column: 1 / 3;
}

/* Button Styles */
.form-actions {
    margin-top: 20px;
    text-align: left;
}

.form-actions button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
}

.form-actions .submit-btn {
    background-color: #4a6fa1;
    transition: background-color 0.3s ease;
}

.form-actions .submit-btn:hover {
    background-color: #2e3d56;
}

.form-actions .back-btn {
    background-color: #d9534f;
}

.form-actions .back-btn:hover {
    background-color: #c9302c;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group.full-width {
        grid-column: 1 / 2;
    }
}
/* Close Button Styles */
.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    background-color: transparent;
    border: none;
    font-size: 24px;
    color: #333;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #d9534f;
}

/* Relative position for the form-container */
.form-container {
    position: relative;
    max-width: 1200px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
}

.sub-menu a {
  text-decoration: none; /* Remove underline */
}
</style>
<style>
    .sub-menu a {
  text-decoration: none; /* Remove underline */
}
</style>
<body>
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
            <h1><center><img src="img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center></h1>
            <ul>
                <center><li><a href="#">Dashboard</a></li></center>
                <center><li class="selected">
                    <a href="index.php" style="color: white;">Purchase Order</a></li>
                </center>
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

        <!-- Purchase Order Page -->
        <section class="purchase-order">
            <center><h2>Purchase Order</h2></center>
            <a href="cnpod.php"><button class="new-record-btn" style="position:relative; right:20px; top:-60px"><b>New Detail</b></button></a>

            <!-- Search field for filtering entries -->
            <div class="search-container" style="position: relative; left:10px;">
                <i class="fa fa-search search-icon" style="position:relative; left:10px;"></i>
                <input type="text" style="position:relative; right:20px;" class="search-input" placeholder="Search" id="search-input">
            </div>

            <div class="text-center mb-3">
                <!-- Dropdown to select the number of entries to display -->
                <div class="dropdown-container" style="position:relative; left:-815px;">
                    <h4>Show&nbsp;</h4>
                    <select class="status-dropdown" style="width:100px;">
                        <option value="1">10</option>
                        <option value="2">25</option>
                        <option value="3">50</option>
                        <option value="4">100</option>
                        <option value="10" selected>10</option>
                    </select>
                    <h4>&nbsp;Entries</h4>
                </div>
            </div>

    <!-- Purchase Orders Table -->
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Unit of Issue</th>
                    <th>Description</th>
                    <th>QTY</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>
                    <th>Action(s)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['item_description'] ?></td>
                    <td><?= $row['unit_of_measure'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['unit_price'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="index.php?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

   <div class="nav-container">
                <button class="nav-btn" id="prev-btn">Previous</button>
                <div class="number-box" id="number-display">1</div>
                <button class="nav-btn" id="next-btn">Next</button>
            </div>
        </section>
    </div>

</body>
</html>
