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
    <a class="navbar-brand fw-bold" href="index.php">Task Manager</a>

    <div class="d-flex align-items-center">
      <!-- Theme Toggle Switch -->
<button id="themeToggle" class="btn btn-sm btn-outline-secondary">
  ☀️
</button>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
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
