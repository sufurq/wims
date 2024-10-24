<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_orders_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$supplier_query = "SELECT * FROM suppliers";
$suppliers_result = $conn->query($supplier_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['supplier_id']) && !empty($_POST['supplier_id'])) {
        $supplier_id = $conn->real_escape_string($_POST['supplier_id']);
    } else {
        die("Error: Supplier is required.");
    }

    $po_number = $conn->real_escape_string($_POST['po_number']);
    $po_date = $conn->real_escape_string($_POST['po_date']);
    $procurement_model = $conn->real_escape_string($_POST['procurement_model']);
    $procurement_number = $conn->real_escape_string($_POST['procurement_number']);
    $procurement_date = $conn->real_escape_string($_POST['procurement_date']);
    $delivery_place = $conn->real_escape_string($_POST['delivery_place']);
    $delivery_date = $conn->real_escape_string($_POST['delivery_date']);
    $terms_delivery = $conn->real_escape_string($_POST['terms_delivery']);
    $total_amount = rand(1000, 50000); 
    $status = 'Pending';

    $insert_query = "INSERT INTO purchase_orders 
        (supplier_id, po_number, po_date, procurement_model, procurement_number, procurement_date, delivery_place, delivery_date, terms_delivery, total_amount, status) 
        VALUES 
        ('$supplier_id', '$po_number', '$po_date', '$procurement_model', '$procurement_number', '$procurement_date', '$delivery_place', '$delivery_date', '$terms_delivery', '$total_amount', '$status')";

    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('New record created successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Purchase Order</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
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
                <center><li><a href="#">Dashboard</a></li></center>
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

    <!-- Purchase Order Form Page -->
<section class="purchase-order">
    <div class="form-container">
        <!-- Close Button -->
        <button class="close-btn" onclick="closeForm()">&#10006;</button>
        
        <center><h2>New Purchase Order</h2></center>
        
        <form action="npo.php" method="POST" class="purchase-order-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="supplier">Supplier:</label>
                    <select id="supplier" name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        <?php while ($supplier = $suppliers_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($supplier['id']); ?>"><?php echo htmlspecialchars($supplier['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="po-number">P.O #:</label>
                    <input type="text" id="po-number" name="po_number" placeholder="Enter P.O number" required>
                </div>

                <div class="form-group">
                    <label for="po-date">Date:</label>
                    <input type="date" id="po-date" name="po_date" required>
                </div>

                <div class="form-group">
                    <label for="procurement-model">Model of Procurement:</label>
                    <input type="text" id="procurement-model" name="procurement_model" placeholder="Enter procurement model">
                </div>

                <div class="form-group">
                    <label for="procurement-number">Procurement #:</label>
                    <input type="text" id="procurement-number" name="procurement_number" placeholder="Enter procurement number">
                </div>

                <div class="form-group">
                    <label for="procurement-date">Procurement Date:</label>
                    <input type="date" id="procurement-date" name="procurement_date">
                </div>

                <div class="form-group">
                    <label for="delivery-place">Place Of Delivery:</label>
                    <input type="text" id="delivery-place" name="delivery_place" placeholder="Enter place of delivery">
                </div>

                <div class="form-group">
                    <label for="delivery-date">Date Of Delivery:</label>
                    <input type="date" id="delivery-date" name="delivery_date">
                </div>

                <div class="form-group">
                    <label for="terms-delivery">Terms of Delivery:</label>
                    <input type="text" id="terms-delivery" name="terms_delivery" placeholder="Enter terms of delivery">
                </div>

                <!-- Full Width Button Group -->
                <div class="form-group full-width">
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function closeForm() {
    window.location.href = 'index.php'; 
}
</script>
</body>
</html>
