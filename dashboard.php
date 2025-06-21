<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'includes/db.php';
$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'includes/header.php'; ?>

<h2 class="mb-4">Welcome, <?= $_SESSION['user_name'] ?> </h2>

<a href="add_task.php" class="btn btn-success mb-3">+ Add New Task</a>

<?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th><th>Description</th><th>Status</th><th>Created</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($task = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= $task['status'] ?></td>
                    <td><?= $task['created_at'] ?></td>
                    <td>
                        <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No tasks yet. Add one!</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
