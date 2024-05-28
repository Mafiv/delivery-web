  <?php
  require_once 'database_connection.php';
  session_start();
 

  $user_data = $_SESSION['user_data'];


  // // Now you can access the user data in the $user_data array
  $full_name = $user_data['full_name'];
  $email = $user_data['gmail'];
  $phone_number = $user_data['phone_number'];
  $password = $user_data['user_password'];

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

      $addToCartBtn = '<button id="btn' . $product['id'] . '" onclick="addToCart(' . $product['id'] . ')">Add to Cart</button><br>';
      $box .= $addToCartBtn;

      $addTowishBtn = '<button id="btn_w' . $product['id'] . '" onclick="addToWish(' . $product['id'] . ')">Add to wishList</button><br>';
      $box .= $addTowishBtn;
      
      $addToCartInput = '<input type="number" id="quantity_' . $product['id'] . '" min="1" value="1" style="width: 50px; height: 30px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">';
      $box .= $addToCartInput;

      $box .= '</div>';

      return $box;
  }

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

                  <div class="Your-Cart-icon">
                  <img src="./images/user_profile.png" class="user-pic" onclick="toggleMenu()">
    <span class="badge">3</span> <br />
    <p>Profile</p>
  </div>

  <div class="sub-menu-wrap" id="subMenu">
                      <div class="sub-menu">
                        <div class="user-info">
                          <img src="profile/user.png" alt="">
                          <h2><?php echo $full_name ?></h2>
                        </div>
                        <hr>
                        <a href="#" class="sub-menu-link">
                          <img src="profile/help.png" >
                          <p>Help & Support</p>
                          <span>></span>
                        </a>
                        <a href="./edit_profile.php" class="sub-menu-link">
                          <img src="profile/profile.png" >
                          <p>Edit Profile</p>
                          <span>></span>
                        </a>
                        <a href="#" class="sub-menu-link">
                          <img src="profile/logout.png" >
                          <p>Logout</p>
                          <span>></span>
                        </a>
                      </div>     
                  </div>
  <style>

    *{
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      box-sizing: border-box;
  }

  .hero{
      width: 100%;
      min-height: 100vh;
      padding: 10px 0;

      
  }
  nav{
      background-color: white;
      border-bottom: 4px solid rgb(216, 216, 216);   
      width: 100%;
      padding: 10px 10%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      background: rgb(190, 187, 187);
  }
  .logo{
    width: 120px;
  }
  .user-pic{
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      align-items: center;
  }
  nav ul{
      width: 100%;
      padding-left: 110px;
  }
  nav ul li{
      display: inline-block;
      list-style: none;
      margin: 10px 20px;
  }
  .hero .hom{
      text-decoration: underline;
    }

  .hero a{
      color: #201a1a;
      text-decoration: none; 
  }
  .hero a:hover {
      color: red;
  }
  .sub-menu-wrap {
      position: absolute;
      top: 15%;
      right: 0%;
      width: 320px;
      max-height: 0px;
      overflow: hidden;
      transition: max-height 0.5s;

  }
  .sub-menu-wrap.open-menu{
      max-height: 400px;
      
  }
  .sub-menu{
      background: #fff;
      padding: 20px;
      margin: 10px;
  }
  .user-info{
    display: flex;
    align-items: center;
  }
  .user-info h2{
    font-weight: 500;

  }
  .user-info img{
    width: 60px;
    border-radius: 50%;
    margin-right: 15px;
  }
  .sub-menu hr{
      border: 0;
      height: 1px;
      width: 100%;
      background: #ccc;
      margin: 15px 0 10px;
  }
  .sub-menu-link{
      display: flex;
      align-items: center;
      text-decoration: none;
      color: black;
      margin: 12px 0;
  }
  .sub-menu-link p {
      width: 100%;
      color: #525252;
      padding-left: 10px;
  }
  .sub-menu-link img{
      width: 40px;
      background: #e5e5e5;
      border-radius: 50%;
      padding: 8px;
      margin-left: 15px;
  }
  .sub-menu-link span{
      font-size: 15px;
      color: #525252;
      transition: transform 0.5s;
  }
  .sub-menu-link:hover span {
      transform: translatex(5px);
  }
  .sub-menu-link:hover p{
      font-weight: 600;
  }
  </style>

                  

              </div>  
        </header>  
            <div class="navbar1">  
                <a href="index.php" class="hom">Home</a>
                <a href="about.php">About</a>
                <a href="cart.php">Cart</a>
                <a href="wishlist.php">Wishlist</a>
                <a href="store_cart_data.php">Contact</a>
                <a href="store_wish_data.php">Cameras</a>
                <a href="./api/hellow.php">Accessories</a>
            </div>    

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

          function toggleMenu(){
              let subMenu = document.getElementById("subMenu");
              subMenu.classList.toggle("open-menu");
              console.log(45);
            }


      </script>
      </body>
  </html>
