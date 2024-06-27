<?php

require_once '../../database_connection.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $stmt = $db->prepare("SELECT * FROM delivery_man WHERE username=? AND user_password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        $_SESSION['user_data'] = $user_data;
        header("Location: homepage.php");
        exit;
    } else {
        echo "<script>
              alert('Username or password is incorrect.');
              </script>";
    }

    $stmt->close();
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../..//css/Login.css">
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
        </form>
        <!-- <p>Forgot your password? <a href="/forgot-password">Click here</a></p> -->
    </div>
</body>
</html>