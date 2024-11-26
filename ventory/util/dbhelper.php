<?php

class DbHelper
{
    private $hostname = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $database = "inventory_management";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function getAllRecords($table)
    {
        $rows = [];
        $sql = "SELECT * FROM `$table`";
        $query = $this->conn->query($sql);
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = [];
        for ($i = 0; $i < count($keys); $i++) {
            $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
        }
        $cond = implode(" AND ", $condition);
        $sql = "SELECT * FROM `$table` WHERE $cond";
        $query = $this->conn->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    public function deleteRecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = [];
        for ($i = 0; $i < count($keys); $i++) {
            $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
        }
        $cond = implode(" AND ", $condition);
        $sql = "DELETE FROM `$table` WHERE $cond";
        $this->conn->query($sql);

        return $this->conn->affected_rows;
    }

    public function addrecord($table, $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $key = implode("`, `", $keys);
        $value = implode("', '", $values);
        $sql = "INSERT INTO `$table` (`$key`) VALUES ('$value')";
        $this->conn->query($sql);
        return $this->conn->affected_rows;
    }
//Update single
public function updateRecord($table, $args)
{
    $keys = array_keys($args);
    $values = array_values($args);
    $condition = [];
    for ($i = 1; $i < count($keys); $i++) {
        $condition[] = "`" . $keys[$i] . "` = '" . $values[$i] . "'";
    }
    $sets = implode(", ", $condition);
    $sql = "UPDATE `$table` SET $sets WHERE `$keys[0]` = '$values[0]'";
    $this->conn->query($sql);
    return $this->conn->affected_rows;
}

    
//update more data 

public function updateRecords($table, $data, $conditions) {
    $set = [];
    foreach ($data as $column => $value) {
        $set[] = "$column = ?";
    }
    $set = implode(", ", $set);
    $query = "UPDATE $table SET $set WHERE $conditions";
    
    // Prepare and execute the query
    $stmt = $this->conn->prepare($query);
    $params = array_values($data);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    
    return $stmt->execute();
}

    //pagenion

    public function fetchRecords_limit($table, $start = 0, $limit = 1, $search = '')
    {

        $sql = "SELECT * FROM $table WHERE category LIKE ? OR item_description LIKE ? LIMIT ?, ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $searchParam = "%$search%";
        $stmt->bind_param("ssii", $searchParam, $searchParam, $start, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) {
            die("Get result failed: " . $stmt->error);
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();

        return $rows;
    }


    public function fetchTotalRecords($table, $search = '')
    {

        $sql = "SELECT COUNT(*) as count FROM $table WHERE category LIKE ? OR item_description LIKE ?";


        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $searchParam = "%$search%";
        $stmt->bind_param("ss", $searchParam, $searchParam);


        $stmt->execute();


        $result = $stmt->get_result();
        if (!$result) {
            die("Get result failed: " . $stmt->error);
        }


        $row = $result->fetch_assoc();


        $stmt->close();

        return $row['count'];
    }

  
// view_details_purchase_order


public function view_details_purchase_order($id)
{
    $sql = "
        SELECT 
            pod_items.category,
            pod_items.item_description,
            pod_items.unit_of_measure,
            pod_items.quantity,
            pod_items.unit_price,
            pod_items.amount,
            suppliers.supplier_id
        
        FROM 
            pod_items
        JOIN
            suppliers ON pod_items.supplier_id = suppliers.supplier_id
        WHERE
        pod_items.supplier_id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }
    
    // Bind the parameter (it should be an integer based on your earlier context)
    $stmt->bind_param("i", $id); // Corrected the parameter type to "i" for integer

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }
    
    $stmt->close();

    return $p_order; 
}




//Display value


public function display_value_all_purchase()
{
    $sql = "SELECT 
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
    suppliers.description,
    suppliers.supplier_id,
    COALESCE(SUM(pod_items.amount), 0) AS Total_Amount
FROM 
    purchase_orders
LEFT JOIN 
    pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
LEFT JOIN
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
GROUP BY 
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
    suppliers.description,
    suppliers.supplier_id;

    ";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die('Get result error: ' . $stmt->error);
    }

    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    $stmt->close();

    return $p_order; 
}

//Deletion for purchase_order

public function deleteRecordFromPOders($id) {
    $sql = "DELETE FROM purchase_orders WHERE purchase_order_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        return "Record with supplier ID $id successfully deleted.";
    } else {
        $stmt->close();
        return "Error deleting record with supplier ID $id: " . $this->conn->error;
    }

    
}

// Update Purchase_order

public function Edit_purchase_order($purchase_order_id, $purchase_order_number, $order_date, $mode_of_procurement, $procurement_number, $procurement_date, $place_of_delivery, $delivery_date, $term_of_delivery) {
  
    $sql = "UPDATE purchase_orders SET purchase_order_number = ?, order_date = ?, mode_of_procurement = ?, procurement_number = ?, procurement_date = ?, place_of_delivery = ?, delivery_date = ?, term_of_delivery = ? WHERE purchase_order_id = ?";
    $stmt = $this->conn->prepare($sql);

    // Adjust the bind_param types if necessary based on your database schema
    $stmt->bind_param("ssssssssi", $purchase_order_number, $order_date, $mode_of_procurement, $procurement_number, $procurement_date, $place_of_delivery, $delivery_date, $term_of_delivery, $purchase_order_id);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

//Delete Record POD Items.

public function deletePod_Items($id) {
    $sql = " DELETE FROM pod_items WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt-> bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        return "Return with supplier ID $id: successfully deleted";
    } else {
        $stmt->close();
        return "Error deleting record with pod_items ID $id: ". $this->conn->error;
    }
    
}
// Update Pod_items_Dashboard

