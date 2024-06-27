<?php
// Database connection details
require_once 'database_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    // Check if a file was uploaded
    if (isset($_FILES["add_image"]) && $_FILES["add_image"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["add_image"];
        $file_name = $file["name"];
        $file_tmp = $file["tmp_name"];
        $file_destination = "uploads/" . $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp, $file_destination)) {
            // File upload successful
            $timestamp = time(); // Get the current timestamp
            $image_url = "/uploads/" . $file_name . "?v=" . $timestamp;
        } else {
            $error_message = "Error uploading the file.";
            echo "<script>alert('$error_message');</script>";
            return;
        }
    } else {
        $image_url = null; // Set a default value if no file was uploaded
    }

    // Validate the form data
    if (empty($fullname) || empty($username) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error_message = "Please fill in all the required fields.";
        echo "<script>alert('$error_message');</script>";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
        echo "<script>alert('$error_message');</script>";
    } else {
        // Check if the username is unique
        $stmt = $db->prepare("SELECT COUNT(*) FROM customer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($username_count);
        $stmt->fetch();
        $stmt->close();

        if ($username_count > 0) {
            $error_message = "username already exists.";
            echo "<script>alert('$error_message');</script>";
        } else {
            // Prepare the SQL query
            $stmt = $db->prepare("INSERT INTO customer (full_name, username, phone_number, user_password, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $username, $phone, $password, $image_url);

            // Execute the query
            if ($stmt->execute()) {
                // Pass the user data to the homepage.php file
                header("Location: index.php");
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
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="username">username:</label>
            <input type="username" id="username" name="username" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <label for="add_image">Add profile image:</label>
            <input type="file" id="add_image" name="add_image" required>

            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="/delivery-web/index.php">Login here</a></p>
    </div>
</body>
</html>