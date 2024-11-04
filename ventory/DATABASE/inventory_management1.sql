-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 08:18 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedding_and_linens`
--

CREATE TABLE `bedding_and_linens` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Bedding and Linens',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bedding_and_linens`
--

INSERT INTO `bedding_and_linens` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Comforter', 'Bedding and Linens', 10, 20, 'Good condition'),
(2, 'Pillow', 'Bedding and Linens', 50, 100, 'Needs restocking'),
(3, 'Bed sheet', 'Bedding and Linens', 30, 60, 'New delivery expected');

-- --------------------------------------------------------

--
-- Table structure for table `carpentry`
--

CREATE TABLE `carpentry` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Carpentry',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carpentry`
--

INSERT INTO `carpentry` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Hammer', 'Carpentry', 15, 30, 'Essential tool'),
(2, 'Nails', 'Carpentry', 100, 200, 'Stock sufficient for 2 weeks'),
(3, 'Saw', 'Carpentry', 10, 20, 'Sharp blades needed');

-- --------------------------------------------------------

--
-- Table structure for table `chb_casting`
--

CREATE TABLE `chb_casting` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'CHB Casting (LSB Warehouse)',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chb_casting`
--

INSERT INTO `chb_casting` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Cement Bags', 'CHB Casting (LSB Warehouse)', 50, 100, 'High demand in rainy season'),
(2, 'CHB Blocks', 'CHB Casting (LSB Warehouse)', 200, 500, 'Needs restocking soon'),
(3, 'Gravel', 'CHB Casting (LSB Warehouse)', 75, 150, 'Sufficient for upcoming projects');

-- --------------------------------------------------------

--
-- Table structure for table `construction`
--

CREATE TABLE `construction` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Construction',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `construction`
--

INSERT INTO `construction` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Wood Planks', 'Construction', 50, 100, 'Pending shipment'),
(2, 'Concrete Mix', 'Construction', 100, 200, 'Stock sufficient for a month'),
(3, 'Steel Rods', 'Construction', 40, 80, 'Low supply warning');

-- --------------------------------------------------------

--
-- Table structure for table `electrical`
--

CREATE TABLE `electrical` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Electrical',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `electrical`
--

INSERT INTO `electrical` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Copper Wires', 'Electrical', 30, 60, 'Sufficient stock'),
(2, 'Light Bulbs', 'Electrical', 100, 200, 'High usage, needs more'),
(3, 'Electrical Tape', 'Electrical', 20, 40, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `greenery`
--

CREATE TABLE `greenery` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Greenery',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `greenery`
--

INSERT INTO `greenery` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Flower Pots', 'Greenery', 30, 60, 'Sufficient stock'),
(2, 'Grass Seeds', 'Greenery', 20, 40, 'New stock arrived'),
(3, 'Gardening Tools', 'Greenery', 10, 20, 'Restock after upcoming projects');

-- --------------------------------------------------------

--
-- Table structure for table `hygienic_and_toiletries`
--

CREATE TABLE `hygienic_and_toiletries` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Hygienic And Toiletries',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hygienic_and_toiletries`
--

INSERT INTO `hygienic_and_toiletries` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Toilet Paper', 'Hygienic And Toiletries', 50, 100, 'Restocking soon'),
(2, 'Hand Soap', 'Hygienic And Toiletries', 30, 60, 'Low stock'),
(3, 'Disinfectant', 'Hygienic And Toiletries', 40, 80, 'Stock sufficient for 2 weeks');

-- --------------------------------------------------------

--
-- Table structure for table `masonry`
--

CREATE TABLE `masonry` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Masonry',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masonry`
--

INSERT INTO `masonry` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Bricks', 'Masonry', 200, 500, 'New order placed'),
(2, 'Cement Blocks', 'Masonry', 100, 200, 'Stock at normal levels'),
(3, 'Mortar Mix', 'Masonry', 50, 100, 'In good supply');

-- --------------------------------------------------------

--
-- Table structure for table `office_equipment`
--

CREATE TABLE `office_equipment` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Office Equipment',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `office_equipment`
--

INSERT INTO `office_equipment` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Printers', 'Office Equipment', 5, 10, 'New models available'),
(2, 'Computers', 'Office Equipment', 10, 20, 'Maintenance required'),
(3, 'Office Chairs', 'Office Equipment', 20, 40, 'Sufficient stock');

-- --------------------------------------------------------

--
-- Table structure for table `paints`
--

CREATE TABLE `paints` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Paints',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paints`
--

INSERT INTO `paints` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'White Paint', 'Paints', 30, 60, 'New delivery expected'),
(2, 'Blue Paint', 'Paints', 20, 40, 'Stock at sufficient levels'),
(3, 'Red Paint', 'Paints', 10, 20, 'Low stock');

-- --------------------------------------------------------

--
-- Table structure for table `plumbing`
--

CREATE TABLE `plumbing` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Plumbing',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plumbing`
--

INSERT INTO `plumbing` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'PVC Pipes', 'Plumbing', 50, 100, 'Sufficient for upcoming work'),
(2, 'Faucets', 'Plumbing', 20, 40, 'Restock soon'),
(3, 'Water Tanks', 'Plumbing', 5, 10, 'Needs more stock');

-- --------------------------------------------------------

--
-- Table structure for table `pod_items`
--

