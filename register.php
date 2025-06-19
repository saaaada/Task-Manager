<?php
require_once 'includes/db.php';
// $errors = [];

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name     = $_POST['name'];
//     $email    = $_POST['email'];
//     $password = $_POST['password'];
//     $confirm  = $_POST['confirm'];

//     // Validation
//     if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
//         $errors[] = "All fields are required.";
//     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors[] = "Invalid email format.";
//     } elseif ($password !== $confirm) {
//         $errors[] = "Passwords do not match.";
//     } else {
//         // Check if user already exists
//         $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
//         $stmt->bind_param("s", $email);
//         $stmt->execute();
//         $stmt->store_result();

//         if ($stmt->num_rows > 0) {
//             $errors[] = "Email already exists.";
//         } else {
//             // Hash password and insert
//             $hashed = password_hash($password, PASSWORD_DEFAULT);
//             $stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
//             $stmt->bind_param("sss", $name, $email, $hashed);
//             if ($stmt->execute()) {
//                 header("Location: login.php");
//                 exit;
//             } else {
//                 $errors[] = "Registration failed. Try again.";
//             }
//         }
//         $stmt->close();
//     }
// }
?>
<?php
$error = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $Confirm_Password = $_POST['confirm'];
    if (empty($Name) || empty($Email) || empty($Password) || empty($Confirm_Password)) {
        $error[] = "One of the fields is empty";
    } elseif ($Password !== $Confirm_Password) {
        $error[] = "The Password not matches";
    } else {
        $stmt = $con->prepare("SELECT Id FROM `users` WHERE  Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error[] = "Email already Exists";
        } else {
            $Password_hash = password_hash($Password, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO `users` (Name,Email,Password) VALUES (?,?,?)");
            $stmt->bind_param("sss", $Name, $Email, $Password_hash);
            if ($stmt->execute()) {
             header("Location: login.php");
       
                exit;
            } else {
                $error[] = "You not regester Due to some reason";
            }
            
        }

    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Register</h2>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php foreach ($error as $e): ?>
                <div><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Confirm Password</label>
            <input type="password" name="confirm" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Already have an account?</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>