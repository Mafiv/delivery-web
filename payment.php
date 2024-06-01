<?php
session_start();

require_once 'database_connection.php';

$totalcost = $_SESSION['total_cost'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Fastest Delivery</title>
        <link rel="stylesheet" href="./css/style.css">
        <!-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> -->
    </head>
    <body>
        <header class="Logoo" >

            <div class="logo">SMART.</div>
        
            
            <div class="menu-header-icon">
        
            </div>  
       </header>  
           <div class="navbar1">
               <a href="homepage.php" class="hom">Home</a>
          </div>    

          <div class="top">
             <!-- <img src="./images/top_image.webp" alt="" /> -->
             <!-- <button> <a href="./payment.php">Proceed to payment</a></button> -->
          </div> 

            <div class="navbar2">
             <h1>transfert the payment by this id 123456789</h1><br><br>

            </div>
            <div id="payment_container">
                Enter payment id :
                <input style="height: 3rem;width: 20rem;" type="text" name="" id="payment_id">

            </div>    
            <button id="verify_button" onclick="handleVerifyClick()">Verify</button>
            <div id="indicator">None</div>



            <style>
  #container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
  }

  #payment_container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  #payment_container label {
    font-size: 18px;
    font-weight: bold;
    margin-right: 10px;
  }

  #payment_container input[type="text"] {
    font-size: 16px;
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    width: 300px;
    max-width: 100%;
  }

  #verify_button {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    position: relative;
    left: 40vw;
    top: -60px;
  }

  #verify_button:hover {
    background-color: #45a049;
  }

  #indicator {
    font-size: 18px;
    font-weight: bold;
    background-color: wheat;
    height: 10vh;
    width: 200px;
    position: relative;
    left: 10vw;

  }
</style>          
            <script>
                function handleVerifyClick(){
                    const paymentId = document.getElementById('payment_id').value;
                    
                    sendVerificationRequest(paymentId)
                }
                function sendVerificationRequest(paymentId) {
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
  xhr.send('payment_id=' + encodeURIComponent(paymentId));
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