CREATE TABLE `pod_items` (
  `id` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL,
  `unit_of_measure` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pod_items`
--

INSERT INTO `pod_items` (`id`, `category`, `item_description`, `unit_of_measure`, `quantity`, `unit_price`, `amount`) VALUES
(1, 'Tools And Equipments', 'Wrench', 'sh', 11112211, '1111.00', '99999999.99'),
(2, 'Carpentry', 'Hammer', 'sh', 11112211, '1111.00', '99999999.99');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_items`
--

CREATE TABLE `reserved_items` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Reserved Item',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserved_items`
--

INSERT INTO `reserved_items` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Projector', 'Reserved Item', 2, 5, 'Reserved for upcoming event'),
(2, 'Sound System', 'Reserved Item', 1, 2, 'Reserved for conference'),
(3, 'Whiteboard', 'Reserved Item', 3, 5, 'Reserved for meetings');

-- --------------------------------------------------------

--
-- Table structure for table `sports_apparel_and_accessories`
--

CREATE TABLE `sports_apparel_and_accessories` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Sports Apparel And Accessories',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sports_apparel_and_accessories`
--

INSERT INTO `sports_apparel_and_accessories` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Jerseys', 'Sports Apparel And Accessories', 50, 100, 'In demand'),
(2, 'Sneakers', 'Sports Apparel And Accessories', 30, 60, 'New stock available'),
(3, 'Hats', 'Sports Apparel And Accessories', 20, 40, 'Sufficient for now');

-- --------------------------------------------------------

--
-- Table structure for table `sports_awards`
--

CREATE TABLE `sports_awards` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Sports Awards',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sports_awards`
--

INSERT INTO `sports_awards` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Medals', 'Sports Awards', 20, 50, 'Plenty in stock'),
(2, 'Trophies', 'Sports Awards', 10, 20, 'Stock running low'),
(3, 'Certificates', 'Sports Awards', 100, 200, 'Ready for distribution');

-- --------------------------------------------------------

--
-- Table structure for table `sports_equipment`
--

CREATE TABLE `sports_equipment` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Sports Equipment',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sports_equipment`
--

INSERT INTO `sports_equipment` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Basketballs', 'Sports Equipment', 15, 30, 'New stock coming soon'),
(2, 'Tennis Rackets', 'Sports Equipment', 10, 20, 'Restock required'),
(3, 'Footballs', 'Sports Equipment', 20, 40, 'Low on stock');

-- --------------------------------------------------------

--
-- Table structure for table `tools_and_equipments`
--

CREATE TABLE `tools_and_equipments` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Tools And Equipments',
  `reorder_level` int(11) DEFAULT NULL,
  `reorder_quantity` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tools_and_equipments`
--

INSERT INTO `tools_and_equipments` (`id`, `description`, `category`, `reorder_level`, `reorder_quantity`, `remarks`) VALUES
(1, 'Hammer', 'Tools And Equipments', 10, 50, 'Standard claw hammer'),
(2, 'Drill', 'Tools And Equipments', 5, 10, 'In good condition'),
(3, 'Wrench', 'Tools And Equipments', 15, 30, 'Sufficient supply'),
(4, 'Screwdriver', 'Tools And Equipments', 20, 40, 'Restocking soon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bedding_and_linens`
--
ALTER TABLE `bedding_and_linens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carpentry`
--
ALTER TABLE `carpentry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chb_casting`
--
ALTER TABLE `chb_casting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `construction`
--
ALTER TABLE `construction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electrical`
--
ALTER TABLE `electrical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `greenery`
--
ALTER TABLE `greenery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hygienic_and_toiletries`
--
ALTER TABLE `hygienic_and_toiletries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masonry`
--
ALTER TABLE `masonry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_equipment`
--
ALTER TABLE `office_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paints`
--
ALTER TABLE `paints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plumbing`
--
ALTER TABLE `plumbing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pod_items`
--
ALTER TABLE `pod_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserved_items`
--
ALTER TABLE `reserved_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_apparel_and_accessories`
--
ALTER TABLE `sports_apparel_and_accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_awards`
--
ALTER TABLE `sports_awards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_equipment`
--
ALTER TABLE `sports_equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tools_and_equipments`
--
ALTER TABLE `tools_and_equipments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bedding_and_linens`
--
ALTER TABLE `bedding_and_linens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carpentry`
--
ALTER TABLE `carpentry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chb_casting`
--
ALTER TABLE `chb_casting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `construction`
--
ALTER TABLE `construction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `electrical`
--
ALTER TABLE `electrical`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `greenery`
--
ALTER TABLE `greenery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hygienic_and_toiletries`
--
ALTER TABLE `hygienic_and_toiletries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `masonry`
--
ALTER TABLE `masonry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `office_equipment`
--
ALTER TABLE `office_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paints`
--
ALTER TABLE `paints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plumbing`
--
ALTER TABLE `plumbing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pod_items`
--
ALTER TABLE `pod_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reserved_items`
--
ALTER TABLE `reserved_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sports_apparel_and_accessories`
--
ALTER TABLE `sports_apparel_and_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sports_awards`
--
ALTER TABLE `sports_awards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sports_equipment`
--
ALTER TABLE `sports_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tools_and_equipments`
--
ALTER TABLE `tools_and_equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
