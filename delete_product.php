<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: products.php");
    exit();
} else {
    echo "Error deleting product: " . mysqli_error($conn);
}

?>