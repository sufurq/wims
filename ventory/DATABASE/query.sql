SELECT 
    purchase_orders.purchase_order_id,
    purchase_orders.purchase_order_number,
    purchase_orders.order_date,
    purchase_orders.mode_of_procurement,
    purchase_orders.procurement_number,
    purchase_orders.procurement_date,
    purchase_orders.place_of_delivery,
    purchase_orders.delivery_date,
    purchase_orders.term_of_delivery,
    purchase_orders.status,
    suppliers.description
FROM 
    purchase_orders
LEFT JOIN 
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id;
