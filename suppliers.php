<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$result = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Supplier Management</title>

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

    <h2>Supplier Management</h2>

</div>

<div class="container">

    <a class="add-btn" href="add_supplier.php">
        + Add Supplier
    </a>

    <table>

        <tr>

            <th>ID</th>
            <th>Supplier Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>

        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td>
                <?php echo $row['id']; ?>
            </td>

            <td>
                <?php echo $row['name']; ?>
            </td>

            <td>
                <?php echo $row['contact']; ?>
            </td>

            <td>
                <?php echo $row['email']; ?>
            </td>

            <td>
                <?php echo $row['address']; ?>
            </td>

            <td>

                <a class="edit"
                   href="edit_supplier.php?id=<?php echo $row['id']; ?>">
                    Edit
                </a>

                |

                <a class="delete"
                   href="delete_supplier.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this supplier?');">
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