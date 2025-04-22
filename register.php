<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUE(?,?,?)");
    $stmt->bind_param("sss",$username, $email, $password);

    if($stmt->execute()) {
        echo "<script>alert('Registeration susccessful!');</script>";
    } else {
        echo "<script>alert('Error registering user!');</script>";
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Login-form -->
    <div class="register">
        <div class="form-register">
            <h1>Register</h1>
            <form action="register.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email">
                <label for="name">Username</label>
                <input type="text" name="name" id="name" placeholder="Username">
                <label for="">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">
                <!-- <label for="">Confirm-password</label>
                <input type="comfirm-password" name="comfirm-password" placeholder="Comfirm-password"> -->
                <p>Already have an account? <a href="index.php">Login</a></p>
                <center>
                <button type="submit">Register</button>
                </center>
            </form>
           
        </div>
        <div class="register-image">

        </div>
    </div>
</body>
</html>