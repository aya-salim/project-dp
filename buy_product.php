<?php
session_start();
include 'dbconnection.php';


if (!isset($_GET['id'])) {
    echo "Item ID not provided.";
    exit;
}

$itemId = $_GET['id']; 


$stmt = $conn->prepare("SELECT * FROM foodts_items WHERE id = ?");
$stmt->execute([$itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$item) {
    echo "Item not found.";
    exit;
}


$userId = $_SESSION['user_id']; 

if (isset($_POST['purchase'])) {
    
    $totalPrice = $_SESSION['total_price'];

    
    $cardNo = $_POST['cardNo'];
    $cvv = $_POST['cvv'];
    $expiry = $_POST['expiry'];

    
    $userCheckStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
    $userCheckStmt->execute([$userId]);
    $userExists = (int)$userCheckStmt->fetchColumn();

    if ($userExists) {
        
        $orderStmt = $conn->prepare("INSERT INTO orders (user_id, item_id, quantity, total_price, cardNo, cvv, expiry, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $orderStmt->execute([$userId, $itemId, 1, $totalPrice, $cardNo, $cvv, $expiry, 'card']);
        
        
        $orderId = $conn->lastInsertId();
        header("Location: recipt.php?order_id=" . $orderId);
        exit;
    } else {
        
        echo "Error: User does not exist.";
    
        
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Product</title>
    <style>
        .container {
            width: 500px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .payment-fields {
            display: none;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php include 'navbar.php' ?>
<div class="container">
    <form method="post" action="buy_product.php?id=<?php echo htmlspecialchars($itemId); ?>">
        <p>Total Price: OMR <?php echo $_SESSION['total_price']; ?></p>

        <select name="payment_method" id="paymentMethodSelect">
            <option value="">Select Payment Method</option>
            <option value="card">Credit Card</option>
            <option value="phone">Phone Number</option>
        </select>

        <div class="payment-fields" id="cardFields">
            <input type="text" name="cardNo" placeholder="Card Number">
            <input type="text" name="cvv" placeholder="CVV">
            <input type="date" name="expiry" placeholder="Expiry Date">
        </div>

        <div class="payment-fields" id="phoneFields">
            <input type="tel" name="phoneNumber" placeholder="Phone Number">
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentMethodSelect = document.querySelector('#paymentMethodSelect');
                const cardFields = document.querySelector('#cardFields');
                const phoneFields = document.querySelector('#phoneFields');

                paymentMethodSelect.addEventListener('change', function() {
                    if (this.value === 'card') {
                        cardFields.style.display = 'block';
                        phoneFields.style.display = 'none';
                    } else if (this.value === 'phone') {
                        cardFields.style.display = 'none';
                        phoneFields.style.display = 'block';
                    } else {
                        cardFields.style.display = 'none';
                        phoneFields.style.display = 'none';
                    }
                });
            });
        </script>

        <input type="submit" name="purchase" value="Purchase">
    </form>
</div>
</body>
</html>
