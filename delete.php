<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop_db";

$connection = new mysqli($servername, $username, $password, $database);

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: /myshop/index.php");
    exit;
}

// Handle POST confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: /myshop/index.php");
    exit;
}

// Fetch client info for confirmation display
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

if (!$client) {
    header("Location: /myshop/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            margin-top: 50px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        h2 {
            color: #dc3545;
            margin-bottom: 25px;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete the following client?</p>
    <ul>
        <li><strong>Name:</strong> <?= htmlspecialchars($client['name']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($client['email']) ?></li>
        <li><strong>Phone:</strong> <?= htmlspecialchars($client['phone']) ?></li>
        <li><strong>Address:</strong> <?= htmlspecialchars($client['address']) ?></li>
    </ul>

    <form method="POST">
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
        <a href="/myshop/index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
