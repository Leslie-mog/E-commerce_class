<?php
$host = "localhost";
$db_user = "leslie.tettey";
$db_pass = "123456789";
$db_name = "ecommerce_2026A_leslie_tettey";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>