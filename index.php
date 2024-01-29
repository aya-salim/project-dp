<?php
session_start();
include 'dbconnection.php';
include 'navbar.php';

$stmt = $conn->query("SELECT * FROM foodts_items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['id'])) {
    $itemId = $_GET['id'];
    $_SESSION['cart'][] = $itemId;
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>food truck equipment supply Store</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background-color: #f8f8f8;
        }

        .btn-buy {
            background-color: #1abc9c;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div>
        <div class="container mt-4">
            <div class="jumbotron">
                <h1 class="display-4">Welcome to Our food truck equipment supply Store!</h1>
                <p class="lead">Explore our wide range of products and find everything you need for your food truck equipment.</p>
            </div>

            <div class="row card-container">
                <?php foreach ($items as $item): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?php echo $item['image_url']; ?>" class="card-img-top" alt="<?php echo $item['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text"><?php echo $item['description']; ?></p>
                                <p class="card-text">OMR <?php echo $item['price']; ?></p>
                                <!-- Modify the link to add the item to the cart -->
                                <a href="index.php?action=add_to_cart&id=<?php echo $item['id']; ?>" class="btn btn-buy">Add to Cart</a>
                            </div>
                        </div>
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
