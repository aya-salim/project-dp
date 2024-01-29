<?php
session_start();
include 'dbconnection.php';

if (!isset($_GET['order_id'])) {
    echo "No order specified.";
    exit;
}

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("SELECT orders.*, users.name, users.email, users.address, foodts_items.name AS item_name, foodts_items.price 
                        FROM orders 
                        JOIN users ON orders.user_id = users.id 
                        JOIN foodts_items ON orders.item_id = foodts_items.id 
                        WHERE orders.order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e6e6e6;
            padding: 20px;
        }

        .receipt-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .receipt-header img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-details {
            margin-bottom: 20px;
        }

        .receipt-details p {
            margin: 5px 0;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
            color: #28a745; /* لون الأخضر */
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="images/receipt.png" alt="Receipt Header Image">
            <h2>Order Receipt</h2>
            <p>Order ID: <?php echo $order['order_id']; ?></p>
        </div>

        <div class="receipt-details">
            <h3>Customer Information:</h3>
            <p>Name: <?php echo $order['name']; ?></p>
            <p>Email: <?php echo $order['email']; ?></p>
            <p>Address: <?php echo $order['address']; ?></p>
        </div>

        <div class="receipt-details">
            <h3>Order Details:</h3>
            <p>Item: <?php echo $order['item_name']; ?></p>
            <p>Price: OMR <?php echo $order['price']; ?></p>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Total Price: OMR <?php echo $order['total_price']; ?></p>
        </div>

        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
