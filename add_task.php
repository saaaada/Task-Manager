<html lang="en" data-bs-theme="dark">
<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$title = $description = $status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if (empty($title) || empty($description)) {
        $errors[] = "Task title as well as description is required.";
    }
    if (strlen($title) > 100 || strlen($description) > 500) {
        $errors[] = "Maximum lenth limit for title is 100 and description is 500";
    }

    if (empty($errors)) {
        $stmt = $con->prepare("INSERT INTO tasks (user_id, title, description, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['user_id'], $title, $description, $status);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h2>Add New Task</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Done" <?= $status == 'Done' ? 'selected' : '' ?>>Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Task</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
