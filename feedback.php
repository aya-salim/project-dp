<?php
session_start();
include 'dbconnection.php';

// if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
//     header("Location: login.php");
// }

$message = '';

if (isset($_POST['submit_feedback'])) {
    $user_id = $_SESSION['user_id'];
    $firstNameFeedback = $_POST['first_name_feedback'];
    $lastNameFeedback = $_POST['last_name_feedback'];
    $emailFeedback = $_POST['email_feedback'];
    $phoneFeedback = $_POST['phone_feedback'];
    $feedbackText = $_POST['feedback'];
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, first_name, last_name, email, phone, rating, comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $firstNameFeedback, $lastNameFeedback, $emailFeedback, $phoneFeedback, $rating, $feedbackText]);

    $message = "Thank you for your feedback and rating!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .feedback-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
        }

        input[type="text"], input[type="email"], input[type="number"], textarea, input[type="submit"]  {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="radio"]{
            display: none; 
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse; 
            justify-content: space-between;
        }

        .star-rating label {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffcc00;
        }


        input[type="submit"] {
            background-color: #1abc9c;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
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
    <div class="feedback-container">
        <h2>Feedback</h2>
        <p class="message"><?php echo $message; ?></p>
        <form method="post" action="feedback.php">
            <input type="text" name="first_name_feedback" placeholder="First Name">
            <input type="text" name="last_name_feedback" placeholder="Last Name">
            <input type="email" name="email_feedback" placeholder="Email">
            <input type="number" name="phone_feedback" placeholder="Phone">
            <textarea name="feedback" placeholder="Feedback or suggestions"></textarea>

            <p>Rate your experience:</p>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" />
                <label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4" />
                <label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3" />
                <label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2" />
                <label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1" />
                <label for="star1">&#9733;</label>
            </div>

            <input type="submit" name="submit_feedback" value="Submit Feedback">
        </form>
    </div>
</body>
</html>
