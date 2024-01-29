<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if (isset($_GET['cancel_order_id'])) {
    $cancelOrderId = $_GET['cancel_order_id'];
    $deleteStmt = $conn->prepare("DELETE FROM orders WHERE order_id = ? AND user_id = ?");
    $deleteStmt->execute([$cancelOrderId, $userId]);
}

$stmt = $conn->prepare("SELECT orders.*, foodts_items.name AS item_name 
                        FROM orders 
                        JOIN foodts_items ON orders.item_id = foodts_items.id 
                        WHERE orders.user_id = ?");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table th, .orders-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .orders-table th {
            background-color: #4caf50;
            color: white;
        }

        .cancel-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .cancel-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<?php include 'navbar.php' ?>
<h2>My Orders</h2>

<table class="orders-table">
    <tr>
        <th>Order ID</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Action</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo $order['item_name']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td>OMR <?php echo $order['total_price']; ?></td>
            <td>
                <a href="orders.php?cancel_order_id=<?php echo $order['order_id']; ?>" class="cancel-button">Cancel</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
