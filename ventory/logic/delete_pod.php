<?php
include "../util/dbhelper.php";
$db = new DbHelper();

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = $_GET["id"];
    $delete_pod = $db->deleteRecord("pod_items", ["id" => $id]);
    if ($delete_pod >0) {
        header ("Location: ../pod.php");
        exit();

    }

} else {
    header ("Location: ../?m=POD+NOT+DELETED");
    exit();
}

?>