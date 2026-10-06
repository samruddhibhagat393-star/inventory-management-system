<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$suppliers = mysqli_query($conn, "SELECT * FROM suppliers");
$products = mysqli_query($conn, "SELECT * FROM products");

$message = "";

if (isset($_POST['add_purchase'])) {

    $supplier_id = $_POST['supplier_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $purchase_date = $_POST['purchase_date'];

    $total_amount = $quantity * $price;

    // Insert purchase
    $sql = "INSERT INTO purchases
            (supplier_id, purchase_date, total_amount)
            VALUES
            ('$supplier_id', '$purchase_date', '$total_amount')";

    if (mysqli_query($conn, $sql)) {

        $purchase_id = mysqli_insert_id($conn);

        // Insert purchase item
        $sql2 = "INSERT INTO purchase_items
                 (purchase_id, product_id, quantity, price)
                 VALUES
                 ('$purchase_id', '$product_id', '$quantity', '$price')";

        mysqli_query($conn, $sql2);

        // Increase product stock
        $sql3 = "UPDATE products
                 SET quantity = quantity + $quantity
                 WHERE id = $product_id";

        mysqli_query($conn, $sql3);

        $message = "Purchase added successfully!";

    } else {

        $message = "Error: " . mysqli_error($conn);

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Add Purchase</title>

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

.success {
    color: green;
    text-align: center;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Add Purchase</h2>

<p class="success">
<?php echo $message; ?>
</p>

<form method="POST">

<label>Supplier</label>

<select name="supplier_id" required>

<option value="">Select Supplier</option>

<?php

while ($row = mysqli_fetch_assoc($suppliers)) {

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['name']; ?>

</option>

<?php

}

?>

</select>


<label>Product</label>

<select name="product_id" required>

<option value="">Select Product</option>

<?php

while ($row = mysqli_fetch_assoc($products)) {

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['name']; ?>

</option>

<?php

}

?>

</select>


<label>Quantity</label>

<input type="number" name="quantity" min="1" required>


<label>Purchase Price</label>

<input type="number" name="price" step="0.01" min="0" required>


<label>Purchase Date</label>

<input type="date" name="purchase_date" required>


<button type="submit" name="add_purchase">

Add Purchase

</button>

</form>

<br>

<a href="purchases.php">← Back to Purchases</a>

</div>

</body>

</html>