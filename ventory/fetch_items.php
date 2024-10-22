<?php
$conn = new mysqli("localhost", "root", "", "inventory_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    
    $query = "SELECT description FROM ";
    switch($category) {
        case 'Bedding and Linens':
            $query .= "bedding_and_linens";
            break;
        case 'Carpentry':
            $query .= "carpentry";
            break;
        case 'CHB Casting (LSB Warehouse)':
            $query .= "chb_casting";
            break;
        case 'Construction':
            $query .= "construction";
            break;
        case 'Electrical':
            $query .= "electrical";
            break;
        case 'Greenery':
            $query .= "greenery";
            break;     
        case 'Hygienic And Toiletries':
            $query .= "hygienic_and_toiletries ";
            break;
        case 'Masonry':
            $query .= "masonry";
            break;    
        case 'Office Equipment':
            $query .= "office_equipment";
            break;        
        case 'Paints':
            $query .= "paints";
            break;
        case 'Plumbing':
            $query .= "plumbing";
            break;
        case 'Reserved Item':
            $query .= "reserved_items";
            break;
        case 'Sports Apparel And Accessories':
            $query .= "sports_apparel_and_accessories";
            break;
        case 'Sports Awards':
            $query .= "sports_awards";
            break;
        case 'Sports Equipment':
            $query .= "sports_equipment";
            break;
        case 'Tools And Equipments':
            $query .= "tools_and_equipments";
            break;
            default:
            echo '<option value="">No items found</option>';
            exit;
    }

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Item</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
        }
    } else {
        echo '<option value="">No items found</option>';
    }
}

$conn->close();
?>
