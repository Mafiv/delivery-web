<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $plain_text_password);
        $stmt->fetch();
        
        // Verify password
        if ($password === $plain_text_password) {
            // Password is correct, redirect to profile-view.php with the username parameter
            // header("Location: profile-view.php?username=" . urlencode($username));
            header("Location: HomePage_Signin.php?username=" . urlencode($username));
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Username does not exist.";
    }

    $stmt->close();
$user_name = $username;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">

            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
        <!-- <p>Forgot your password? <a href="/forgot-password">Click here</a></p> -->
        <p>Don't have an account? <a href="Signup.html">Register here</a></p>  
    </div>
</body>
</html>
