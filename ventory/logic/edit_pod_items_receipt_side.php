<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $item_description = trim($_POST["item_description"]);
    $quantity = $_POST["quantity"];
    $unit_of_measure = trim($_POST["unit_of_measure"]);
    $serial_Id = trim($_POST["serial_Id"]);
    $date_expiry = $_POST["date_expiry"];
    $unit_price = $_POST["unit_price"];
    $amount = $_POST["amount"];

    if (!empty($item_description) && !empty($quantity) && !empty($unit_price) && !empty($unit_of_measure) && !empty($amount) && !empty($serial_Id) && !empty($date_expiry)) {
        $updatePod = $db->updateRecord("pod_items", [
            "item_description" => $item_description,
            "quantity" => $quantity,
            "unit_price" => $unit_price,
            "unit_of_measure" => $unit_of_measure,
            "serial_Id" => $serial_Id,
            "date_expiry" => $date_expiry,
        ], "id = $id");

        if ($updatePod > 0) {
            header("Location: ../dr_receive.php");
            exit();
        } else {
            header("Location: ../?m=NO+DATA+WAS+UPDATED");
            exit();
        }
    } else {
        header("Location: ../?m=PLEASE+FILL+ALL+FIELDS");
        exit();
    }
}
?>
