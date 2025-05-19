<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop_db";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: /myshop/index.php");
    exit;
}

$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

if (!$client) {
    die("Client not found!");
}

$name = $client["name"];
$email = $client["email"];
$phone = $client["phone"];
$address = $client["address"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $phone   = $_POST["phone"];
    $address = $_POST["address"];

    $sql = "UPDATE clients SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    if ($stmt->execute()) {
        header("Location: /myshop/index.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Client</title>
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
            color: #333;
            margin-bottom: 25px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Client</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>">
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/myshop/index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
