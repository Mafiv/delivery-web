<?php
// Include your authentication logic here

function uploads($user_name, $email,$phone,$pass_word)
{
    require_once '../database_connection.php';
    $sql = "INSERT INTO customer (full_name, gmail, phone_number, user_password) VALUES ('$user_name', '$email', '$phone', '$pass_word')";
    echo $user_name;
    echo "\n";
    echo $pass_word;
    
    if ($db->query($sql)) {
        $response = array('success' => true, 'message' => 'account created');
        return $response;
    } else {
        $response = array('success' => false, 'message' => 'account not created');
        return $response;
    }
}


// Handle the login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user_name and pass_word from the query string
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $user_name = $data['full_name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $pass_word = $data['password'];
    // echo $username;
    // echo "\n";
    // echo $password;
    // echo "\n";
    // Call the authenticate function
    $response = uploads($user_name, $email,$phone,$pass_word);

    // Set the response headers
    header('Content-Type: application/json');

    // Send the JSON response and stop further execution
    exit(json_encode($response));
}