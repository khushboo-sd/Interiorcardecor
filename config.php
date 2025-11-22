<?php

$servername = "localhost"; // Change if needed
$dbusername = "root"; // Change if needed
$dbpassword = ""; // Change if needed
$dbname = "bookstoredb"; // Change to your DB name

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    echo ("Connection failed: " . $conn->connect_error);
    exit();
}
?>