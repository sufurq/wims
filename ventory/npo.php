<?php
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$database = 'inventory_management';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$suppliers_query = "SELECT supplier_id, description FROM suppliers";
$suppliers_result = $conn->query($suppliers_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_id = $_POST['supplier_id'];
    $po_number = $_POST['po_number'];
    $po_date = $_POST['po_date'];
    $procurement_model = $_POST['procurement_model'];
    $procurement_number = $_POST['procurement_number'];
    $procurement_date = $_POST['procurement_date'];
    $delivery_place = $_POST['delivery_place'];
    $delivery_date = $_POST['delivery_date'];
    $terms_delivery = $_POST['terms_delivery'];

    $insert_query = "INSERT INTO purchase_orders (
        supplier_id, 
        purchase_order_number, 
        order_date, 
        mode_of_procurement, 
        procurement_number, 
        procurement_date, 
        place_of_delivery, 
        delivery_date, 
        term_of_delivery
    ) VALUES (
        '$supplier_id', 
        '$po_number', 
        '$po_date', 
        '$procurement_model', 
        '$procurement_number', 
        '$procurement_date', 
        '$delivery_place', 
        '$delivery_date', 
        '$terms_delivery'
    )";

    if ($conn->query($insert_query) === TRUE) {
        echo "New purchase order created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" conteant="width=device-width, initial-scale=1.0">
    <title>New Purchase Order</title>
        <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/npo.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h1><center><img src="img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center></h1>
            <ul>
                <center><li><a href="pod.php">Dashboard</a></li></center>
                <center><li class="selected"><a href="index.php" style="color: white;">Purchase Order</a></li></center>
                <center><li><a href="dr_page.php">Delivery Receipt</a></li></center>
                <center><li><a href="">POWE</a></li></center>
                <center><li><a href="">RIS</a></li></center>
                <center><li><a href="">Audit</a></li></center>
                <center><li><a href="./report/reports.php">Reports</a></li></center>
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
                <center><li><a href="log_out.php">Log Out</a></li></center>
            </ul>
        </aside>

    <!-- Main Section -->
    <div style="margin-left: 1%; width: 100%;" class="container">
    <section class="purchase-order">
            <div class="form-container">
                <button class="close-btn" onclick="closeForm()">&#10006;</button>
                <center><h2>New Purchase Order</h2></center>
                <form action="npo.php" method="POST" class="purchase-order-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="supplier">Supplier:</label>
                            <select id="supplier" name="supplier_id" required style="font-family: 'Roboto', serif;">
                                <option value="">Select Supplier</option>
                                <?php while ($supplier = $suppliers_result->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>">
                                        <?php echo htmlspecialchars($supplier['description']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="po-number">P.O #:</label>
                            <input type="text" id="po-number" name="po_number" placeholder="Enter P.O number" required style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="po-date">Date:</label>
                            <input type="date" id="po-date" name="po_date" required style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="procurement-model">Model of Procurement:</label>
                            <input type="text" id="procurement-model" name="procurement_model" placeholder="Enter procurement model" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="procurement-number">Procurement #:</label>
                            <input type="text" id="procurement-number" name="procurement_number" placeholder="Enter procurement number" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="procurement-date">Procurement Date:</label>
                            <input type="date" id="procurement-date" name="procurement_date" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="delivery-place">Place Of Delivery:</label>
                            <input type="text" id="delivery-place" name="delivery_place" placeholder="Enter place of delivery" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="delivery-date">Date Of Delivery:</label>
                            <input type="date" id="delivery-date" name="delivery_date" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group">
                            <label for="terms-delivery">Terms of Delivery:</label>
                            <input type="text" id="terms-delivery" name="terms_delivery" placeholder="Enter terms of delivery" style="font-family: 'Roboto', serif;">
                        </div>
                        <div class="form-group full-width">
                            <div class="form-actions">
                                <button type="submit" class="submit-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
<script>
function closeForm() {
    window.location.href = 'index.php'; 
}
</script>
</body>
</html>
