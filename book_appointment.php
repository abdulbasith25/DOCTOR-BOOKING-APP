<?php
require 'db.php';
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=Appointment+Booked+Successfully");
    } else {
        header("Location: dashboard.php?msg=Failed+to+book+appointment");
    }
    exit;
}
?>
