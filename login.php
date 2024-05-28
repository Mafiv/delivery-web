<?php

require_once 'database_connection.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $stmt = $db->prepare("SELECT id FROM customer WHERE gmail=? and user_password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: index.php");
        exit;
        /*
        // $stmt->bind_result($id, $plain_text_password);
        // $stmt->fetch();
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
*/
    $stmt->close();
$user_name = $username;
}
else{
    header("Location: upload_item.php");
    exit;

}}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/Login.css">
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
        <p>Don't have an account? <a href="/delivery-web/Signup.php">Register here</a></p>  
    </div>
</body>
</html>
