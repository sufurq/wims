<?php
$host = 'localhost';
$db = 'po_system';
$user = 'root';  
$pass = '';      

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $po_number = $_POST['po_number'];
    $date_created = $_POST['date_created'];
    $procurement_no = $_POST['procurement_no'];
    $supplier = $_POST['supplier'];
    $procurement_model = $_POST['procurement_model'];
    $delivery_place = $_POST['delivery_place'];
    $delivery_date = $_POST['delivery_date'];

    $sql = "INSERT INTO purchase_orders (po_number, date_created, procurement_no, supplier, procurement_model, delivery_place, delivery_date) VALUES ('$po_number', '$date_created', '$procurement_no', '$supplier', '$procurement_model', '$delivery_place', '$delivery_date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'po_number' => $po_number,
            'date_created' => $date_created,
            'procurement_no' => $procurement_no,
            'supplier' => $supplier,
            'procurement_model' => $procurement_model,
            'delivery_place' => $delivery_place,
            'delivery_date' => $delivery_date,
            'total_amount' => '0.00' 
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>
