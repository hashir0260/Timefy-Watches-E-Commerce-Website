<?php
$conn = new mysqli("localhost", "root", "", "timefy");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
