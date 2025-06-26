<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Task Manager</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap 5.3+ CDN (Supports built-in themes) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom Styles -->
  <link rel="stylesheet" href="assets/css/style.css">
  
  <style>
    html, body {
      height: 100%;
    }
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
  </style>
</head>
<body>
<div class="wrapper">
<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">Task Manager</a>
<div class="d-flex align-items-center gap-5">
  <!-- 🌗 Theme Toggle -->
  <button id="themeToggle" class="btn btn-sm btn-outline-secondary">☀️</button>

  <!-- 🔍 Search Form -->
  <form method="GET" action="dashboard.php" class="d-flex" role="search">
    <input
      class="form-control form-control-sm me-2"
      type="search"
      name="search"
      placeholder="Search tasks..."
      value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
      style="max-width: 100; max-height:100"
    >
    <button class="btn btn-sm btn-primary"type="submit">Search</button>
  </form>
</div>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container my-4">
