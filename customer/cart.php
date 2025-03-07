<?php
// customer/cart.php
session_start();
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Your Cart</title>
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">
</head>
<body class=\"container mt-5\">
    <h1>Your Cart</h1>
    <ul id=\"cartList\" class=\"list-group mb-3\"></ul>
    <p><strong>Total: $<span id=\"totalPrice\">0.00</span></strong></p>\n    <button class=\"btn btn-success\" onclick=\"checkout()\">Checkout</button>\n\n    <script>\n        function loadCart() {\n            let cart = JSON.parse(localStorage.getItem('cart')) || [];\n            let cartList = document.getElementById('cartList');\n            let total = 0;\n            cartList.innerHTML = '';\n            cart.forEach((item, index) => {\n                total += parseFloat(item.price);\n                cartList.innerHTML += `<li class=\"list-group-item d-flex justify-content-between align-items-center\">\n                    ${item.name} - $${parseFloat(item.price).toFixed(2)}\n                    <button class=\"btn btn-danger btn-sm\" onclick=\"removeFromCart(${index})\">Remove</button>\n                </li>`;\n            });\n            document.getElementById('totalPrice').textContent = total.toFixed(2);\n        }\n        function removeFromCart(index) {\n            let cart = JSON.parse(localStorage.getItem('cart')) || [];\n            cart.splice(index, 1);\n            localStorage.setItem('cart', JSON.stringify(cart));\n            loadCart();\n        }\n        function checkout() {\n            if(confirm('Proceed with payment?')) {\n                // Simulate payment and order creation\n                alert('Payment confirmed! Order placed.');\n                localStorage.removeItem('cart');\n                window.location.href = 'order_status.php';\n            }\n        }\n        loadCart();\n    </script>\n</body>\n</html>
