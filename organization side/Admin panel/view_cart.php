<?php
session_start();

$user_data = $_SESSION['user_data'];


// // Now you can access the user data in the $user_data array
$full_name = $user_data['full_name'];
$email = $user_data['username'];
$phone_number = $user_data['phone_number'];
$password = $user_data['user_password'];
$img_url=$user_data['image_url'];


require_once '../../database_connection.php';
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

// Query the database to fetch the data from the cart table
$sql = "SELECT * FROM cart";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
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
    width: 200px;
    height: 20px;
    text-align: center;
    padding: 50px 50px;
    border-radius: 2rem;
}
.cart_owner{
    position: relative;
    left: 40vw;
    top: -40vh;
    background-color: green;
    width: 200px;
    height: 20px;
    text-align: center;
    padding: 50px 50px;
    border-radius: 2rem;
}

    </style>
    <title>Document</title>
    
</head>
<body>
<header class="Logoo" >

<!-- <div class="logo">SMART.</div> -->
<p>SMART delivery </p>
<div class="search-bar">
<input id="searhing_term"type="text" placeholder="Search here"/>
<button  onclick="performSearch()" >Search</button>
</div>

<div class="menu-header-icon">

    <div class="wishlist-icon">
      <a href="view_employee.php"><img src="../../images/heart.png" alt="" /></a>
      <p>View Employees </p>
    </div>

    <div class="Your-Cart-icon">
      <a href="view_customer.php"><img src="../../images/cart.png" alt="" /></a>
      <p>View Customers</p>  
    </div>

    <div class="Your-Cart-icon">
     <a href="view_cart.php"><img src="../../images/cart.png" alt="" /></a> 
     <p>View Oreders</p>  
   </div>

    <div class="Your-Cart-icon" onclick="toggleMenu()">
    <img src="../../<?php echo $img_url; ?>"  class="user-pic" >
<p>Profile</p>
</div>

<div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
          <img src="../../<?php echo $img_url; ?>" alt="">    
          
            <h2><?php echo $full_name ?></h2>
          </div>
          <hr>
          <a href="./help_support.php" class="sub-menu-link">
            <img src="profile/help.png" >
            <p>Help & Support</p>
            <span>></span>
          </a>
          <a href="./edit_profile.php" class="sub-menu-link">
            <img src="profile/profile.png" >
            <p>Edit Profile</p>
            <span>></span>
          </a>
          <a href="./index.php" class="sub-menu-link">
            <img src="profile/logout.png" >
            <p>Logout</p>
            <span>></span>
          </a>
        </div>     
    </div>

</div>  
</header>  



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
    echo "<div class='cart_owner'>owner's id = ".$row['cart_owner']."</div>";

    echo "<hr>";
    echo "<hr>";
    }
    // echo $quantity_array[1];
    // echo "\n";
    // Trim any whitespace from the elements and create an array of key-value pairs as strings


// The final result
// print_r($cart_data);
?>

<script>


          function remove_from_cart(productId) {
              var button_s=document.getElementById(`btn${productId}`)
              button_s.textContent="removed"
              button_s.style.backgroundColor='red'
              var xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_from_cart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Handle the response from the server
                console.log(xhr.responseText);
                }   
                };
                xhr.send('product_id=' + encodeURIComponent(productId));        
            
                window.location.href =  "http://localhost/delivery-web/organization%20side/Admin%20panel/homepage.php"
            }


          function performSearch() {
  
            var searchTerm = document.getElementById("searhing_term").value;
            console.log(searchTerm)
            term=searchTerm;
            window.location.href =  "http://localhost/delivery-web/organization%20side/Admin%20panel/homepage.php?term=" + encodeURIComponent(term);
          }
          function toggleMenu(){
              let subMenu = document.getElementById("subMenu");
              subMenu.classList.toggle("open-menu");
              console.log(45);
            }
            // document.addEventListener('mousemove', handleMouseMove);
      </script>

</body>
</html>