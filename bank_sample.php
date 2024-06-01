<!DOCTYPE html>
<html>
  <head>
    <title>Transfer Page</title>
    <link rel="stylesheet" href="./css/bank.css">
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    />
    <style>
      /* CSS styles omitted for brevity */
    </style>
  </head>
  <body>
    <div class="background"></div>
    <div class="navbar">
      <!-- Navbar content omitted for brevity -->
    </div>
    <div class="container">
      <h1>Transfer Page</h1>
      <form method="post" action="bank_sample.php">
        <div class="form-group">
          <label for="transfer-from-account-id"
            ><i class="fas fa-user"></i> Transfer From Account ID</label
          >
          <input
            type="text"
            id="transfer-from-account-id"
            name="transfer-from-account-id"
            required
          />
        </div>
        <div class="form-group">
          <label for="transfer-to-account-id"
            ><i class="fas fa-user"></i> Transfer To Account ID</label
          >
          <input
            type="text"
            id="transfer-to-account-id"
            name="transfer-to-account-id"
            required
          />
        </div>
        <div class="form-group">
          <label for="amount"><i class="fas fa-dollar-sign"></i> Amount</label>
          <input
            type="number"
            id="amount"
            name="amount"
            step="0.01"
            required
          />
        </div>
        <div class="form-group">
          <input type="submit" value="Transfer" />
        </div>
      </form>
    </div>
    <div class="footer">
      <p>&copy; 2024 Your Bank. All rights reserved.</p>
    </div>


    <?php
    // Assuming you have a database connection established
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'database_connection.php';
      $transferFromAccountId = $_POST["transfer-from-account-id"];
      $transferToAccountId = $_POST["transfer-to-account-id"];
      $amount = $_POST["amount"];

      // Prepare the SQL query
      $sql = "INSERT INTO bank_deposit (transfer_from_account_id, transfer_to_account_id, amount) VALUES (?, ?, ?)";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("ssd", $transferFromAccountId, $transferToAccountId, $amount);

      // Execute the query
      if ($stmt->execute()) {
        $new_deposit_id = $db->insert_id;
        echo "<script>alert('Transfer successful! transaction id = ".$new_deposit_id."');</script>";
      } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
      }

      // Close the statement
      $stmt->close();
    }
    ?>
  </body>
</html>