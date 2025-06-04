<?php
require 'db.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM patients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['patient_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "No account found";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Patient Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Patient Login</h2>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p><?= $msg ?></p>
</body>
</html>
