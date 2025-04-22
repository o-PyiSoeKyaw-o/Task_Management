<?php
include('db.php');
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare( "SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if($stmt->num_rows > 0 && password_verify($password,$hashed_password)) {
    $_SESSION['admin_logged_in'] = true;
    header('Location: dashboard.php');
    exit();}
    else {
        echo "<script>alert('Invalid email or password');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Login-form -->
    <div class="login">
        <div class="form-login">
            <h1>Login</h1>
            <form action="index.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password">
                <p>Don't have an account? <a href="register.php">Register</a></p>
                <center>
                <button type="submit">Login</button>
                </center>
            </form>
            
        </div>
        <div class="login-image">

        </div>
    </div>
</body>
</html>