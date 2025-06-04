<?php
require 'db.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM doctors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $doctor = $res->fetch_assoc();
        if ($password === $doctor['password']) { // plaintext for now
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $row['name'];
            header("Location: doctor_dashboard.php");
            exit;
        } else {
            echo "Wrong password";
        }
    } else {
        echo "Doctor not found";
    }
}
?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">

</head>
<body>
<form method="POST">
    <h2>Doctor Login</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