public function edit_pod_items($id, $category, $item, $quantity, $unit_price, $unit_of_measure, $amount) {
    $sql = "UPDATE pod_items SET category = ?, item_description = ?, quantity = ?, unit_price = ?, unit_of_measure = ?, amount = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("sssdidsi", $category, $item, $quantity, $unit_price, $unit_of_measure, $amount, $id);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}




//DISPLAY ALL POD_ITEMS

public function display_all_pod_items_where_supplier_id($purchase_order_id)
{
    $sql = "SELECT 
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
    suppliers.description,
    suppliers.supplier_id,
    pod_items.category,
    pod_items.item_description,
    pod_items.unit_of_measure,
    pod_items.unit_price,
    pod_items.amount,
    pod_items.quantity, 
    pod_items.id
FROM 
    purchase_orders
LEFT JOIN 
    pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
LEFT JOIN
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
WHERE 
    purchase_orders.purchase_order_id = ?";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }

    $stmt->bind_param("i", $purchase_order_id);

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die('Get result error: ' . $stmt->error);
    }

    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    $stmt->close();

    return $p_order; 
}

// get_purchase_order_details

public function get_purchase_order_details($id)
{
    $sql = "SELECT 
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
        suppliers.description,
        suppliers.supplier_id,
        suppliers.address,
        pod_items.category,
        pod_items.item_description,
        pod_items.unit_of_measure,
        pod_items.unit_price,
        pod_items.amount,
        pod_items.quantity, 
        pod_items.id,
        delivery_receipts.dr_id,
        delivery_receipts.receipt_number,
        delivery_receipts.sales_representative,
        delivery_receipts.checked_by,
        delivery_receipts.created_at
    FROM 
        purchase_orders
    LEFT JOIN 
        pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
    LEFT JOIN
        suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
    LEFT JOIN
        delivery_receipts ON purchase_orders.purchase_order_id = delivery_receipts.dr_id
    WHERE 
        purchase_orders.purchase_order_id = ?";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die('Get result error: ' . $stmt->error);
    }

    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    $stmt->close();

    return $p_order; 
}


// Query for the Receive page


public function dr_receive($id)
{
    $sql = "SELECT 
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
    suppliers.description,
    suppliers.supplier_id,
    suppliers.address,
    pod_items.category,
    pod_items.item_description,
    pod_items.unit_of_measure,
    pod_items.unit_price,
    pod_items.amount,
    pod_items.quantity, 
    pod_items.id
FROM 
    pod_items
LEFT JOIN 
    purchase_orders ON pod_items.purchase_order_id = purchase_orders.purchase_order_id
LEFT JOIN
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
WHERE 
    purchase_orders.purchase_order_id = ?";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die('Get result error: ' . $stmt->error);
    }

    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    $stmt->close();

    return $p_order; 
}

//Join_for_display_receipt

public function display_receipt($id)
{
    $sql = "SELECT DISTINCT
    
    po.purchase_order_id,
    po.supplier_id,
    po.purchase_order_number,
    po.order_date,
    po.mode_of_procurement,
    po.procurement_number,
    po.procurement_date,
    po.place_of_delivery,
    po.delivery_date,
    po.term_of_delivery,
    po.status,
    pod.id AS pod_id,
    dr.dr_id,
    dr.purchase_order_id,
    dr.receipt_number,
    dr.sales_representative,
    dr.checked_by,
    dr.created_at,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.item_description
        ELSE NULL
    END AS item_description,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.quantity
        ELSE NULL
    END AS quantity,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.unit_price
        ELSE NULL
    END AS unit_price,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.unit_of_measure
        ELSE NULL
    END AS unit_of_measure,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.amount
        ELSE NULL
    END AS amount,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.date_expiry
        ELSE NULL
    END AS date_expiry,
    CASE
        WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.serial_Id
        ELSE NULL
    END AS serial_Id,
    s.description AS supplier_description,
    s.abbreviation AS supplier_abbreviation,
    s.address,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.item_description END ORDER BY pod.item_description SEPARATOR ', ') AS item_descriptions,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.quantity END ORDER BY pod.item_description SEPARATOR ', ') AS quantities,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.unit_price END ORDER BY pod.item_description SEPARATOR ', ') AS unit_prices,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.category END ORDER BY pod.item_description SEPARATOR ', ') AS categories,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.unit_of_measure END ORDER BY pod.item_description SEPARATOR ', ') AS units_of_measure,
    GROUP_CONCAT(DISTINCT CASE WHEN pod.serial_Id != 0 AND pod.serial_Id IS NOT NULL THEN pod.amount END ORDER BY pod.item_description SEPARATOR ', ') AS amounts
FROM 
    purchase_orders po
LEFT JOIN 
    suppliers s ON po.purchase_order_id = s.supplier_id
LEFT JOIN 
    pod_items pod ON po.purchase_order_id = pod.purchase_order_id
LEFT JOIN 
    delivery_receipts dr ON po.purchase_order_id = dr.dr_id
WHERE 
    po.purchase_order_id = ?
GROUP BY 
    po.purchase_order_id, 
    po.supplier_id,
    po.purchase_order_number,
    po.order_date,
    po.mode_of_procurement,
    po.procurement_number,
    po.procurement_date,
    po.place_of_delivery,
    po.delivery_date,
    po.term_of_delivery,
    po.status,
    s.description,
    s.abbreviation,
    s.address,
    dr.receipt_number,
    dr.sales_representative,
    dr.checked_by,
    pod.id 
ORDER BY 
    pod.item_description;
";

    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $this->conn->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die('Get result error: ' . $stmt->error);
    }

    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    $stmt->close();

    return $p_order; 
}




}






