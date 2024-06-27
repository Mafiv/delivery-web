<?php
// Establish database connection
require_once '../../database_connection.php';

// Get the product ID from the AJAX request
$product_id = $_POST['product_id'];

// Remove the item from the cart
$sql = "DELETE FROM delivery_man WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();

// Return a response to the client
// echo "Item removed from cart.";
?>