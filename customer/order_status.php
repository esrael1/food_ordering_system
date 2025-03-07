<?php
// customer/order_status.php
session_start();
require '../db.php';

// In a real system, fetch orders for the logged-in customer
$query = \"SELECT * FROM orders WHERE customer_id = {$_SESSION['customer_id']} ORDER BY created_at DESC\";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Order Status</title>\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">\n</head>\n<body class=\"container mt-5\">\n    <h1>Your Orders</h1>\n    <table class=\"table table-bordered\">\n        <tr><th>Order ID</th><th>Status</th><th>Total Price</th><th>Secret Code</th></tr>\n        <?php while($order = $result->fetch_assoc()): ?>\n            <tr>\n                <td><?= $order['id'] ?></td>\n                <td><?= $order['status'] ?></td>\n                <td>$<?= $order['total_price'] ?></td>\n                <td><?= $order['secret_code'] ?></td>\n            </tr>\n        <?php endwhile; ?>\n    </table>\n</body>\n</html>\n```

---

## 6. Delivery Worker Panel

### **delivery/dashboard.php**

```php
<?php
// delivery/dashboard.php
session_start();
if (!isset($_SESSION['delivery_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';

// Fetch orders that are ready for delivery
$query = "SELECT * FROM orders WHERE status = 'Ready'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Delivery Dashboard</title>\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">\n</head>\n<body class=\"container mt-5\">\n    <h1>Delivery Worker Dashboard</h1>\n    <h2>Orders Ready for Delivery</h2>\n    <table class=\"table table-bordered\">\n        <tr><th>Order ID</th><th>Restaurant ID</th><th>Total Price</th><th>Actions</th></tr>\n        <?php while($order = $result->fetch_assoc()): ?>\n            <tr>\n                <td><?= $order['id'] ?></td>\n                <td><?= $order['restaurant_id'] ?></td>\n                <td>$<?= $order['total_price'] ?></td>\n                <td><a href=\"confirm_delivery.php?order_id=<?= $order['id'] ?>\" class=\"btn btn-success btn-sm\">Accept & Deliver</a></td>\n            </tr>\n        <?php endwhile; ?>\n    </table>\n    <a href=\"logout.php\" class=\"btn btn-danger\">Logout</a>\n</body>\n</html>\n```

### **delivery/confirm_delivery.php**

```php
<?php
// delivery/confirm_delivery.php
session_start();
if (!isset($_SESSION['delivery_logged_in'])) {
    header('Location: login.php');
    exit();
}
require '../db.php';

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = $_POST['secret_code'];
        // Validate secret code against the order (in a real system, use prepared statements)
        $result = $conn->query(\"SELECT secret_code FROM orders WHERE id = $order_id\");
        $order = $result->fetch_assoc();
        
        if ($order && $order['secret_code'] === $code) {
            $conn->query(\"UPDATE orders SET status = 'Delivered', delivery_worker_id = {$_SESSION['delivery_worker_id']} WHERE id = $order_id\");
            echo \"<script>alert('Delivery confirmed!');window.location.href='dashboard.php';</script>\";\n            exit();\n        } else {\n            $error = \"Invalid secret code. Please try again.\";\n        }\n    }\n} else {\n    header('Location: dashboard.php');\n    exit();\n}\n?>\n<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n    <meta charset=\"UTF-8\">\n    <title>Confirm Delivery</title>\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">\n</head>\n<body class=\"container mt-5\">\n    <h1>Confirm Delivery for Order #<?= $order_id ?></h1>\n    <?php if(isset($error)): ?>\n        <div class=\"alert alert-danger\"><?= $error ?></div>\n    <?php endif; ?>\n    <form method=\"POST\" action=\"\">\n        <div class=\"mb-3\">\n            <input type=\"text\" name=\"secret_code\" class=\"form-control\" placeholder=\"Enter Secret Code\" required>\n        </div>\n        <button type=\"submit\" class=\"btn btn-success\">Confirm Delivery</button>\n    </form>\n</body>\n</html>\n```

---

## 7. Landing Page

### **index.php**

```php
<?php
// index.php - a simple landing page that links to the login/register pages for each role
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Online Food Ordering System</title>\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">\n</head>\n<body class=\"bg-light\">\n    <div class=\"container mt-5 text-center\">\n        <h1>Welcome to the Online Food Ordering System</h1>\n        <p>Select your role to continue:</p>\n        <div class=\"d-grid gap-2 col-6 mx-auto\">\n            <a href=\"admin/dashboard.php\" class=\"btn btn-primary\">Admin</a>\n            <a href=\"restaurant/dashboard.php\" class=\"btn btn-secondary\">Restaurant</a>\n            <a href=\"customer/register.php\" class=\"btn btn-success\">Customer</a>\n            <a href=\"delivery/dashboard.php\" class=\"btn btn-warning\">Delivery Worker</a>\n        </div>\n    </div>\n</body>\n</html>\n```

---

## Final Notes

- **Authentication:**  
  Each panel (admin, restaurant, customer, delivery) should have a login system. The sample above uses PHP sessions (e.g., `$_SESSION['restaurant_logged_in']`). You will need to create `login.php` pages and proper authentication logic (with password hashing).

- **Data Persistence & Security:**  
  Use prepared statements for all database queries. Secure passwords with `password_hash()` and `password_verify()` functions in PHP.

- **Notifications:**  
  For real-time notifications (order acceptance/rejection, delivery confirmation), consider using AJAX or WebSocket techniques.

- **Extensibility:**  
  This skeleton covers the basic flow:
  - Restaurants can add/edit/delete their menus.
  - Customers can register, browse the menu, add to cart, checkout.
  - Restaurants see incoming orders and can accept/reject them.
  - When accepted and marked as ready, delivery workers see orders and can accept deliveries (confirming with a secret code).
  - Admins control the overall system.
  
You can expand each section with additional features, validations, and proper UI/UX enhancements.

---

This should give you a comprehensive starting point for building your complete online food ordering system. Let me know if you need further customization or detailed help with any part!
