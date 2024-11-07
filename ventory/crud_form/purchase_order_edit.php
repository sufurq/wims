<?php
$conn = new mysqli("localhost", "root", "", "inventory_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categories = [];
$result = $conn->query("SELECT DISTINCT category FROM (
    SELECT category FROM bedding_and_linens UNION 
    SELECT category FROM carpentry UNION 
    SELECT category FROM chb_casting UNION 
    SELECT category FROM construction UNION 
    SELECT category FROM electrical UNION 
    SELECT category FROM greenery UNION 
    SELECT category FROM hygienic_and_toiletries UNION 
    SELECT category FROM masonry UNION 
    SELECT category FROM office_equipment UNION 
    SELECT category FROM paints UNION 
    SELECT category FROM plumbing UNION 
    SELECT category FROM reserved_items UNION 
    SELECT category FROM sports_apparel_and_accessories UNION 
    SELECT category FROM sports_awards UNION 
    SELECT category FROM sports_equipment UNION 
    SELECT category FROM tools_and_equipments
) AS all_categories");

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}


$supplier_id = isset($_GET['supplier_id']) ? $_GET['supplier_id'] : null;
$purchase_order_id = isset($_GET['purchase_order_id']) ? $_GET['purchase_order_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create POD</title>

    <link rel="stylesheet" href="../css/style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            position: relative;
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

        /* Sub Menu Links */
        .sub-menu a {
            text-decoration: none; /* Remove underline */
        }
    </style>

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
                <center><li><a href="dashboard.php">Dashboard</a></li></center>
                <center><li class="selected"><a href="index.php">Purchase Order</a></li></center>
                <center><li><a href="delivery_receipt.php">Delivery Receipt</a></li></center>
                <center><li><a href="powe.php">POWE</a></li></center>
                <center><li><a href="ris.php">RIS</a></li></center>
                <center><li><a href="audit.php">Audit</a></li></center>
                <center><li><a href="reports.php">Reports</a></li></center>
                <hr>
                <center><li><a href="master_page.php">Master Pages</a></li></center>
                <hr>
                <center><li><a href="log_out.php">Log Out</a></li></center>
            </ul>
        </aside>

    <!-- Purchase Order Form Page -->
    <section class="purchase-order">
        <div class="form-container">
            <!-- Close Button -->
            <button class="close-btn" onclick="closeForm()">&#10006;</button>

            <h2>Create New Purchase Order Details</h2>

            <form action="pod.php" method="post">
            <input type="hidden" name="supplier_Id" id="supplier_Id" value="<?= htmlspecialchars($supplier_id); ?>">
                    <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?= htmlspecialchars($purchase_order_id); ?>">


                <div class="form-grid">
                    <div class="form-group">
                        <label for="category">Item Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category ?>"><?= $category ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="item">Item:</label>
                        <select id="item" name="item" required>
                            <option value="">Select Item</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="uom">Unit of Measure:</label>
                        <input type="text" id="uom" name="uom" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required>
                    </div>
                    

                    <div class="form-group">
                        <label for="unit_price">Unit Price:</label>
                        <input type="text" id="unit_price" name="unit_price" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="text" id="amount" name="amount" readonly>
                    </div>

                    <div class="form-actions full-width">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <script>
        function closeForm() {
            window.location.href = './pod.php'; 
        }

        $('#category').change(function() {
            var category = $(this).val();
            if (category) {
                $.ajax({
                    type: "POST",
                    url: "./fetch_items.php",
                    data: {category: category},
                    success: function(response) {
                        $('#item').html(response);
                    }
                });
            } else {
                $('#item').html('<option value="">Select Item</option>');
            }
        });

        $('#quantity, #unit_price').on('input', function() {
            var quantity = parseFloat($('#quantity').val()) || 0;
            var unitPrice = parseFloat($('#unit_price').val()) || 0;
            var amount = quantity * unitPrice;
            $('#amount').val(amount.toFixed(2));
        });
    </script>
</body>
</html>
