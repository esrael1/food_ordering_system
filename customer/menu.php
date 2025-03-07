<?php
// customer/menu.php
session_start();
require '../db.php';

// Fetch all menu items joined with restaurant information
$query = "SELECT mi.*, r.name AS restaurant_name FROM menu_items mi JOIN restaurants r ON mi.restaurant_id = r.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Menu</title>
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">
</head>
<body class=\"container mt-5\">
    <h1>Food Menu</h1>
    <div class=\"row\">\n        <?php while($item = $result->fetch_assoc()): ?>\n            <div class=\"col-md-4 mb-3\">\n                <div class=\"card\">\n                    <div class=\"card-body\">\n                        <h5 class=\"card-title\"><?= $item['name'] ?></h5>\n                        <p class=\"card-text\">Price: $<?= number_format($item['price'],2) ?></p>\n                        <p class=\"card-text\"><small>Restaurant: <?= $item['restaurant_name'] ?></small></p>\n                        <button class=\"btn btn-primary\" onclick=\"addToCart(<?= $item['id'] ?>, '<?= $item['name'] ?>', <?= $item['price'] ?>)\">Add to Cart</button>\n                    </div>\n                </div>\n            </div>\n        <?php endwhile; ?>\n    </div>\n\n    <script>\n        // Simple cart management using localStorage\n        function addToCart(id, name, price) {\n            let cart = JSON.parse(localStorage.getItem('cart')) || [];\n            cart.push({id, name, price});\n            localStorage.setItem('cart', JSON.stringify(cart));\n            alert(name + ' added to cart!');\n        }\n    </script>\n</body>\n</html>
