<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['is_admin'])) {
    header("Location: adminlogin.php");
    exit;
}

$stmt = $conn->query("SELECT orders.*, users.name as user_name
                      FROM orders 
                      JOIN users ON orders.user_id = users.id");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
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
    <h2>All Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Item(s)</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Order Date</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['user_name']; ?></td>
                <td><?php
                    // Fetch all items for the current order
                    $orderItemsStmt = $conn->prepare("SELECT foodts_items.name AS item_name 
                                                     FROM orders 
                                                     JOIN foodts_items ON orders.item_id = foodts_items.id 
                                                     WHERE orders.order_id = ?");
                    $orderItemsStmt->execute([$order['order_id']]);
                    $orderItems = $orderItemsStmt->fetchAll(PDO::FETCH_ASSOC);
                    echo implode(', ', array_column($orderItems, 'item_name'));
                ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td>$<?php echo $order['total_price']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
