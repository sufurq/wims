<?php
$host = 'localhost';
$dbname = 'inventory_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $category = $_POST['category'];
    $reorder_level = $_POST['reorder_level'];
    $reorder_quantity = $_POST['reorder_quantity'];
    $remarks = $_POST['remarks'];

    try {
        $sql = "INSERT INTO $category (description, reorder_level, reorder_quantity, remarks) 
                VALUES (:description, :reorder_level, :reorder_quantity, :remarks)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':reorder_level', $reorder_level);
        $stmt->bindParam(':reorder_quantity', $reorder_quantity);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->execute();

        echo "Item added successfully to the <strong>" . ucfirst(str_replace('_', ' ', $category)) . "</strong> category!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
</head>
<style>
        /* General Body Styles */
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f9;
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
    <h2>Add New Item</h2>
    <form action="add_item.php" method="POST">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br><br>

        <label for="category">Select Category:</label>
        <select name="category" id="category" required>
            <?php
            $query = $pdo->query("SHOW TABLES");
            while ($row = $query->fetch(PDO::FETCH_NUM)) {
                echo "<option value='" . $row[0] . "'>" . ucfirst(str_replace('_', ' ', $row[0])) . "</option>";
            }
            ?>
        </select><br><br>

        <label for="reorder_level">Reorder Level:</label>
        <input type="number" id="reorder_level" name="reorder_level" required><br><br>

        <label for="reorder_quantity">Reorder Quantity:</label>
        <input type="number" id="reorder_quantity" name="reorder_quantity" required><br><br>

        <label for="remarks">Remarks:</label>
        <input type="text" id="remarks" name="remarks"><br><br>

        <input type="submit" value="Add Item">
    </form>
</body>
</html>
