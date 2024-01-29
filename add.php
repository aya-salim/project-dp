<?php
include 'dbconnection.php';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description']; // Added description field
    $imageName = $_FILES['image']['name'];
    $imagePath = 'images/' . $imageName;

    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    $stmt = $conn->prepare("INSERT INTO foodts_items (name, price, quantity, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $quantity, $description, $imagePath]);
    header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add food truck equipment supply Item</title>
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

        textarea {
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
<div class="form-container">
    <h2>Add New Item</h2>
    <form method="post" action="add.php" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Item Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <textarea name="description" placeholder="Item Description" required></textarea> 
        <input type="file" name="image" required>
        <input type="submit" name="add" value="Add Item">
    </form>
</div>

</body>
</html>
