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


        
        if (!empty(trim($category)) && !empty(trim($item)) && !empty(trim($quantity)) && !empty(trim($unit_price) && !empty(trim($unit_of_measure)) && !empty(trim($amount)))) {
            $updatePod = $db->updateRecord("pod_items", ["id" => $id, "category" => $category, "item_description" => $item, "quantity" => $quantity, "unit_price" => $unit_price, "unit_of_measure" => $unit_of_measure, "amount" => $amount]);
            if ($updatePod > 0) {
                header("Location: ../pod.php");
                exit();
            } else {
                header("Location: ../?m=NO+DATA+WAS+UPDATED");
                exit();
            }
        }
    } else {
        header("Location: ../");
        exit();
    }

?>
