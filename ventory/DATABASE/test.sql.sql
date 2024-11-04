CREATE DATABASE inventory_management;
USE inventory_management;

-- Create table for Bedding and Linens
CREATE TABLE bedding_and_linens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Bedding and Linens',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Carpentry
CREATE TABLE carpentry (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Carpentry',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for CHB Casting
CREATE TABLE chb_casting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'CHB Casting (LSB Warehouse)',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Construction
CREATE TABLE construction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Construction',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Electrical
CREATE TABLE electrical (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Electrical',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Greenery
CREATE TABLE greenery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Greenery',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Hygienic and Toiletries
CREATE TABLE hygienic_and_toiletries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Hygienic And Toiletries',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Masonry
CREATE TABLE masonry (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Masonry',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Office Equipment
CREATE TABLE office_equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Office Equipment',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Paints
CREATE TABLE paints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Paints',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Plumbing
CREATE TABLE plumbing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Plumbing',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Reserved Items
CREATE TABLE reserved_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Reserved Item',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Sports Apparel and Accessories
CREATE TABLE sports_apparel_and_accessories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Sports Apparel And Accessories',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Sports Awards
CREATE TABLE sports_awards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Sports Awards',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Sports Equipment
CREATE TABLE sports_equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Sports Equipment',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);

-- Create table for Tools and Equipments
CREATE TABLE tools_and_equipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    category VARCHAR(100) DEFAULT 'Tools And Equipments',
    reorder_level INT,
    reorder_quantity INT,
    remarks VARCHAR(255)
);