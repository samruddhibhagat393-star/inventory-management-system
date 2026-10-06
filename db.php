<?php

echo "PHP IS WORKING!<br>";

$conn = mysqli_connect("localhost", "root", "", "inventory_management");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "DATABASE CONNECTED SUCCESSFULLY!";

?>