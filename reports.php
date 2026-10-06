<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

/* Total Products */
$query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$data = mysqli_fetch_assoc($query);
$total_products = $data['total'];

/* Total Stock */
$query = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM products");
$data = mysqli_fetch_assoc($query);
$total_stock = $data['total'] ?? 0;

/* Low Stock */
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM products
     WHERE quantity <= minimum_stock"
);

$data = mysqli_fetch_assoc($query);
$low_stock = $data['total'];

/* Total Purchase */
$query = mysqli_query(
    $conn,
    "SELECT SUM(total_amount) AS total FROM purchases"
);

$data = mysqli_fetch_assoc($query);
$total_purchase = $data['total'] ?? 0;

/* Total Sales */
$query = mysqli_query(
    $conn,
    "SELECT SUM(total_amount) AS total FROM sales"
);

$data = mysqli_fetch_assoc($query);
$total_sales = $data['total'] ?? 0;

/* Purchase Report */
$purchase_report = mysqli_query(
    $conn,
    "SELECT purchases.id,
            suppliers.name AS supplier_name,
            purchases.purchase_date,
            purchases.total_amount
     FROM purchases
     LEFT JOIN suppliers
     ON purchases.supplier_id = suppliers.id
     ORDER BY purchases.id DESC"
);

/* Sales Report */
$sales_report = mysqli_query(
    $conn,
    "SELECT sales.id,
            sales.sale_date,
            sales.total_amount
     FROM sales
     ORDER BY sales.id DESC"
);

/* Low Stock Report */
$low_stock_report = mysqli_query(
    $conn,
    "SELECT *
     FROM products
     WHERE quantity <= minimum_stock
     ORDER BY quantity ASC"
);

?>

<!DOCTYPE html>

<html>

<head>

<title>Inventory Reports</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f2f2f2;
}

.header {
    background: #333;
    color: white;
    padding: 20px;
    text-align: center;
}

.container {
    width: 90%;
    margin: 30px auto;
}

.btn {
    display: inline-block;
    background: #333;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}

.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 25px;
}

.card {
    background: white;
    width: 200px;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 0 8px #bbb;
}

.card h2 {
    font-size: 28px;
    margin: 10px 0;
}

.card p {
    color: #555;
}

.report-box {
    background: white;
    padding: 20px;
    margin-top: 30px;
    border-radius: 10px;
    box-shadow: 0 0 8px #bbb;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #333;
    color: white;
}

.low {
    color: red;
    font-weight: bold;
}

</style>

</head>

<body>

<div class="header">

<h1>Inventory Management System</h1>

<h2>Reports</h2>

</div>

<div class="container">

<a class="btn" href="dashboard.php">
← Back to Dashboard
</a>

<!-- Summary -->

<div class="cards">

<div class="card">

<p>Total Products</p>

<h2>
<?php echo $total_products; ?>
</h2>

</div>


<div class="card">

<p>Total Stock</p>

<h2>
<?php echo $total_stock; ?>
</h2>

</div>


<div class="card">

<p>Low Stock Products</p>

<h2 class="low">
<?php echo $low_stock; ?>
</h2>

</div>


<div class="card">

<p>Total Purchases</p>

<h2>
₹ <?php echo number_format($total_purchase, 2); ?>
</h2>

</div>


<div class="card">

<p>Total Sales</p>

<h2>
₹ <?php echo number_format($total_sales, 2); ?>
</h2>

</div>

</div>


<!-- Purchase Report -->

<div class="report-box">

<h2>Purchase Report</h2>

<table>

<tr>

<th>ID</th>
<th>Supplier</th>
<th>Purchase Date</th>
<th>Total Amount</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($purchase_report)) {

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['supplier_name']; ?>
</td>

<td>
<?php echo $row['purchase_date']; ?>
</td>

<td>
₹ <?php echo number_format($row['total_amount'], 2); ?>
</td>

</tr>

<?php

}

?>

</table>

</div>


<!-- Sales Report -->

<div class="report-box">

<h2>Sales Report</h2>

<table>

<tr>

<th>ID</th>
<th>Sale Date</th>
<th>Total Amount</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($sales_report)) {

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['sale_date']; ?>
</td>

<td>
₹ <?php echo number_format($row['total_amount'], 2); ?>
</td>

</tr>

<?php

}

?>

</table>

</div>


<!-- Low Stock Report -->

<div class="report-box">

<h2>Low Stock Report</h2>

<table>

<tr>

<th>ID</th>
<th>Product</th>
<th>Category</th>
<th>Current Stock</th>
<th>Minimum Stock</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($low_stock_report)) {

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['category']; ?>
</td>

<td class="low">
<?php echo $row['quantity']; ?>
</td>

<td>
<?php echo $row['minimum_stock']; ?>
</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</body>

</html>