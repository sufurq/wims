<?php 
require_once "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_POST["submit"])) {
    $receipt_number = $_POST["receipt_number"];
    $sales_representative = $_POST["sales_representative"];
    $checked_by = $_POST["checked_by"];

    if (!empty(trim($receipt_number)) && !empty(trim($sales_representative)) && !empty(trim($checked_by))) {
        $addReceipt = $db->addrecord("delivery_receipts", ["receipt_number" => $receipt_number,
         "sales_representative" => $sales_representative,  "checked_by" => $checked_by]);

         if ($addReceipt > 0) {
            header("Location: ../dr_page.php");
            exit();
         } else {
            header("Location: ../?m=NO+DATA+WAS+ADDED");
            exit();
         }
    }

}
 


?>