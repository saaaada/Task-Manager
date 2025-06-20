<?php
require_once 'includes/db.php';
session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    } else {
        // Check if user exists
        $stmt = $con->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashed);
            $stmt->fetch();

            if (password_verify($password, $hashed)) {
                // Correct login: start session
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;

                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "Email not found.";
        }

        $stmt->close();
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-link">Don't have an account?</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
