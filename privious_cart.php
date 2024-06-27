<?php
session_start();
require_once 'database_connection.php';
function createProductBox($product)
{

    $box = '<div class="productt-box">';

    $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
    $box .= $img;

    $name = '<h5>' . $product['item_name'] . '</h5>';
    $box .= $name;

    $price = '<p class="price">Price: ' . $product['price'] . '</p>';
    $box .= $price;



    
    $box .= '</div>';

    return $box;
}


// Assuming you have the session id stored in a variable called $session_id
$session_id = $_SESSION['user_data']['id'];

// Query the database to fetch the data from the cart table
$sql = "SELECT * FROM cart WHERE cart_owner = ? ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $session_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
.productt-box img {
  width: 200px;
  height: 200px;
}
.owner{
    position: relative;
    left: 60vw;
    top: -25vh;
    background-color: green;
    width: 100px;
    height: 20px;
    text-align: center;
    padding: 50px 50px;
    border-radius: 2rem;
}

    </style>
    <title>Document</title>
    
</head>
<body>
    
<?php
$cart_data = [];
while ($row = $result->fetch_assoc()) {
    $quantity = $row['quantity'];
    $cart_status=$row['cart_status'];
    $quantity_array = explode(",", $quantity);
    foreach($quantity_array as $term){
        $term_array = explode(":", $term);
        $stmt = $db->prepare("SELECT * FROM delivery_items WHERE id = ?");
        $stmt->bind_param("i", $term_array[0]);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows>0){
                while($rows=$results->fetch_assoc()){
                    echo createProductBox($rows);}}
                    

    }

    echo "<div class='owner'>".$cart_status."</div>";

    echo "<hr>";
    echo "<hr>";
    }
    // echo $quantity_array[1];
    // echo "\n";
    // Trim any whitespace from the elements and create an array of key-value pairs as strings


// The final result
// print_r($cart_data);
?>

</body>
</html>