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
                   <a href="#"><img src="./images/heart.png" alt="" /></a>
                   <span class="badge">2</span><br/>
                   <p>Your Wishlist </p>
                 </div>
            
                 <div class="Your-Cart-icon">
                   <a href=""><img src="./images/cart.png" alt="" /></a>
                   <span class="badge">3</span> <br/>
                   <p>Your Cart</p>
                 </div>
            </div>
       </header>
           <div class="navbar1">
               <a href="#" class="hom">Home</a>
               <a href="#">About</a>
               <a href="#">Cart</a>
               <a href="#">Wishlist</a>
               <a href="#">Contact</a>
               <a href="#">Cameras</a>
               <a href="#">Accessories</a>
          </div>

          <div class="top">
             <img src="./images/top_image.webp" alt="" />
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
                  <input type="file" id="image" name="image" accept="image/*" required><br><br>

                  <label for="price">Price:</label>
                  <input type="number" id="price" name="price" step="0.01" required>

                  <input type="submit" name="submit" class="btn-primary" value="upload">
                </div>
          </form>

  </body>
</html>
