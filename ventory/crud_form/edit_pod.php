<?php
include "../util/dbhelper.php";
$db = new DbHelper();
$pod = $db->getRecord("pod_items", ["id" => $_GET["id"]]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>
    <div>
        <form action="../logic/edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $pod["id"] ?>">

            <label for="options">Choose an option:</label>
            <select id="category" name="category" value="<?php echo $pod["category"]?>" required>
                <option value="bedding_and_linens">bedding_and_linens</option>
                <option value="carpentry">carpentry</option>
                <option value="chb_casting">chb_casting</option>
                <option value="constructio">construction</option>
            </select>

            <label for="item_description">Item Description</label>
            <input type="text" id="item_description" name="item_description" value="<?php echo $pod["item_description"] ?>" required>

            <label for="unit_of_measure">Unit of Issue</label>
            <input type="text" id="unit_of_measure" name="unit_of_measure" value="<?php echo $pod["unit_of_measure"] ?>" required>

            <label for="quantity">Quantity</label>
            <input type="text" id="quantity" name="quantity" value="<?php echo $pod["quantity"] ?>" oninput="calculateAmount()" required>

            <label for="unit_price">Unit Cost</label>
            <input type="text" id="unit_price" name="unit_price" value="<?php echo $pod["unit_price"] ?>" oninput="calculateAmount()" required>

            <label for="amount">Amount</label>

            <input type="text" id="amount" name="amount" value="<?php echo $pod["amount"] ?>" required>


            <input type="submit" value="Edit Pod" name="submit">
        </form>
    </div>
    <script src="../assets/js/calculate_amount.js"></script>
</body>

</html>

