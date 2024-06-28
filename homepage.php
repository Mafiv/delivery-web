<?php
  require_once 'database_connection.php';
  require_once './functions/fun.php';
  session_start();
 

  $user_data = $_SESSION['user_data'];


  // // Now you can access the user data in the $user_data array
  $full_name = $user_data['full_name'];
  $email = $user_data['username'];
  $phone_number = $user_data['phone_number'];
  $password = $user_data['user_password'];
  $img_url=$user_data['image_url'];

if (!isset($term)) {
    $term = isset($_GET['term']) ? $_GET['term'] : '';  
}
$sql = "SELECT * FROM delivery_items WHERE item_name LIKE '%$term%' ORDER BY id DESC";
$result = $db->query($sql);
if (!isset($_SESSION['clickedButtonIds'])) {
      $_SESSION['clickedButtonIds'] = array();
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
              <h2>SMART delivery </h2>
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
                    <a href="homepage.php"><img src="./images/home.png" alt=""  /></a>
                    <p>Home Page</p>  
                  </div>


                  <div class="Your-Cart-icon">
                   <a href="privious_cart.php"><img src="./images/cart.png" alt="" /></a> 
                   <p>privous carts</p>  
                 </div>

                  <div class="Your-Cart-icon" onclick="toggleMenu()"z>
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
                          <img src="images/help.png" >
                          <p>Help & Support</p>
                          <span>></span>
                        </a>
                        <a href="./edit_profile.php" class="sub-menu-link">
                          <img src="images/profile.png" >
                          <p>Edit Profile</p>
                          <span>></span>
                        </a>
                        <a href="./index.php" class="sub-menu-link">
                          <img src="images/logout.png" >
                          <p>Logout</p>
                          <span>></span>
                        </a>
                      </div>     
                  </div>
  
  

                  

              </div>  
        </header>      

            <div class="top">
             <img src="./images/top_image.webp" alt="" />
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


      <!-- <script type="text/javascript" src="./script.js"></script> -->
      

      <script>
          function addToCart(productId) {
              var cartBadge = document.getElementById(`quantity_${productId}`);
              var button_s=document.getElementById(`btn${productId}`)
              button_s.textContent="added"
              button_s.style.backgroundColor='red'

              let c=cartBadge.value;
          
              var xhr = new XMLHttpRequest();
              var ajaxUrl = 'store_cart_data.php';
              xhr.open("POST", ajaxUrl, true);
              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
              xhr.send("productId=" + productId + "&quantityValue=" + c);
              <?php $_SESSION['cartData'] = array();?>
          }

          function addToWish(productId){
              var cartBadge = document.getElementById(`quantity_${productId}`);
              var button_s=document.getElementById(`btn_w${productId}`)
              button_s.textContent="added to wishList"
              button_s.style.backgroundColor='red'

              let c=cartBadge.value;
          
          var wish = new XMLHttpRequest();
          var ajaxUrl = 'store_wish_data.php';
          wish.open("POST", ajaxUrl, true);
          wish.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          
          wish.send("productId=" + productId + "&quantityValue=" + c);
          <?php $_SESSION['wishData'] = array();?>
              
          }

          function performSearch() {
  
            var searchTerm = document.getElementById("searhing_term").value;
            console.log(searchTerm)
            term=searchTerm;
            window.location.href =  "http://localhost/delivery-web/homepage.php?term=" + encodeURIComponent(term);
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
