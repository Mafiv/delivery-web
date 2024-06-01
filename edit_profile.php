<?php
// Database connection details
session_start();
require_once 'database_connection.php';
$user_data = $_SESSION['user_data'];
$user_id = $user_data['id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];
    $file_name = $_FILES["add_image"]["name"];

    // Validate the form data
    if (empty($fullname) || empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($file_name)) {
        $error_message = "Please fill in all the required fields.";
        echo "<script>alert('$error_message');</script>";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
        echo "<script>alert('$error_message');</script>";
    } else {
        // Prepare the SQL query
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);
        if (move_uploaded_file($_FILES["add_image"]["tmp_name"], $target_file)) {
            $image_url = "/uploads/" . $file_name . "?v=" . time();
            $stmt = $db->prepare("UPDATE customer SET full_name = ?, gmail = ?, phone_number = ?, user_password = ?, image_url = ? WHERE id = ?");
            $stmt->bind_param("ssssss", $fullname, $email, $phone, $password, $image_url, $user_id);
        } else {
            $error_message = "Error uploading the image.";
            echo "<script>alert('$error_message');</script>";
        }

        // Execute the query
        if ($stmt->execute()) {
            // Pass the user data and image URL to the homepage.php file
            $_SESSION['user_data']['image_url'] = $image_url;
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Error saving user data: " . $stmt->error;
            echo "<script>alert('$error_message');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<!-- HTML code for the update form -->
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/Signup.css">
</head>
<body>
    <div class="container">
        <h1>Update Profile</h1>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
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

            <label for="add_image">Add profile image:</label>
            <input type="file" id="add_image" name="add_image" required>

            <input type="submit" value="update profile">
        </form>
    </div>
</body>
</html>