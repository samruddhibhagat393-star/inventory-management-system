<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if (isset($_POST['update_product'])) {

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $minimum_stock = $_POST['minimum_stock'];

    $sql = "UPDATE products SET
            name='$name',
            category='$category',
            price='$price',
            quantity='$quantity',
            minimum_stock='$minimum_stock'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>

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
            background: blue;
            color: white;
            border: none;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Edit Product</h2>

    <form method="POST">

        <input
            type="text"
            name="name"
            value="<?php echo $product['name']; ?>"
            required
        >

        <input
            type="text"
            name="category"
            value="<?php echo $product['category']; ?>"
            required
        >

        <input
            type="number"
            step="0.01"
            name="price"
            value="<?php echo $product['price']; ?>"
            required
        >

        <input
            type="number"
            name="quantity"
            value="<?php echo $product['quantity']; ?>"
            required
        >

        <input
            type="number"
            name="minimum_stock"
            value="<?php echo $product['minimum_stock']; ?>"
            required
        >

        <button type="submit" name="update_product">
            Update Product
        </button>

    </form>

    <br>

    <a href="products.php">← Back to Products</a>

</div>

</body>

</html>