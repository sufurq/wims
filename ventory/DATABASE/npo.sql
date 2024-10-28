CREATE TABLE suppliers (
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    abbreviation VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE purchase_orders (
    purchase_order_id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT NOT NULL,
    purchase_order_number VARCHAR(50) NOT NULL,
    order_date DATE NOT NULL,
    mode_of_procurement VARCHAR(100) NOT NULL,
    procurement_number VARCHAR(50) NOT NULL,
    procurement_date DATE NOT NULL,
    place_of_delivery VARCHAR(255) NOT NULL,
    delivery_date DATE NOT NULL,
    term_of_delivery VARCHAR(100),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
);
