<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$sql = "SELECT sales.id,
               sales.sale_date,
               sales.total_amount
        FROM sales
        ORDER BY sales.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Sales Management</title>

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

.btn {
    background: #333;
    color: white;
    padding: 10px 15px;
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

</style>

</head>

<body>

<div class="header">

<h1>Sales Management</h1>

</div>

<div class="container">

<a class="btn" href="dashboard.php">← Dashboard</a>

<a class="btn" href="add_sale.php">+ Add Sale</a>

<br><br>

<table>

<tr>

<th>ID</th>
<th>Sale Date</th>
<th>Total Amount</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['sale_date']; ?></td>

<td>₹ <?php echo $row['total_amount']; ?></td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>