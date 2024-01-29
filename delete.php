<?php
include 'dbconnection.php';

if (!isset($_GET['id'])) {
    echo "No item specified.";
}

$itemId = $_GET['id'];

$deleteStmt = $conn->prepare("DELETE FROM foodts_items WHERE id = ?");
$deleteStmt->execute([$itemId]);

header("Location: admin.php");

?>
