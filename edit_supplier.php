<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM suppliers WHERE id=$id"
);

$supplier = mysqli_fetch_assoc($result);

if (isset($_POST['update_supplier'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE suppliers SET
            name='$name',
            contact='$contact',
            email='$email',
            address='$address'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {

        header("Location: suppliers.php");
        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Supplier</title>

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

        input,
        textarea {

            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;

        }

        textarea {
            height: 80px;
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

    <h2>Edit Supplier</h2>

    <form method="POST">

        <input
            type="text"
            name="name"
            value="<?php echo $supplier['name']; ?>"
            required
        >

        <input
            type="text"
            name="contact"
            value="<?php echo $supplier['contact']; ?>"
            required
        >

        <input
            type="email"
            name="email"
            value="<?php echo $supplier['email']; ?>"
            required
        >

        <textarea
            name="address"
            required
        ><?php echo $supplier['address']; ?></textarea>

        <button type="submit" name="update_supplier">
            Update Supplier
        </button>

    </form>

    <br>

    <a href="suppliers.php">
        ← Back to Suppliers
    </a>

</div>

</body>

</html>