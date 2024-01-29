<?php
session_start();

$message = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if ($email == "admin@gmail.com" && $password == "admin") {
        $_SESSION['is_admin'] = "admin";
        header("Location: admin.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
        }

        input[type="email"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            background-color: #1abc9c;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #16a085;
        }

        .message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="form-container">
        <h2>Admin Login</h2>
        <p class="message"><?php echo $message; ?></p>
        <form method="post" action="adminlogin.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        
    </div>

</body>
</html>
