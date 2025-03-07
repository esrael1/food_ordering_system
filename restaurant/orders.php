<?php
// restaurant/orders.php
session_start();
if (!isset($_SESSION['restaurant_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';

$restaurant_id = $_SESSION['restaurant_id'];

if (isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $action = $_GET['action'];
    
    if ($action == 'accept') {
        $conn->query("UPDATE orders SET status = 'Accepted' WHERE id = $order_id AND restaurant_id = $restaurant_id");
    } elseif ($action == 'reject') {
        // In a real system, you would capture the rejection reason
        $conn->query("UPDATE orders SET status = 'Rejected' WHERE id = $order_id AND restaurant_id = $restaurant_id");
    } elseif ($action == 'ready') {
        $conn->query("UPDATE orders SET status = 'Ready' WHERE id = $order_id AND restaurant_id = $restaurant_id");
    }
    
    header("Location: dashboard.php");
    exit();
}
?>
