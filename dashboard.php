<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (required for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    require_once 'includes/db.php';
$user_id = $_SESSION['user_id'];
$search = $_GET['search'] ?? '';

if ($search) {
    // Search by title or description (case-insensitive)
    $stmt = $con->prepare("SELECT * FROM tasks WHERE user_id = ? AND (title LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("sss", $user_id, $like, $like);
} else {
    // Show all tasks
    $stmt = $con->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
}

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
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars(substr($task['title'], 0, 20)) ?>...</td>
                        <td><?= htmlspecialchars(substr($task['description'], 0, 30)) ?> ...</td>
                        <td><?= $task['status'] ?></td>
                        <td><?= $task['created_at'] ?></td>
                        <td>
                            <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            <!-- View Button -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#taskModal<?= $task['id'] ?>">
                                View
                            </button>

                            <!-- modal -->
                            <div class="modal fade" id="taskModal<?= $task['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?= htmlspecialchars($task['title']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Status:</strong> <?= $task['status'] ?></p>
                                            <p><strong>Created at:</strong> <?= $task['created_at'] ?></p>
                                            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($task['description'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else: ?>
        <div class="alert alert-info">No tasks yet. Add one!</div>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>