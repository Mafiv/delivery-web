<?php
session_start();

require_once 'database_connection.php';

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
    if (!isset($_SESSION['wishData'])) {
        $_SESSION['wishData'] = array();
    }

    $_SESSION['wishData'][] = array(
        'productId' => $productId,
        'quantityValue' => $quantityValue
    );
    $_SESSION['wishData'] = array_unique($_SESSION['wishData'], SORT_REGULAR);
}


if (isset($_SESSION['wishData'])) {
    $wishData = $_SESSION['wishData'];

    // foreach ($wishData as $item) {
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
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

            <div class="navbar2">
             <h1>Your Wish</h1><br><br>

            </div>
            <div id="product-container" class="productContainer"></div>    


        <?php
        foreach ($wishData as $item) {
    $productId = $item['productId'];
    $quantityValue = $item['quantityValue'];
    $query = "SELECT * FROM delivery_items where id= $productId";
    $result = $db->query($query);
    

    // echo "Product ID: $productId, Quantity Value: $quantityValue<br>";
            
            ?>


             <!-- <?php if($result->num_rows>0){?> -->
                
            
            <?php while($row=$result->fetch_assoc()){?>
                
                  
            
            
            

                <div class="img_box">
                <?php
                echo createProductBox_v3($row,$quantityValue);

                ?>
                </div>
   
            <?php }?>
 
            <?php } 
            else{?>
            <p>noting found</p>
    
            <?php }?>
            <?php }?>              
            <script>

            function addToCart(productId,value) {

            var cartBadge = document.getElementById(`quantity_${productId}`);
            var button_s=document.getElementById(`btn${productId}`)
            button_s.textContent="added"
            button_s.style.backgroundColor='red'

            let c=value;
        
        var xhr = new XMLHttpRequest();
        var ajaxUrl = 'store_cart_data.php';
        xhr.open("POST", ajaxUrl, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.send("productId=" + productId + "&quantityValue=" + c);
        
        }


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