<?php

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchTerm !== '') {
    $display = array_filter($display, function($row) use ($searchTerm) {
        return (stripos($row->purchase_order_id, $searchTerm) !== false ||
                stripos($row->purchase_orders_numbers, $searchTerm) !== false ||
                stripos($row->suppliers_des, $searchTerm) !== false ||
                stripos($row->purchase_orders_pn, $searchTerm) !== false ||
                stripos ($row->purchase_orders_d_date, $searchTerm) !== false); 
    });
}

?>

