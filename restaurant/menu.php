<?php
// restaurant/menu.php
session_start();
if (!isset($_SESSION['restaurant_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';

$restaurant_id = $_SESSION['restaurant_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];
    $description = $_POST['item_description'];
    
    $stmt = $conn->prepare("INSERT INTO menu_items (restaurant_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $restaurant_id, $name, $description, $price);
    $stmt->execute();
    $stmt->close();
    
    header("Location: dashboard.php");
    exit();
}
?>
