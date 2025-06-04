<?php
require 'db.php';
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor name (if needed)
$doctor_name = $_SESSION['doctor_name'] ?? "";

// Fetch today's appointments for this doctor
$stmt = $conn->prepare("SELECT a.*, p.name AS patient_name 
                        FROM appointments a 
                        JOIN patients p ON a.patient_id = p.id 
                        WHERE a.doctor_id = ? AND a.appointment_date = CURDATE() 
                        ORDER BY a.token_number ASC");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Welcome, Dr. <?= htmlspecialchars($doctor_name) ?> 👨‍⚕️</h2>
    <p>You have successfully logged into your dashboard.</p>
    <p><a href="logout.php">Logout</a></p>

    <h3>Today's Appointments</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Token</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>

        <?php if ($appointments->num_rows > 0): ?>
            <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['token_number'] ?></td>
                    <td><?= htmlspecialchars($row['patient_name']) ?></td>
                    <td><?= $row['appointment_date'] ?></td>
                    <td><?= $row['appointment_time'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No appointments for today.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
