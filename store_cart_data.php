<?php
session_start();

require_once 'database_connection.php';

function createProductBox($product)
{
    $box = '<div class="product-box">';

    $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
    $box .= $img;

    $name = '<h5>' . $product['item_name'] . '</h5>';
    $box .= $name;

    $price = '<p class="price">Price: ' . $product['price'] . '</p>';
    $box .= $price;

    $rating = '<p class="rating">Rating: ';
    $stars = '<span>' . str_repeat('&#9733;', $product['ratin']) . str_repeat('&#9734;', 5 - $product['ratin']) . '</span>';
    $rating .= $stars;
    $rating .= '</p>';
    $box .= $rating;

    $addToCartBtn = '<button id="btn' . $product['id'] . '" onclick="addToCart(' . $product['id'] . ')">Add to Cart</button><br>';
    $box .= $addToCartBtn;

    $removeBtn = '<button id="btn_r' . $product['id'] . '" onclick="remove(' . $product['id'] . ')">remove from cart</button><br>';
    $box .= $removeBtn;
    
    $addToCartInput = '<input type="number" id="quantity_' . $product['id'] . '" min="1" value="1" style="width: 50px; height: 30px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">';
    $box .= $addToCartInput;

    $box .= '</div>';

    return $box;
}

if(!isset($_SESSION['a'])){
    $cartData = $_SESSION['a'];
    echo 45;
}

else{
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

            <div class="logo">SMART.</div>
        
            <div class="search-bar">
             <input type="text" placeholder="Search here"/>
             <button>Search</button>
            </div>
        
            <div class="menu-header-icon">
        
                 <div class="wishlist-icon">
                   <a href="wishlist.php"><img src="./images/heart.png" alt="" /></a>
                   <span class="badge">2</span><br/>
                   <p>Your Wishlist </p>
                 </div>
            
                 <div class="Your-Cart-icon">
                   <a href="cart.php"><img src="./images/cart.png" alt="" /></a>
                   <span class="badge">3</span> <br/> 
                   <p>Your Cart</p>  
                 </div>
            </div>  
       </header>  
           <div class="navbar1">
               <a href="index.php" class="hom">Home</a>
               <a href="about.php">About</a>
               <a href="cart.php">Cart</a>
               <a href="wishlist.php">Wishlist</a>
               <a href="store_cart_data.php">Contact</a>
               <a href="store_wish_data.php">Cameras</a>
               <a href="#">Accessories</a>
          </div>    

          <div class="top">
             <!-- <img src="./images/top_image.webp" alt="" /> -->
             <button> <a href="">Proceed to payment</a></button>
          </div> 

            <div class="navbar2">
             <h1>Your Cart</h1><br><br>

            </div>
            <div id="product-container" class="productContainer"></div>    

            
        <?php
    
        foreach ($cartData as $item) {        
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
                            echo createProductBox($row);
                ?>
                </div>
                
            <?php }?>
    


            <?php } 
            else{?>
            <p>noting found</p>
    
            <?php }?>
            <?php }?>              
            <script>


/*
    function remove(productId){
        // $a=productId;
        console.log(4);
    //     <?php 
    //    unset($_SESSION['cartData']['13']);
    //    $_SESSION['a'] = $_SESSION['cartData'];
    //     ?>
        location.reload();
    ;}

*/

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