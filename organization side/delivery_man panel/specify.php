<?php

if (isset($_POST['cart_id'])) {
    $cartId = $_POST['cart_id'];
    // Rest of the code
} else {
    // Handle the case where 'cart_id' is not set
    echo "Error: 'cart_id' parameter is missing.";
}

function ret() {
    global $cartId;
    echo $cartId;
    return $cartId;
}

// echo 45;
// echo ret(); // Call the ret() function and output the result