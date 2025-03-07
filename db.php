<?php
// db.php
$host = 'localhost';
$user = 'root';
$password = ''; // your MySQL password
$dbname = 'food_ordering_system';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
