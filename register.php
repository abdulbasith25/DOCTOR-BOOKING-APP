<?php
require 'db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM patients WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO patients (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $msg = "Registration successful. <a href='login.php'>Login now</a>";
        } else {
            $msg = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Patient Registration</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>
    <p><?= $msg ?></p>
</body>
</html>
