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

//    public function Purchase_order($id)
// {
//     $sql = "SELECT 
//     purchase_orders.supplier_id,
//     purchase_orders.purchase_order_number,
//     purchase_orders.order_date,
//     purchase_orders.mode_of_procurement,
//     purchase_orders.procurement_number,
//     purchase_orders.procurement_date,
//     purchase_orders.place_of_delivery,
//     purchase_orders.delivery_date,
//     purchase_orders.term_of_delivery,
//     purchase_orders.status,
//     suppliers.description
// FROM 
//     purchase_orders
// JOIN
//     suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
// WHERE 
//     purchase_orders.supplier_id = ?"; 
//     $stmt = $this->conn->prepare($sql);
//     if ($stmt === false) {
//         die('MySQL prepare error: ' . $this->conn->error);
//     }
//     $stmt->bind_param("i", $id); 

//     if (!$stmt->execute()) {
//         die('Execute error: ' . $stmt->error);
//     }
//     $result = $stmt->get_result();
//     $p_order = array();
//     while ($row = $result->fetch_assoc()) {
//         $p_order[] = (object) $row;
//     }
//     $stmt->close();

//     return $p_order; 
// }


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
    suppliers.supplier_id
FROM 
    purchase_orders
LEFT JOIN 
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
WHERE 
    suppliers.supplier_id
";

$query = $this->conn->query($sql);
$Cservices = array();
while ($row = $query->fetch_assoc()) {
    $Cservices[] = (object) $row;
}
return $Cservices;
}


//Deletion for purchase_order

public function deleteRecordFromPOders($id) {
    $sql = "DELETE FROM purchase_orders WHERE supplier_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return "Record with supplier ID $id successfully deleted.";
    } else {
        return "Error deleting record with supplier ID $id: " . $this->conn->error;
    }

    $stmt->close();
}

// total Amount of Purchase Order

public function total_amount_of_purchase_oder () {
    $sql = "
    SELECT 
    pod_items.supplier_id,
    COALESCE(SUM(pod_items.amount), 0) AS total_amount
FROM
    pod_items
GROUP BY 
    pod_items.supplier_id;


    ";
    $query = $this->conn->query($sql);
    $Cservices = array();
    while ($row = $query->fetch_assoc()) {
        $Cservices[] = (object) $row;
    }
    return $Cservices;
}

}






