<?php 
$con = new mysqli("localhost","root","","task_manager");
if ($con->connect_error) {
    die("Connection error". $con->connect_error);
}

// 2. Create database if not exists
$dbName = "task_manager";
$con->query("CREATE DATABASE IF NOT EXISTS `$dbName`");

// 3. Select the newly created or existing database
$con->select_db($dbName);

// 4. Create `users` table
$con->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// 5. Create `tasks` table
$con->query("
    CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        status ENUM('Pending', 'Completed') DEFAULT 'Pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");
?>
