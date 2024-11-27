<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

$conn = $db->getConnection();

// Get all records with 'Fully Delivered' status
$sql = "SELECT * FROM delivery_receipts WHERE status = 'Fully Delivered'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fully Delivered</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>

<h2>Fully Delivered</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Delivery Receipt Number</th>
            <th>Sales Representative</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['receipt_number']); ?></td>
                <td><?= htmlspecialchars($row['sales_representative']); ?></td>
                <td><?= htmlspecialchars($row['status']); ?></td>
                <td><button onclick="window.location.href='dr_page.php?id=<?= urlencode($row['dr_id']); ?>'">View Details</button></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No fully delivered records found.</p>
<?php endif; ?>

</body>
</html>
