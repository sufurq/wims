<?php
require_once "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_POST["submit"])) {
    $pod_Id = trim($_POST["pod_Id"]);
    $items = trim($_POST["items"]);
    $quantity = trim($_POST["quantity"]);
    $uom = trim($_POST["uom"]);
    $serial_Id = trim($_POST["serial_Id"]);
    $date_of_exp = trim($_POST["date_of_exp"]);
    $unit_cost = trim($_POST["unit_cost"]);
    $amount = trim($_POST["amount"]);

    if (!empty($items) && !empty($quantity) && !empty($uom) && !empty($serial_Id) && !empty($date_of_exp) && !empty($unit_cost) && !empty($amount)) {

        $data = [
            "pod_Id" => $pod_Id,  
            "items" => $items,
            "quantity" => $quantity,
            "unit_cost" => $unit_cost,
            "uom" => $uom,
            "serial_Id" => $serial_Id,
            "date_of_exp" => $date_of_exp,
            "amount" => $amount
        ];

        $updatePod = $db->addrecord("deliveries", $data);

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
