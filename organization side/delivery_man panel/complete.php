<?php
require_once '../../database_connection.php';

session_start();
 
$cartId=$_SESSION['cart_id_comp'];

    function ret() {
        global $cartId;
        echo $cartId;
        return $cartId;
    }

// Retrieve the latitude and longitude from the database
$query = "SELECT * FROM cart WHERE id = $cartId";
$result = $db->query($query);

// Update the cart_status to "completed"
$query = "UPDATE cart 
          SET cart_status = 'completed'
          WHERE id = $cartId";
$result = $db->query($query);


echo $cartId;
?>