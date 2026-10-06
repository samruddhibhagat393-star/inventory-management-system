<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$message = "";

if (isset($_POST['add_supplier'])) {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO suppliers
            (name, contact, email, address)
            VALUES
            ('$name', '$contact', '$email', '$address')";

    if (mysqli_query($conn, $sql)) {

        $message = "Supplier added successfully!";

    } else {

        $message = "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Supplier</title>

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
            background: green;
            color: white;
            border: none;
            cursor: pointer;

        }

        .message {
            color: green;
            text-align: center;
        }

    </style>

</head>

<body>

<div class="box">

    <h2>Add Supplier</h2>

    <p class="message">
        <?php echo $message; ?>
    </p>

    <form method="POST">

        <input
            type="text"
            name="name"
            placeholder="Supplier Name"
            required
        >

        <input
            type="text"
            name="contact"
            placeholder="Contact Number"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <textarea
            name="address"
            placeholder="Address"
            required
        ></textarea>

        <button type="submit" name="add_supplier">
            Add Supplier
        </button>

    </form>

    <br>

    <a href="suppliers.php">
        ← Back to Suppliers
    </a>

</div>

</body>

</html>