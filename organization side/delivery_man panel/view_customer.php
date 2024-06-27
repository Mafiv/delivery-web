<?php
  require_once '../../database_connection.php';
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


$sql = "SELECT * FROM customer WHERE full_name LIKE '%$term%' ORDER BY id DESC";

  $result = $db->query($sql);

  function createProductBox($product)
  {
      $box = '<div class="product-box">';

      $img = '<img src="../../' .   ($product['image_url']) . '"/>';
      $box .= $img;

      $name = '<h5>' . $product['full_name'] . '</h5>';
      $box .= $name;

      $price = '<p class="price">Email: ' . $product['username'] . '</p>';
      $box .= $price;

      $phone = '<p class="price">Tel.number: ' . $product['phone_number'] . '</p>';
      $box .= $phone;

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
          <link rel="stylesheet" href="../../css/style.css">
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

            <div class="navbar1">  
                <a href="homepage.php" class="hom">Home</a>

            </div>    

 

            <div class="navbar2">
             <h1>Customer list</h1><br><br>

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
            <p>No customer found</p>
    
            <?php }?>


      <!-- <script type="text/javascript" src="./script.js"></script> -->
      

      <script>

          function performSearch() {
  
            var searchTerm = document.getElementById("searhing_term").value;
            console.log(searchTerm)
            term=searchTerm;
            window.location.href =  "http://localhost/delivery-web/organization%20side/delivery_man%20panel/view_customer.php?term=" + encodeURIComponent(term);
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
