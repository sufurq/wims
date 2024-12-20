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

    public function updateRecords($table, $data, $conditions)
    {
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

    public function deleteRecordFromPOders($id)
    {
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

    public function Edit_purchase_order($purchase_order_id, $purchase_order_number, $order_date, $mode_of_procurement, $procurement_number, $procurement_date, $place_of_delivery, $delivery_date, $term_of_delivery)
    {

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

    public function deletePod_Items($id)
    {
        $sql = " DELETE FROM pod_items WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            return "Return with supplier ID $id: successfully deleted";
        } else {
            $stmt->close();
            return "Error deleting record with pod_items ID $id: " . $this->conn->error;
        }
    }
    // Update Pod_items_Dashboard

    public function edit_pod_items($id, $category, $item, $quantity, $unit_price, $unit_of_measure, $amount)
    {
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
        $sql = "SELECT 
    COALESCE(delivery_receipts.dr_id, 'No Receipt') AS delivery_receipts_dr_id,
    suppliers.supplier_id AS supplier_id,
    pod_items.quantity AS pod_item_quantity,
    purchase_orders.purchase_order_id,
    deliveries.pod_Id AS delivery_pod_id,
    deliveries.id AS delivery_id,
    deliveries.items AS delivery_items,
    deliveries.uom AS delivery_uom,
    deliveries.quantity AS delivery_quantity,
    deliveries.serial_Id AS delivery_serial_id,
    deliveries.date_of_exp AS delivery_date_of_exp,
    deliveries.unit_cost AS delivery_unit_cost,
    deliveries.amount AS delivery_amount,
    deliveries.status AS delivery_status
FROM 
    deliveries
LEFT JOIN 
    pod_items ON deliveries.pod_Id = pod_items.id
LEFT JOIN 
    purchase_orders ON pod_items.purchase_order_id = purchase_orders.purchase_order_id
LEFT JOIN
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
LEFT JOIN 
    delivery_receipts ON purchase_orders.purchase_order_id = delivery_receipts.purchase_order_id
WHERE 
    purchase_orders.purchase_order_id = ?

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


    // display_receipt_checker
    public function display_checker($id)
    {
        $sql = "SELECT 

    delivery_receipts.dr_id,
    delivery_receipts.purchase_order_id,
    delivery_receipts.receipt_number,
    delivery_receipts.sales_representative,
    delivery_receipts.checked_by,
    delivery_receipts.dr_status,
    delivery_receipts.created_at
    
    FROM 
    
    delivery_receipts
    
    LEFT JOIN
    
    purchase_orders ON delivery_receipts.purchase_order_id = purchase_orders.purchase_order_id
    
    WHERE purchase_orders.purchase_order_id = ?
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

    //display status with receipt

    public function display_status()
    {
        $sql = "SELECT 
    suppliers.description AS suppliers_des,
    pod_items.quantity AS pod_item_quantity,
    purchase_orders.purchase_order_id,
    purchase_orders.purchase_order_number AS purchase_orders_numbers,
    purchase_orders.order_date AS purchase_orders_date,
    purchase_orders.procurement_number AS purchase_orders_pn,
    purchase_orders.delivery_date AS purchase_orders_d_date,
    
    SUM(deliveries.quantity) AS total_delivery_quantity,
    CASE
        WHEN SUM(deliveries.quantity) < pod_items.quantity THEN 'Partial'
        WHEN SUM(deliveries.quantity) >= pod_items.quantity THEN 'Fully Delivered'
        ELSE 'Pending'
    END AS delivery_status
FROM 
    purchase_orders
LEFT JOIN 
    pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
LEFT JOIN 
    deliveries ON pod_items.id = deliveries.pod_Id
LEFT JOIN 
    suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
GROUP BY 
    purchase_orders.purchase_order_id,
    purchase_orders.purchase_order_number,
    purchase_orders.order_date,
    purchase_orders.procurement_number,
    purchase_orders.delivery_date,
    suppliers.description;

";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('MySQL prepare error: ' . $this->conn->error);
        }

        // Bind the parameter for the prepared statement

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


    //get connection
    public function getConnection()
    {
        return $this->conn;
    }




    public function status_fully_delivered($status)
    {
        $sql = "SELECT 
        suppliers.description AS suppliers_des,
        suppliers.supplier_id,
        pod_items.quantity AS pod_item_quantity,
        purchase_orders.purchase_order_id,
        purchase_orders.purchase_order_number AS purchase_orders_numbers,
        purchase_orders.order_date AS purchase_orders_date,
        purchase_orders.procurement_number AS purchase_orders_pn,
        purchase_orders.delivery_date AS purchase_orders_d_date,
        SUM(deliveries.quantity) AS total_delivery_quantity,
        CASE
            WHEN SUM(deliveries.quantity) < pod_items.quantity THEN 'Partial'
            WHEN SUM(deliveries.quantity) >= pod_items.quantity THEN 'Fully Delivered'
            WHEN SUM(deliveries.quantity) = 0 THEN 'No Deliveries'
            ELSE 'Pending'
        END AS delivery_status
    FROM 
        purchase_orders
    LEFT JOIN 
        pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
    LEFT JOIN 
        deliveries ON pod_items.id = deliveries.pod_Id
    LEFT JOIN 
        suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
    GROUP BY 
        purchase_orders.purchase_order_id,
        purchase_orders.purchase_order_number,
        purchase_orders.order_date,
        purchase_orders.procurement_number,
        purchase_orders.delivery_date,
        suppliers.description
    HAVING 
        1=1";

        // Apply status filter
        if ($status !== 'all') {
            if ($status === 'fully-delivered') {
                $sql .= " AND delivery_status = 'Fully Delivered'";
            } elseif ($status === 'partial') {
                $sql .= " AND delivery_status = 'Partial'";
            } elseif ($status === 'pending') {
                $sql .= " AND delivery_status = 'Pending'";
            } elseif ($status === 'deleted') {
                $sql .= " AND delivery_status = 'Deleted'";
            }
        }

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

    // Query for Report page
    
    public function report($id)
    {
        $sql = "SELECT 
        deliveries.quantity AS del_quantity,
        deliveries.amount AS del_amount,
        deliveries.uom,
        pod_items.id,
        pod_items.unit_of_measure,
        pod_items.quantity,
        pod_items.amount,
        purchase_orders.purchase_order_id,
        purchase_orders.purchase_order_number,
        purchase_orders.order_date,
        suppliers.description,
        suppliers.supplier_id,
        pod_item_totals.Total_Amount, -- Total amount by pod item
        pod_item_totals.total_delivery_quantity, -- Total delivery quantity per pod item
        (pod_items.quantity - pod_item_totals.total_delivery_quantity) AS remaining_quantity, -- Subtraction by row
        CASE
            WHEN pod_item_totals.total_delivery_quantity < pod_items.quantity THEN 'Partial'
            WHEN pod_item_totals.total_delivery_quantity >= pod_items.quantity THEN 'Fully Delivered'
            WHEN pod_item_totals.total_delivery_quantity = 0 THEN 'No Deliveries'
            ELSE 'Pending'
        END AS delivery_status
    FROM 
        purchase_orders
    LEFT JOIN 
        pod_items ON purchase_orders.purchase_order_id = pod_items.purchase_order_id
    LEFT JOIN
        suppliers ON purchase_orders.supplier_id = suppliers.supplier_id
    LEFT JOIN 
        deliveries ON pod_items.id = deliveries.pod_Id
    LEFT JOIN (
        SELECT 
            pod_items.id AS pod_id,
            COALESCE(SUM(pod_items.amount), 0) AS Total_Amount,
            COALESCE(SUM(deliveries.quantity), 0) AS total_delivery_quantity
        FROM 
            pod_items
        LEFT JOIN 
            deliveries ON pod_items.id = deliveries.pod_Id
        GROUP BY 
            pod_items.id
    ) pod_item_totals ON pod_items.id = pod_item_totals.pod_id
    WHERE 
        purchase_orders.purchase_order_id = ?
    

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
// printing excel

public function display_value_all_purchas($purchaseOrderId) {
    
    if (!$this->conn) {
        die("Database connection failed.");
    }

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
            WHERE
                purchase_orders.purchase_order_id = ?  -- Added condition for the purchaseOrderId
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
                suppliers.supplier_id;";

    $stmt = $this->conn->prepare($sql);
    
    if ($stmt === false) {
        die("SQL preparation failed: " . $this->conn->error);
    }

    $stmt->bind_param("i", $purchaseOrderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


}

