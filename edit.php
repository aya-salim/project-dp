<?php
include 'dbconnection.php';

if (!isset($_GET['id'])) {
    echo "No item specified.";

}

$itemId = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM foodts_items WHERE id = ?");
$stmt->execute([$itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Item not found.";

}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $updateStmt = $conn->prepare("UPDATE foodts_items SET name = ?, price = ?, quantity = ? WHERE id = ?");
    $updateStmt->execute([$name, $price, $quantity, $itemId]);

    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit food truck equipment supply Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
        }

        input[type="text"], input[type="number"], input[type="file"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
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
<div>
    <h2>Edit food truck equipment supply Item</h2>
    <form method="post" action="edit.php?id=<?php echo $itemId; ?>">
        <input type="text" name="name" value="<?php echo $item['name']; ?>" required>
        <input type="number" name="price" value="<?php echo $item['price']; ?>" required>
        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required>
        <input type="submit" name="update" value="Update Item">
    </form>
</div>

</body>
</html>
