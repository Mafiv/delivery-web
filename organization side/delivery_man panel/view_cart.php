<?php
session_start();

$user_data = $_SESSION['user_data'];


// // Now you can access the user data in the $user_data array
$full_name = $user_data['full_name'];
$email = $user_data['username'];
$phone_number = $user_data['phone_number'];
$password = $user_data['user_password'];
$img_url=$user_data['image_url'];


require_once '../../database_connection.php';
function createProductBox($product)
{

    $box = '<div class="product-box">';

    $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
    $box .= $img;

    $name = '<h5>' . $product['item_name'] . '</h5>';
    $box .= $name;

    $price = '<p class="price">Price: ' . $product['price'] . '</p>';
    $box .= $price;



    
    $box .= '</div>';

    return $box;
}


// Assuming you have the session id stored in a variable called $session_id

// Query the database to fetch the data from the cart table
$sql = "SELECT * FROM cart ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
       
.hero{
  height: 200px;
  padding-top: 10px;
  width: 90vw;
}
.owner{
    /* position: relative;
    left: 50vw;
    top: -25vh; */
    background-color:yellow; /*rgba(0, 0, 0, 0.3);*/
    /* width: 150px; */
    height: 50%;
    /* height: 10px; */
    /* text-align: center; */
    padding: 50px 50px;
    border-radius: 2rem;
    /* clear: both; */
    /* margin-top: 20px; */

}
.cart_owner{
    /* position: relative;
    left: 30vw;
    top: -40vh; */
    background-color: rgba(0, 0, 0, 0.3);
    /* width: 200px; */
    height: 50%;
    /* text-align: center; */
    padding: 50px 50px;
    border-radius: 2rem;
}
.take_cart{
  /* position: relative;
    left: 71vw;
    top: -56vh; */
    background-color: rgba(0, 0, 0, 0.3);
    /* width: 200px; */
    height:10px;
    /* text-align: center; */
    padding: 50px 50px;
    border-radius: 2rem;

}


    </style>
    <title>Document</title>
    
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


<div class="cont">
<?php
$cart_data = [];
while ($row = $result->fetch_assoc()) {
    $quantity = $row['quantity'];
    $cart_status=$row['cart_status'];
    $quantity_array = explode(",", $quantity);
    foreach($quantity_array as $term){
        $term_array = explode(":", $term);
        $stmt = $db->prepare("SELECT * FROM delivery_items WHERE id = ?");
        $stmt->bind_param("i", $term_array[0]);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows>0){
                while($rows=$results->fetch_assoc()){
                    echo createProductBox($rows);}}
                    

    }

    echo '<div class="hero" style="display: flex; justify-content: space-between;">';
    echo '<div class="owner" id="cart_no_' . $row['id'] . '">' . $cart_status . '</div>';
    echo '<div class="cart_owner">owner\'s id = ' . $row['cart_owner'] . '</div>';
    echo '<div class="take_cart" id="quantity_' . $row['id'] . '" onclick="deliver(' . $row['id'] . ')">Deliver the cart</div>';
    echo '</div>';
    echo "<hr>";
    echo "<hr>";
    }
    
    // echo $quantity_array[1];
    // echo "\n";
    // Trim any whitespace from the elements and create an array of key-value pairs as strings


// The final result
// print_r($cart_data);
?>
</div>

<script>

          function performSearch() {
  
            var searchTerm = document.getElementById("searhing_term").value;
            console.log(searchTerm)
            term=searchTerm; 
            window.location.href =  "http://localhost/delivery-web/organization%20side/delivery_man%20panel/homepage.php?term=" + encodeURIComponent(term);
          }


          function toggleMenu(){
              let subMenu = document.getElementById("subMenu");
              subMenu.classList.toggle("open-menu");
              console.log(45);
            }
            // document.addEventListener('mousemove', handleMouseMove);


            function deliver(productId) {
  
    // Make the AJAX request to 'deliver_cart.php'
    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', 'deliver_cart.php', true);
    xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr2.onreadystatechange = function() {
        if (xhr2.readyState === XMLHttpRequest.DONE && xhr2.status === 200) {
            // Handle the response from the server
            window.open("http://localhost/delivery-web/organization%20side/delivery_man%20panel/map.php");
        } else {
            console.log('Error occurred during delivery request.');
        }
    };
    xhr2.send('product_id=' + encodeURIComponent(productId));
}
          var ownerDivs = document.getElementsByClassName("owner");

// Loop through each "owner" div
for (var i = 0; i < ownerDivs.length; i++) {
  // Get the text content of the current div
  var text = ownerDivs[i].textContent.trim();

  // Check if the text content is equal to "on the way"
  if (text === "on the way") {
    // Change the background color to blue for the current "owner" div
    ownerDivs[i].style.backgroundColor = "red";
  }
}

      </script>

</body>
</html>