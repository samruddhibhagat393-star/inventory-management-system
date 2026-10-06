<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$sql = "SELECT purchases.id,
               purchases.purchase_date,
               purchases.total_amount,
               suppliers.name AS supplier_name
        FROM purchases
        LEFT JOIN suppliers
        ON purchases.supplier_id = suppliers.id
        ORDER BY purchases.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Purchase Management</title>

<style>

body {
    font-family: Arial;
    background: #f2f2f2;
    margin: 0;
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

button, .btn {
    background: #333;
    color: white;
    padding: 10px 15px;
    border: none;
    text-decoration: none;
    border-radius: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #333;
    color: white;
}

a {
    text-decoration: none;
}

</style>

</head>

<body>

<div class="header">

<h1>Purchase Management</h1>

</div>

<div class="container">

<a class="btn" href="dashboard.php">← Dashboard</a>

<a class="btn" href="add_purchase.php">+ Add Purchase</a>

<br><br>

<table>

<tr>

<th>ID</th>
<th>Supplier</th>
<th>Purchase Date</th>
<th>Total Amount</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['supplier_name']; ?></td>

<td><?php echo $row['purchase_date']; ?></td>

<td>₹ <?php echo $row['total_amount']; ?></td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>