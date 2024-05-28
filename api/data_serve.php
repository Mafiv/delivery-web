<?php


// Assuming you have the database connection set up
require_once '../database_connection.php';

// Handle the API request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM delivery_items";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $items = array();
        while ($row = $result->fetch_assoc()) {
            $items[] = array(
                'id' => $row['id'],
                'item_name' => $row['item_name'],
                'image' => base64_encode($row['image']),
                'price' => $row['price'],
                'rating' => $row['ratin'],
                'created' => $row['created']
            );
        }

        // Set the response headers
        header('Content-Type: application/json');

        // Send the JSON response
        echo json_encode($items);
    } else {
        // Set the response headers
        header('Content-Type: application/json');

        // Send a JSON response indicating that no items were found
        echo json_encode(array('message' => 'No items found'));
    }

    // Stop further execution
    exit;
}



?>