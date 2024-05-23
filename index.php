<?php
require_once 'database_connection.php';
$sql = "select * from delivery_items order by id DESC";
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
             <div class="Signin">
                  <a href="Login.html" class="underline-text">Sign In</a> | 
                  <a href="signup.html" class="underline-text">Sign Up</a>
             </div>
        </div>  
        </header> 
        <div class="frame">
          <div class="slideshow-container">
            <div class="mySlides fade">
              <img src="Home Img/top_image.webp">
              <div class="button-container">
                <button class="button">Button 1</button>
              </div>
            </div>
          
            <div class="mySlides fade">
              <img src="Home Img/delivery-2.jpg">
              <div class="button-container">
                <button class="button">Button 2</button>
              </div>
            </div>
          
            <div class="mySlides fade">
              <img src="Home Img/back_image.jpg">
              <div class="button-container">
                <button class="button">Button 3</button>
              </div>
            </div>
          
            <button class="prev" onclick="plusSlides(-1)">❮</button>
            <button class="next" onclick="plusSlides(1)">❯</button>
          </div>
        </div>

            <div class="navbar2">
             <h1>New Products</h1><br><br>

            </div>
            <div id="product-container" class="productContainer"></div>    
            
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
            <p>image not found</p>
    
            <?php }?>

    <script type="text/javascript" src="./script.js"></script>
    <script>
          let subMenu = document.getElementById("subMenu");
          
          function toggleMenu(){
              subMenu.classList.toggle("open-menu");
          }
        </script> 
    </body>
</html>