<?php
// Database connection details
require_once 'database_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    // Validate the form data
    if (empty($fullname) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error_message = "Please fill in all the required fields.";
        echo "<script>alert('$error_message');</script>";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
        echo "<script>alert('$error_message');</script>";
    } else {
        // Check if the email is unique
        $stmt = $db->prepare("SELECT COUNT(*) FROM customer WHERE gmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email_count);
        $stmt->fetch();
        $stmt->close();

        if ($email_count > 0) {
            $error_message = "Email already exists.";
            echo "<script>alert('$error_message');</script>";
        } else {
            // Prepare the SQL query
            $stmt = $db->prepare("INSERT INTO customer (full_name, gmail, phone_number, user_password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $phone, $password);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect the user to the login page or display a success message
                header("Location: /login");
                exit;
            } else {
                $error_message = "Error saving user data: " . $stmt->error;
                echo "<script>alert('$error_message');</script>";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/Signup.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="/delivery-web/login.php">Login here</a></p>
    </div>
</body>
</html>