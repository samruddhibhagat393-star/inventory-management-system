<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";


// Count Products
$product_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$product_data = mysqli_fetch_assoc($product_query);
$total_products = $product_data['total'];


// Count Suppliers
$supplier_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM suppliers");
$supplier_data = mysqli_fetch_assoc($supplier_query);
$total_suppliers = $supplier_data['total'];


// Calculate Total Stock
$stock_query = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM products");
$stock_data = mysqli_fetch_assoc($stock_query);
$total_stock = $stock_data['total'] ?? 0;


// Count Low Stock Products
$low_stock_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM products
     WHERE quantity <= minimum_stock"
);

$low_stock_data = mysqli_fetch_assoc($low_stock_query);
$low_stock = $low_stock_data['total'];

?>

<!DOCTYPE html>

<html>

<head>

    <title>Inventory Management System - Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        /* Header */

        .header {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 8px 0 0;
        }


        /* Navigation */

        .navbar {
            background: #222;
            padding: 12px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }


        /* Main Container */

        .container {
            width: 90%;
            margin: 30px auto;
        }


        /* Cards */

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background: white;
            width: 220px;
            padding: 25px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 8px #bbb;
        }

        .card h2 {
            margin: 10px 0;
            font-size: 30px;
        }

        .card p {
            margin: 5px;
            color: #555;
        }


        /* Menu */

        .menu {
            margin-top: 35px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .menu a {
            text-decoration: none;
            color: black;
        }

        .menu-card {
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 8px #bbb;
        }

        .menu-card:hover {
            background: #eeeeee;
        }


        /* Low Stock */

        .low-stock {
            color: red;
        }


        /* Logout */

        .logout {
            display: inline-block;
            margin-top: 30px;
            background: red;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

    </style>

</head>


<body>


<!-- Header -->

<div class="header">

    <h1>Inventory Management System</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </p>

</div>


<!-- Navigation -->

<div class="navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="products.php">Products</a>

    <a href="suppliers.php">Suppliers</a>

    <a href="purchases.php">Purchases</a>

    <a href="sales.php">Sales</a>

    <a href="reports.php">Reports</a>

</div>


<!-- Main -->

<div class="container">

    <h2>Dashboard</h2>


    <!-- Statistics -->

    <div class="cards">


        <div class="card">

            <p>Total Products</p>

            <h2>
                <?php echo $total_products; ?>
            </h2>

        </div>


        <div class="card">

            <p>Total Suppliers</p>

            <h2>
                <?php echo $total_suppliers; ?>
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

            <h2 class="low-stock">
                <?php echo $low_stock; ?>
            </h2>

        </div>


    </div>


    <!-- Menu -->

    <div class="menu">


        <a href="products.php">

            <div class="menu-card">

                <h3>📦 Products</h3>

                <p>
                    Add, Edit, Delete and Search Products
                </p>

            </div>

        </a>


        <a href="suppliers.php">

            <div class="menu-card">

                <h3>🚚 Suppliers</h3>

                <p>
                    Manage Supplier Information
                </p>

            </div>

        </a>


        <a href="purchases.php">

            <div class="menu-card">

                <h3>🛒 Purchases</h3>

                <p>
                    Manage Product Purchases
                </p>

            </div>

        </a>


        <a href="sales.php">

            <div class="menu-card">

                <h3>💰 Sales</h3>

                <p>
                    Manage Product Sales
                </p>

            </div>

        </a>


        <a href="reports.php">

            <div class="menu-card">

                <h3>📊 Reports</h3>

                <p>
                    View Inventory Reports
                </p>

            </div>

        </a>


    </div>


    <!-- Logout -->

    <a class="logout" href="logout.php">
        Logout
    </a>


</div>


</body>

</html>