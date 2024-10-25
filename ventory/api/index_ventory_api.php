<?php 
    require_once "../util/dbhelper.php";
    $db = new DbHelper();
    header("content-Type: appilication/json");
    $data = $db->getAllRecords('pod_items');
    echo json_encode($data);

    
?>