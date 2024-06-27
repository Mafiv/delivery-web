<?php
session_start();

require_once 'database_connection.php';

// Get the payment ID from the request
$paymentId = $_POST['payment_id'];
$latitude = (string)$_POST['latitude'];
$longitude = (string)$_POST['longitude'];

// Perform the verification logic
$isValid = verifyPayment($paymentId, $db,$latitude,$longitude);

// Output the result
if ($isValid) {
  echo "Payment verified";
} else {
  echo "Payment not verified";
}

// Function to verify the payment
function verifyPayment($paymentId, $db,$latitude,$longitude) {
  // Prepare the SQL query
  $sql = "SELECT * FROM bank_deposit WHERE id = ? AND transfer_to_account_id = 123456789";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $paymentId);

  // Execute the query
  $stmt->execute();
  $result = $stmt->get_result();
$cost=(float)$_SESSION['total_cost'];
$result_db=$result->fetch_assoc();
  // Check if the payment is found in the table and the transfer_to_account_id is 123456789
  if ($result->num_rows > 0 && $result_db['transfer_to_account_id'] == 123456789 && $result_db['amount']>=$cost) {
    // Payment is valid
  $sql = "SELECT COUNT(*) FROM transaction_list WHERE transaction_id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $paymentId);

  // Execute the query
  $stmt->execute();
  $result = $stmt->get_result();
  $count = $result->fetch_row()[0];

  if ($count == 0) {
    $temp_cart_items = $_SESSION['temp_cart'];
    
    $user_id = $_SESSION['user_data']['id'];
    $stmt = $db->prepare("INSERT INTO cart (quantity, cart_owner,lat,lng)values(?,?,?,?);");
    
    $stmt->bind_param("ssss", $temp_cart_items,$user_id,$latitude,$longitude);
    $stmt->execute();
    $stmt->close();
 
    // Insert the payment ID into the transaction_list table
    $sql = "INSERT INTO transaction_list (transaction_id) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $paymentId);
    $stmt->execute();

    return true;}
    else{
      return false;
    }

  } else {
    // Payment is not valid
    return false;
  }
}
?>