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
<div class="navbar1">  
  <a href="homepage.php" class="hom">Home</a>
  <a href="add_items.php" class="hom">add items</a>
</div>    

            <div class="navbar2">
             <h1>Add Products</h1>
            </div>

            <?php
                if(!empty($statusMsg)){
                    ?>
                    <p class="status <?php echo $status ?>" > <?php echo $statusMsg; ?> </p>
                    kl
                <?php } ?>  



            <form action="upload_item.php" method="POST" enctype="multipart/form-data">
              <div class="input-container">
                  <label for="name">Product Name:</label>
                  <input type="text" id="name" name="name" required><br><br>
      
                  <label for="image">Image:</label>
                  <input type="file" id="Image" name="image" accept="image/*" required><br><br>

                  <label for="price">Price:</label>
                  <input type="number" id="price" name="price" step="0.01" required>
                  
                  <input type="submit" name="submit" class="btn-primary" value="upload">
                </div>
      
              
          </form>
          <style>
            .input-container{
height: 50vh;
width: 40vw;
text-align: center;
margin: 2vw auto;
background-color: #1a79de;
font-size: 2rem;
border-radius: 1rem;
padding: 1rem;
color: wheat;
}
          </style>
                  


    </body>