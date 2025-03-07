<?php
// customer/register.php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // In production, hash the password!
    $address = $_POST['address'];
    
    $stmt = $conn->prepare("INSERT INTO customers (name, email, password, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $address);
    $stmt->execute();
    $stmt->close();
    
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Customer Registration</title>
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\">
</head>
<body class=\"container mt-5\">
    <h1>Customer Registration</h1>
    <form method=\"POST\" action=\"register.php\">\n        <div class=\"mb-3\">\n            <input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"Name\" required>\n        </div>\n        <div class=\"mb-3\">\n            <input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"Email\" required>\n        </div>\n        <div class=\"mb-3\">\n            <input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Password\" required>\n        </div>\n        <div class=\"mb-3\">\n            <textarea name=\"address\" class=\"form-control\" placeholder=\"Address\" required></textarea>\n        </div>\n        <button type=\"submit\" class=\"btn btn-primary\">Register</button>\n    </form>\n</body>\n</html>
