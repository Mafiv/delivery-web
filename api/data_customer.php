<?php

// Assuming you have the database connection set up
require_once '../database_connection.php';

// Handle the API request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $user_id = $data['id'];
    $sql = "SELECT * FROM customer where id='$user_id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $items = array();
        while ($row = $result->fetch_assoc()) {
            $items[] = array(
                'id' => $row['id'],
                'full_name' => $row['full_name'],
                'gmail' => $row['gmail'],
                'phone_number' => $row['phone_number'],
                'user_password' => $row['user_password']
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