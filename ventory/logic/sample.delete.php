<?php
require_once "../util/dbhelper.php";

// Check if an ID was provided in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID as an integer

    $db = new DbHelper();
    $result = $db->deleteRecordFromPOders($id); // Call the delete function

    // Redirect back to the main page with a message
    header("Location: ../index.php?message=" . urlencode($result));
    exit();
} else {
    // Redirect back with an error message if no ID is provided
    header("Location: ../index.php?message=" . urlencode("Invalid ID provided for deletion."));
    exit();
}
?>
