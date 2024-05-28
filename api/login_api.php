<?php
// Include your authentication logic here

function authenticate($user_name, $pass_word)
{
    require_once '../database_connection.php';
    $sql = "SELECT * FROM customer WHERE gmail = '$user_name'";

    echo $user_name;
    echo "\n";
    echo $pass_word;
    $result = $db->query($sql);
    if($result->num_rows>0){    
        $a=0;
        while($row=$result->fetch_assoc()){
            // echo createProductBox($row);
            if($row['user_password']===$pass_word){
                $response = array('success' => true, 'message' => 'Authentication successful');
                http_response_code(200);
                return $response;
            }
            else{
                $a++;
            }
        }
        if($a>0){
            $response = array('success' => false, 'message' => 'Wrong password');
            http_response_code(406);
            return $response;
        }
    } 
    else{
        $response = array('success' => false, 'message' => 'No account found');
        http_response_code(400);
        return $response;
    }
}


// Handle the login request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the user_name and pass_word from the query string
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $username = $data['username'];
    $password = $data['password'];
    // echo $username;
    // echo "\n";
    // echo $password;
    // echo "\n";
    // Call the authenticate function
    $response = authenticate($username, $password);

    // Set the response headers
    header('Content-Type: application/json');

    // Send the JSON response and stop further execution
    exit(json_encode($response));
}