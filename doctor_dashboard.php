<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

// Get doctor's name from session
$doctorName = $_SESSION['doctor_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome, Dr. <?php echo htmlspecialchars($doctorName); ?> 👨‍⚕️</h1>
    <p>You have successfully logged into your dashboard.</p>
    <a class="logout-btn" href="logout.php">Logout</a>
</div>
</body>
</html>
