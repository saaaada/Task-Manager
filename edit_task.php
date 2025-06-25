<html lang="en" data-bs-theme="dark">
<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$task_id = $_GET['id'] ?? null;

if (!$task_id || !is_numeric($task_id)) {
    die("Invalid task ID.");
}

// 1. Fetch the task from DB
$stmt = $con->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    die("Task not found or not authorized.");
}

// Set default form values
$title = $task['title'];
$description = $task['description'];
$status = $task['status'];

// 2. Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if (empty($title)) {
        $errors[] = "Title is required.";
    }

    if (empty($errors)) {
        $stmt = $con->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sssii", $title, $description, $status, $task_id, $_SESSION['user_id']);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Task</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Done" <?= $status == 'Done' ? 'selected' : '' ?>>Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
