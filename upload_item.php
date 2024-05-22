<?php
require_once 'database_connection.php';   

$status = $statusMsg = '';

try{
if(isset($_POST["submit"])){
    $status='error';
    if(!empty($_FILES['image']['name'])){
        $items_name = $_POST["name"];
        $items_price = $_POST["price"];
        $filename = basename($_FILES["image"]["name"]);
        $filetype =pathinfo($filename,PATHINFO_EXTENSION);
        $allowtypes=array('jpg','png','jpeg','gif');
        if(in_array($filetype,$allowtypes)){
            $image=$_FILES['image']['tmp_name'];
            $image_content=addslashes(file_get_contents($image));
            //insert image to db
            $insert=$db->query("INSERT INTO delivery_items(item_name,price,image,created ) VALUES ('".$items_name."','".$items_price."' ,'".$image_content."',NOW())");
            if($insert){
                $status="sucess";
                $statusMsg="File upload was sucessful";
            }
            else{
                $statusMsg="File upload faild, please try again ";
            }
        }
        else{
            $statusMsg='please only register allowablw image formats';
        }

    }
    else{
        $statusMsg='plese enter the image for a file';
    }

}
}
catch(Error){
    $statusMsg='Error occured';
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
                   <a href="#"><img src="heart.png" alt="" /></a>
                   <span class="badge">2</span><br/>
                   <p>Your Wishlist </p>
                 </div>
            
                 <div class="Your-Cart-icon">
                   <a href=""><img src="cart.png" alt="" /></a>
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

          <!-- <div class="top">
             <img src="top_image.webp" alt="" />
          </div>  -->

          <div class="navbar2">
    <h1>Add Products</h1><br><br>
            </div>

    <div class="statusMsg">
        <?php
            if (!empty($statusMsg)) {
                ?>
                <p class="status <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                <script>console.log('<?php echo $statusMsg; ?>');</script>
                <?php
            } else {
                ?>
                <p class="status <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                <?php
            }
        ?>
        </div>

    </body>