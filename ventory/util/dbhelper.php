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

   // Dashboard for purchase Order

   public function Purchase_order($id)
{
    $sql = "SELECT 
    purchase_orders.supplier_id,
    purchase_orders.purchase_order_number,
    purchase_orders.order_date,
    purchase_orders.mode_of_procurement,
    purchase_orders.procurement_number,
    purchase_orders.procurement_date,
    purchase_orders.place_of_delivery,
    purchase_orders.delivery_date,
    purchase_orders.term_of_delivery,
    purchase_orders.status
FROM 
    purchase_orders
JOIN
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
WHERE 
    purchase_orders.supplier_id = '$id'";


    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    $p_oder = array();
    while ($row = $result->fetch_assoc()) {
        $p_oder[] = (object) $row;
    }
    return $p_oder;
}

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
        suppliers.description
    FROM 
        purchase_orders
    LEFT JOIN 
        suppliers ON purchase_orders.supplier_id = suppliers.supplier_id";

    // Prepare the SQL statement
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        // Handle the error
        die('Prepare failed: ' . $this->conn->error);
    }

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all rows into an array
    $p_order = array();
    while ($row = $result->fetch_assoc()) {
        $p_order[] = (object) $row;
    }

    // Return the array of purchase orders
    return $p_order;
}






}
