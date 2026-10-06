<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$message = "";

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $minimum_stock = $_POST['minimum_stock'];

    $sql = "INSERT INTO products
            (name, category, price, quantity, minimum_stock)
            VALUES
            ('$name', '$category', '$price', '$quantity', '$minimum_stock')";

    if (mysqli_query($conn, $sql)) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Product</title>

    <style>

        body {
            font-family: Arial;
            background: #f2f2f2;
        }

        .box {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        .message {
            color: green;
            text-align: center;
        }

    </style>

</head>

<body>

<div class="box">

    <h2>Add Product</h2>

    <p class="message">
        <?php echo $message; ?>
    </p>

    <form method="POST">

        <input
            type="text"
            name="name"
            placeholder="Product Name"
            required
        >

        <input
            type="text"
            name="category"
            placeholder="Category"
            required
        >

        <input
            type="number"
            step="0.01"
            name="price"
            placeholder="Price"
            required
        >

        <input
            type="number"
            name="quantity"
            placeholder="Quantity"
            required
        >

        <input
            type="number"
            name="minimum_stock"
            placeholder="Minimum Stock"
            required
        >

        <button type="submit" name="add_product">
            Add Product
        </button>

    </form>

    <br>

    <a href="products.php">← Back to Products</a>

</div>

</body>

</html>