<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT * FROM products
        WHERE name LIKE '%$search%'
        OR category LIKE '%$search%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Products</title>

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
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .add-btn {
            display: inline-block;
            background: green;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #333;
            color: white;
        }

        .edit {
            color: blue;
        }

        .delete {
            color: red;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
        }
    </style>

</head>

<body>

<div class="header">

    <h1>Inventory Management System</h1>

    <h2>Product Management</h2>

</div>

<div class="container">

    <a class="add-btn" href="add_product.php">
        + Add Product
    </a>
    <form method="GET">

    <input
        type="text"
        name="search"
        placeholder="Search product..."
        value="<?php echo $search; ?>"
    >

    <button type="submit">
        Search
    </button>

</form>

<br>

    <table>

        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Minimum Stock</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td><?php echo $row['name']; ?></td>

            <td><?php echo $row['category']; ?></td>

            <td>₹<?php echo $row['price']; ?></td>

            <td>

<?php

if ($row['quantity'] <= $row['minimum_stock']) {

    echo "<span style='color:red; font-weight:bold;'>
          LOW STOCK
          </span>";

} else {

    echo $row['quantity'];

}

?>

</td>

            <td><?php echo $row['minimum_stock']; ?></td>

            <td>

                <a class="edit"
                   href="edit_product.php?id=<?php echo $row['id']; ?>">
                   Edit
                </a>

                |

                <a class="delete"
                   href="delete_product.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this product?');">
                   Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

    <a class="back" href="dashboard.php">
        ← Back to Dashboard
    </a>

</div>

</body>

</html>