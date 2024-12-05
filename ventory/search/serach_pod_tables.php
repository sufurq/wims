<?php

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchTerm !== '') {
    $display = array_filter($display, function($row) use ($searchTerm) {
        return (stripos($row->purchase_order_id, $searchTerm) !== false ||
                stripos($row->purchase_order_number, $searchTerm) !== false ||
                stripos($row->description, $searchTerm) !== false);
    });
}

?>

