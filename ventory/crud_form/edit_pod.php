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


include "../util/dbhelper.php";
$db = new DbHelper();
$pod = $db->getRecord("pod_items", ["id" => $_GET["id"]]);
include "../shared/navbar_admin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="../assets/css/edit_style.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <section class="purchase-order">
        <div class="form-container">
            <!-- Close Button -->
            <button class="close-btn" onclick="closeForm()">&#10006;</button>

            <h2>Edit Purchase Order Details</h2>
            <form action="../logic/edit.php" method="post">
                <div class="form-grid">
                    <input type="hidden" name="id" value="<?php echo $pod["id"] ?>">

                    <div class="form-group">
                        <label for="category">Item Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
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
                        <label for="unit_of_measure">Unit of Issue</label>
                        <input type="text" id="unit_of_measure" name="unit_of_measure" value="<?php echo $pod["unit_of_measure"] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" id="quantity" name="quantity" value="<?php echo $pod["quantity"] ?>" oninput="calculateAmount()" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_price">Unit Cost</label>
                        <input type="text" id="unit_price" name="unit_price" value="<?php echo $pod["unit_price"] ?>" oninput="calculateAmount()" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>

                        <input type="text" id="amount" name="amount" value="<?php echo $pod["amount"] ?>" required>
                    </div>
                    <div class="form-actions full-width">
                        <button type="submit" name="submit" class="submit-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        function closeForm() {
            window.location.href = "./pod.php"; 
        }

        $('#category').change(function() {
            var category = $(this).val();
            if (category) {
                $.ajax({
                    type: "POST",
                    url: "../fetch_items.php",
                    data: {category: category},
                    success: function(response) {
                        $('#item').html(response);
                    }
                });
            } else {
                $('#item').html('<option value="">Select Item</option>');
            }
        });
    </script>

    <script src="../assets/js/calculate_amount.js"></script>
</body>

</html>