<?php
require_once '../../database_connection.php'; 

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
    <h1>Products ADD</h1><br><br>
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