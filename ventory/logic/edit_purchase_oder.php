<?php
include "../util/dbhelper.php";
$db = new dbhelper();

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $amount = $_POST['amount'];

    // Correct the validation condition (closing the parentheses properly)
    if (!empty(trim($category)) && !empty(trim($item)) && !empty(trim($quantity)) && !empty(trim($unit_price)) && !empty(trim($unit_of_measure)) && !empty(trim($amount))) {
        // Call the edit_pod_items method
        $updatePod = $db->edit_pod_items($id, $category, $item, $quantity, $unit_price, $unit_of_measure, $amount);

        if ($updatePod) {
            header("Location: ../pod.php");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+UPDATED");
            exit();
        }
    } else {
        header("Location: ../?m=ALL+FIELDS+ARE+REQUIRED");
        exit();
    }
} else {
    header("Location: ../");
    exit();
}   
?>
