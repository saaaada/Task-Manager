<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$task_id = $_GET['id'] ?? null;

if (!$task_id || !is_numeric($task_id)) {
    die("Invalid task ID.");
}

// Confirm the task exists and belongs to the user
$stmt = $con->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Task not found or access denied.");
}

// Delete the task
$stmt = $con->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
$stmt->execute();

// Redirect back
header("Location: dashboard.php");
exit;
?>
