<?php
session_start();

require_once 'database_connection.php';
require_once './functions/fun.php';



$user_data = $_SESSION['user_data'];


// // Now you can access the user data in the $user_data array
$full_name = $user_data['full_name'];
$email = $user_data['username'];
$phone_number = $user_data['phone_number'];
$password = $user_data['user_password'];
$img_url=$user_data['image_url'];

if (isset($_POST['productId']) && isset($_POST['quantityValue'])) {
    $productId = $_POST['productId'];
    $quantityValue = $_POST['quantityValue'];

    // Store the values in the session array
    if (!isset($_SESSION['cartData'])) {
        $_SESSION['cartData'] = array();
    }

    $_SESSION['cartData'][] = array(
        'productId' => $productId,
        'quantityValue' => $quantityValue
    );
    $_SESSION['cartData'] = array_unique($_SESSION['cartData'], SORT_REGULAR);
}


if (isset($_SESSION['cartData'])) {
    $cartData = $_SESSION['cartData'];

    // foreach ($cartData as $item) {
    //     $productId = $item['productId'];
    //     $quantityValue = $item['quantityValue'];

    //     echo "Product ID: $productId, Quantity Value: $quantityValue<br>";
    // }
}



?>




<!DOCTYPE html>
<html>
    <head>
        <title>Fastest Delivery</title>
        <link rel="stylesheet" href="./css/style.css">
        <!-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> -->
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
      <a href="store_wish_data.php"><img src="./images/heart.png" alt="" /></a>
      <p>Your Wishlist </p>
    </div>

    <div class="Your-Cart-icon">
      <a href="store_cart_data.php"><img src="./images/cart.png" alt="" /></a>
      <p>Your Cart</p>  
    </div>
    
    <div class="Your-Cart-icon">
      <a href="homepage.php"><img src="./images/home1.png" alt="" /></a>
      <p>Home Page</p>  
    </div>


    <div class="Your-Cart-icon">
     <a href="privious_cart.php"><img src="./images/cart.png" alt="" /></a> 
     <p>privous carts</p>  
   </div>

    <div class="Your-Cart-icon" onclick="toggleMenu()">
    <img src=".<?php echo $img_url; ?>"  class="user-pic" >
<p>Profile</p>
</div>

<div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
          <img src=".<?php echo $img_url; ?>" alt="">
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
 <button style="top: 20px; width: 100%; height: 5vw; text-align: center; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.2em; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: 0.3s;">
  <a href="./payment.php" style="text-decoration: none; color: white; display: block; padding: 1em;">
    Proceed to payment
  </a> 
 </button>
        <?php

    $_SESSION['temp_cart'] = "";


        $total_cost=0;

        foreach ($cartData as $item) {        
    $productId = $item['productId'];
    // echo $_SESSION['temp_cart'] ;
    $quantityValue = $item['quantityValue'];
    // echo "as".$productId."as";
    if(!is_null($productId) && !is_null($quantityValue)){
    $_SESSION['temp_cart']= "$productId:$quantityValue," . $_SESSION['temp_cart'] ;
    
    }

    $query = "SELECT * FROM delivery_items where id= $productId";
    $result = $db->query($query);

    
    // echo "Product ID: $productId, Quantity Value: $quantityValue<br>";
            
            ?>
             <!-- <?php if($result->num_rows>0){?> -->
            <?php while($row=$result->fetch_assoc()){?>
                <div class="img_box">
                <?php
                            $total_cost = $total_cost + (float)$quantityValue *(float)$row['price'];
                            echo createProductBox_v2($row,$quantityValue);
                ?>
                </div>
                
            <?php }?>
    


            <?php } 
            else{?>
            <p>noting found</p>
    
            <?php }?>
            <?php 
            
        }?>       
        <?php
        $_SESSION['temp_cart'] = substr($_SESSION['temp_cart'], 0, -1);
        $_SESSION['total_cost'] = $total_cost;
        
        ?>

        <div class="product-box " style="top: 20px; width:98%;height:5vw;text-align: center;border-radius:2rem;background-color: rgb(68, 238, 181);font-size: 2rem;">
        <p class="price">Total Price: <?php echo $total_cost; ?></p>
        </div>     
            <script>




    function handleMouseMove(event) {
        const productBoxes = document.querySelectorAll('.product-box');
        productBoxes.forEach(box => {
            const rect = box.getBoundingClientRect();
            const mouseX = event.clientX;
            const mouseY = event.clientY;
            const isClose = mouseX >= rect.left && mouseX <= rect.right && mouseY >= rect.top && mouseY <= rect.bottom;
            if (isClose) {
                box.classList.add('pop-up');
            } else {
                box.classList.remove('pop-up');
            }
        });
    }

    document.addEventListener('mousemove', handleMouseMove);
</script>

    </body>
</html>
