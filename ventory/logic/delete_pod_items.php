<?php
require_once "../util/dbhelper.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $db = new DbHelper();
    $result = $db->deletePod_Items($id); 
    header("Location: ../pod.php?message=" . urlencode($result));
    exit();
} else {
    header("Location: ./index.php?message=" . urlencode("Invalid ID provided for deletion."));
    exit();
}
?>

