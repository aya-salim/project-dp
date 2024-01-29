<?php
session_start();
include 'dbconnection.php';


$stmt = $conn->prepare("SELECT * FROM feedback");
$stmt->execute();
$feedbackData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Ratings - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php' ?>
    
    <div class="table-container">
        <h2>User Ratings - Admin</h2>
        
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbackData as $feedback) : ?>
                    <tr>
                        <td><?php echo $feedback['first_name'] . ' ' . $feedback['last_name']; ?></td>
                        <td><?php echo $feedback['rating']; ?></td>
                        <td><?php echo $feedback['comments']; ?></td>
                        <td><?php echo $feedback['feedback_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
