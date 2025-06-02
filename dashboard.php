<?php
require 'db.php';
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];

// Fetch doctors list
$doctors = $conn->query("SELECT * FROM doctors");

// Message
$msg = isset($_GET['msg']) ? $_GET['msg'] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Welcome to Patient Dashboard</h2>
    <p><a href="logout.php">Logout</a></p>

    <?php if ($msg): ?>
        <p style="color: green"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <h3>Available Doctors</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Speciality</th>
            <th>Book Appointment</th>
        </tr>
        <?php while ($row = $doctors->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['speciality']) ?></td>
                <td>
                    <form method="POST" action="book_appointment.php">
                        <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
                        <label>Date:</label>
                        <input type="date" name="date" required>
                        <label>Time:</label>
                        <input type="time" name="time" required>
                        <button type="submit">Book</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
