<?php
 admin/dashboard.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';

$restaurantsResult = $conn->query("SELECT * FROM restaurants");
$deliveryResult = $conn->query("SELECT * FROM delivery_workers");
$orderResult = $conn->query("SELECT * FROM orders");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Admin Dashboard</h1>
    
    <h2>Registered Restaurants</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Address</th></tr>
        <?php while($row = $restaurantsResult->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['address'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    
    <h2>Registered Delivery Workers</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>
        <?php while($row = $deliveryResult->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>All Orders</h2>
    <table class="table table-bordered">
        <tr><th>Order ID</th><th>Customer ID</th><th>Restaurant ID</th><th>Status</th><th>Total Price</th></tr>
        <?php while($row = $orderResult->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['customer_id'] ?></td>
                <td><?= $row['restaurant_id'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>$<?= $row['total_price'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    
    <a href="logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
