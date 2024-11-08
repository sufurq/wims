<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$supplier_id = $_POST['supplier_id'];
$description = $_POST['description'];
$abbreviation = $_POST['abbreviation'];
$address = $_POST['address'];

$sql = "INSERT INTO suppliers (supplier_id, description, abbreviation, address) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $supplier_id, $description, $abbreviation, $address);

if ($stmt->execute()) {
    echo "New supplier added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>


//create a form to add a new supplier

