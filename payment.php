<?php
session_start();

require_once 'database_connection.php';

$totalcost = $_SESSION['total_cost'];
$user_data = $_SESSION['user_data'];
$full_name = $user_data['full_name'];
$email = $user_data['username'];
$phone_number = $user_data['phone_number'];
$password = $user_data['user_password'];
$img_url=$user_data['image_url'];

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
              <p>SMART delivery </p>
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
                    <a href="homepage.php"><img src="./images/home1.png" alt="" /></a>
                    <p>Home Page</p>  
                  </div>


                  <div class="Your-Cart-icon">
                   <a href="privious_cart.php"><img src="./images/cart.png" alt="" /></a> 
                   <p>privous carts</p>  
                 </div>

                  <div class="Your-Cart-icon" onclick="toggleMenu()">
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
   

          <di v id='cont'>

            
             <h1>Transfert the payment by Account number 123456789</h1><br><br>
            
            <div id="payment_container">
                Enter payment id :
                <input style="height: 3rem;width: 20rem;" type="text" name="" id="payment_id">
            </div>    
            <button id="verify_button" onclick="handleVerifyClick()">Verify</button>
            <div id="indicator">no data </div>
            <br>
            <a href="http://localhost/delivery-web/bank_sample.php" target="_blank"><div id="Banklink">Bank link </div></a>
            </di>
         
 <script>

async function getLocation() {
  try {
    // Check if Geolocation is supported
    if (navigator.geolocation) {
      // Get the user's current position
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
      });

      // Extract the latitude and longitude
      const { latitude, longitude } = position.coords;

      // Wait for 4 seconds
      await new Promise((resolve) => setTimeout(resolve, 1000));

      console.log('4 seconds have passed!');
      return { latitude, longitude };
    } else {
      throw new Error('Geolocation is not supported by this browser.');
    }
  } catch (error) {
    console.error('Error getting location:', error);
    throw error;
  }
};

                async function handleVerifyClick(){
                    const paymentId = document.getElementById('payment_id').value;
                    const { latitude, longitude } = await getLocation();
            


                    sendVerificationRequest(paymentId,latitude,longitude)
                }
                function sendVerificationRequest(paymentId,latitude,longitude) {




  // Create a new XMLHttpRequest object
  const xhr = new XMLHttpRequest();

  // Set up the request
  xhr.open('POST', 'verify_payment.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Define the callback function to handle the response
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Handle the response from the PHP file
      handleVerificationResponse(xhr.responseText);
    }
  };

  // Send the request with the payment ID as the data
  xhr.send('payment_id=' + encodeURIComponent(paymentId) + '&'+'latitude=' + encodeURIComponent(latitude) + '&'+'longitude=' + encodeURIComponent(longitude));
}
function handleVerificationResponse(response) {
  // Update the indicator div with the response
  document.getElementById('indicator').textContent = response;
  if(response==="Payment verified"){
    document.getElementById('indicator').style.backgroundColor = 'green';
  }
  else{
    document.getElementById('indicator').style.backgroundColor = 'red'
  }
}   




</script>

    </body>
</html>