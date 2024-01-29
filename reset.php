<?php
include 'dbconnection.php';

$message = '';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];

    // if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        // Update password
        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updateStmt->execute([$newPassword, $email]);
        $message = "Password reset successfully.";
    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
            background-color: #4caf50; 
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
<?php include 'navbar.php' ?>
<div class="form-container">
    <h2>Reset Password</h2>
    <p class="message <?php echo $message ? 'success' : 'error'; ?>"><?php echo $message; ?></p>
    <form method="post" action="reset.php">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="newPassword" placeholder="Enter new password" required>
        <input type="submit" name="reset" value="Reset Password">
    </form>
</div>

</body>
</html>
