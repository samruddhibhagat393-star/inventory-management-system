<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$products = mysqli_query($conn, "SELECT * FROM products");

$message = "";

if (isset($_POST['add_sale'])) {

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $sale_date = $_POST['sale_date'];

    // Check product stock
    $stock_query = mysqli_query(
        $conn,
        "SELECT quantity FROM products WHERE id = $product_id"
    );

    $stock_data = mysqli_fetch_assoc($stock_query);

    $available_stock = $stock_data['quantity'];

    if ($quantity > $available_stock) {

        $message = "Not enough stock! Available stock: " . $available_stock;

    } else {

        $total_amount = $quantity * $price;

        // Insert sale
        $sql = "INSERT INTO sales
                (sale_date, total_amount)
                VALUES
                ('$sale_date', '$total_amount')";

        if (mysqli_query($conn, $sql)) {

            $sale_id = mysqli_insert_id($conn);

            // Insert sale item
            $sql2 = "INSERT INTO sale_items
                     (sale_id, product_id, quantity, price)
                     VALUES
                     ('$sale_id', '$product_id', '$quantity', '$price')";

            mysqli_query($conn, $sql2);

            // Decrease stock
            $sql3 = "UPDATE products
                     SET quantity = quantity - $quantity
                     WHERE id = $product_id";

            mysqli_query($conn, $sql3);

            $message = "Sale added successfully! Stock updated.";

        } else {

            $message = "Error: " . mysqli_error($conn);

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Add Sale</title>

<style>

body {
    font-family: Arial;
    background: #f2f2f2;
}

.form-box {
    width: 450px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px #aaa;
}

input, select {
    width: 100%;
    padding: 10px;
    margin: 8px 0 15px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 12px;
    background: #333;
    color: white;
    border: none;
    cursor: pointer;
}

.message {
    text-align: center;
    color: green;
}

.error {
    text-align: center;
    color: red;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Add Sale</h2>

<?php

if (strpos($message, "Not enough") !== false) {

    echo "<p class='error'>$message</p>";

} else {

    echo "<p class='message'>$message</p>";

}

?>

<form method="POST">

<label>Product</label>

<select name="product_id" required>

<option value="">Select Product</option>

<?php

while ($row = mysqli_fetch_assoc($products)) {

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['name']; ?>

- Stock: <?php echo $row['quantity']; ?>

</option>

<?php

}

?>

</select>


<label>Quantity</label>

<input
    type="number"
    name="quantity"
    min="1"
    required
>


<label>Selling Price</label>

<input
    type="number"
    name="price"
    step="0.01"
    min="0"
    required
>


<label>Sale Date</label>

<input
    type="date"
    name="sale_date"
    required
>


<button type="submit" name="add_sale">

Add Sale

</button>

</form>

<br>

<a href="sales.php">← Back to Sales</a>

</div>

</body>

</html>