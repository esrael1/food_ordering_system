<?php
// restaurant/dashboard.php
session_start();
if (!isset($_SESSION['restaurant_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';
$restaurant_id = $_SESSION['restaurant_id'];
$orderResult = $conn->query("SELECT * FROM orders WHERE restaurant_id = $restaurant_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Restaurant Dashboard</h1>
    <h2>Manage Menu</h2>
    <form action="menu.php" method="POST" class="mb-4">
        <div class="mb-3">
            <input type="text" name="item_name" class="form-control" placeholder="Item Name" required>
        </div>
        <div class="mb-3">
            <input type="number" name="item_price" step="0.01" class="form-control" placeholder="Price" required>
        </div>
        <textarea name="item_description" class="form-control mb-3" placeholder="Description"></textarea>
        <button type="submit" class="btn btn-success">Add Menu Item</button>
    </form>
    
    <h2>Incoming Orders</h2>
    <table class="table table-bordered">
        <tr><th>Order ID</th><th>Customer ID</th><th>Status</th><th>Total Price</th><th>Actions</th></tr>
        <?php while($order = $orderResult->fetch_assoc()): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['customer_id'] ?></td>
                <td><?= $order['status'] ?></td>
                <td>$<?= $order['total_price'] ?></td>
                <td>
                    <?php if($order['status'] == 'Pending'): ?>
                        <a href="orders.php?action=accept&id=<?= $order['id'] ?>" class="btn btn-success btn-sm">Accept</a>
                        <a href="orders.php?action=reject&id=<?= $order['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                    <?php elseif($order['status'] == 'Accepted'): ?>
                        <a href="orders.php?action=ready&id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">Ready to Deliver</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
