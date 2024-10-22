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
    $category = strtolower(str_replace(' ', '_', $_POST['category']));

    try {
        $sql = "CREATE TABLE IF NOT EXISTS $category (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    description VARCHAR(255),
                    category VARCHAR(100) DEFAULT '$category',
                    reorder_level INT,
                    reorder_quantity INT,
                    remarks VARCHAR(255)
                )";
        $pdo->exec($sql);

        echo "Category <strong>" . ucfirst(str_replace('_', ' ', $category)) . "</strong> created successfully!";
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
    <title>Add New Category</title>
</head>
<body>
    <h2>Add New Category</h2>
    <form action="add_category.php" method="POST">
        <label for="category">New Category Name:</label>
        <input type="text" id="category" name="category" required><br><br>

        <input type="submit" value="Add Category">
    </form>
</body>
</html>
