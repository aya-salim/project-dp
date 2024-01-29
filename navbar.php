<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>food truck equipment supply Store</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #ff6f61; 
        }

        .navbar-custom a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar-custom a:hover {
            background-color: #ff9275; 
        }
    </style>
</head>
<body>

<div class="navbar navbar-custom">
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php">The products</a>
        <a href="profile.php">Profile</a>
        <a href="orders.php">My Orders</a>
        <a href="cart.php">My Carts</a>
        <a href="feedback.php">Feedback</a>
        <a href="logout.php">Logout</a>
    <?php elseif (!empty($_SESSION['is_admin'])): ?>
        <a href="admin.php">Admin Dashboard</a>
        <a href="add.php">Add food truck equipment supply</a>
        <a href="view_orders.php">View Orders</a>
        <a href="userrev.php">Customer Review</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="homepage.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="adminlogin.php">Admin Panel</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
