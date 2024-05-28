<?php
require_once 'database_connection.php';
$query = "SELECT items FROM wish_list";
$result_1 = $db->query($query);
$sql = "SELECT * FROM delivery_items LIMIT 3";
$result = $db->query($sql);

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

    $addToCartBtn = '<button>Add to Cart</button>';
    $box .= $addToCartBtn;

    $box .= '</div>';

    return $box;
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
               <a href="#">Contact</a>
               <a href="#">Cameras</a>
               <a href="#">Accessories</a>
          </div>    

          <div class="top">
             <!-- <img src="./images/top_image.webp" alt="" /> -->
          </div> 

            <div class="navbar2">
             <h1>New Products</h1><br><br>

            </div>
            <div id="product-container" class="productContainer"></div>    
            

            
            <?php if($result_1->num_rows>0){?>
            
            <?php while($row=$result_1->fetch_assoc()){?>
                


                <?php

                $items = json_decode($row['items'], true);
            foreach ($items as $item) {?>
                <?php
                // Access individual elements of 'items' column
                // echo $item . "<br>";
                $sql = "SELECT * FROM delivery_items WHERE id=$item";
                $result = $db->query($sql);
                ?>
                  
            <?php if($result->num_rows>0){?>
            
            <?php while($row=$result->fetch_assoc()){?>

                <div class="img_box">
                <?php
                echo createProductBox($row);
                ?>
                </div>
                
            <?php }?>
    
            <?php } 
            else{?>
            <!-- <p>image not found</p> -->
    
            <?php }?>
                




            <?php }?>








                
                
            <?php }?>
    


            <?php } 
            else{?>
            <p>noting found</p>
    
            <?php }?>

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