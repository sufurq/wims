<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receipt_number = isset($_POST['receipt_number']) ? $_POST['receipt_number'] : null;
$sales_representative = isset($_POST['sales_representative']) ? $_POST['sales_representative'] : null;
$checked_by = isset($_POST['checked_by']) ? $_POST['checked_by'] : null;

if ($receipt_number && $sales_representative && $checked_by) {
    $stmt = $conn->prepare("INSERT INTO delivery_receipts (receipt_number, sales_representative, checked_by) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $receipt_number, $sales_representative, $checked_by);

    if ($stmt->execute()) {
        echo "Delivery receipt submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Receipt Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
        }
        h1 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-actions {
            margin-top: 20px;
        }
        .submit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>New Delivery Receipt</h1>
    <form action="dr_receive.php" method="post">
        <label for="receipt_number">Receipt Number:</label>
        <input type="text" id="receipt_number" name="receipt_number" required>

        <label for="sales_representative">Sales Representative:</label>
        <input type="text" id="sales_representative" name="sales_representative" required>

        <label for="checked_by">Checked By:</label>
        <input type="text" id="checked_by" name="checked_by" required>

        <div class="form-group full-width">
            <div class="form-actions">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </div>
    </form>
    
    
    

</body>
</html>

