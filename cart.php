<?php
session_start();
include 'dbconnection.php';
include 'navbar.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
}

$cartItemIds = $_SESSION['cart'];

$cartStmt = $conn->prepare("SELECT * FROM foodts_items WHERE id IN (" . implode(',', $cartItemIds) . ")");
$cartStmt->execute();
$cartItems = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['total_price'] = array_sum(array_column($cartItems, 'price'));

if (isset($_POST['delete'])) {
    $itemIdToDelete = $_POST['delete'];

    $_SESSION['cart'] = array_values(array_diff($cartItemIds, [$itemIdToDelete]));

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .total-row {
            font-weight: bold;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $cartItem): ?>
                    <tr>
                        <td><?php echo $cartItem['name']; ?></td>
                        <td>OMR <?php echo $cartItem['price']; ?></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <button type="submit" class="btn btn-delete" name="delete" value="<?php echo $cartItem['id']; ?>">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>Total</td>
                    <td>OMR <?php echo isset($_SESSION['total_price']) ? $_SESSION['total_price'] : '0.00'; ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <a href="buy_product.php?id=<?php echo htmlspecialchars($cartItems[0]['id']); ?>" class="btn btn-primary">Checkout</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
