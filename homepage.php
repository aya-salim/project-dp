<?php
include 'dbconnection.php';
include 'navbar.php'; 

$stmt = $conn->query("SELECT * FROM foodts_items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT users.name AS user_name, AVG(feedback.rating) AS avg_rating
                      FROM feedback
                      JOIN users ON feedback.user_id = users.id
                      GROUP BY users.id");
$userRatings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Food Truck Equipment Supply Store</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .welcome-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .welcome-title {
            font-size: 80px;
            font-weight: bold;
            color: #ff3366;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .company-overview {
            font-size: 24px;
            color: #343a40;
            margin-top: 10px;
        }

        .join-us-link {
            color: #ff3366;
            font-size: 20px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            border-bottom: 2px solid #ff3366;
            transition: border-bottom 0.3s ease-in-out;
        }

        .join-us-link:hover {
            border-bottom: 2px solid #343a40;
            color: #343a40;
        }

        .rating-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .user-rating {
            font-size: 28px;
            color: #ff3366;
            margin-right: 5px;
        }

        .reviews-title {
            font-size: 28px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }

        .review-item {
            margin-bottom: 20px;
        }

        .background-image {
            max-width: 80%;
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="welcome-container">
            <h1 class="welcome-title">Welcome to Our Food Truck Equipment Supply Store!</h1>
            <img src="images/food3.png" alt="Food Truck" class="background-image">
            <p class="company-overview">We are a company that contributes to helping simple business owners.</p>
            <a href="register.php" class="join-us-link">JOIN US</a>
        </div>

        <div class="rating-container">
            <h2 class="reviews-title">Customer Reviews</h2>
            <div class="row">
                <?php foreach ($userRatings as $userRating): ?>
                    <div class="col-md-4 review-item">
                        <p class="mb-2"><?php echo $userRating['user_name']; ?>'s Rating:</p>
                        <?php
                        $rating = number_format($userRating['avg_rating'], 1);
                        $fullStars = (int) $rating;
                        $halfStar = ceil(($rating - $fullStars) * 2);
                        $emptyStars = 5 - $fullStars - $halfStar;
                        ?>
                        <?php for ($i = 0; $i < $fullStars; $i++): ?>
                            <i class="fas fa-star user-rating"></i>
                        <?php endfor; ?>
                        <?php if ($halfStar): ?>
                            <i class="fas fa-star-half-alt user-rating"></i>
                        <?php endif; ?>
                        <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                            <i class="far fa-star user-rating"></i>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
