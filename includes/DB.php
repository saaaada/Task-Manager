<?php 
$con = new mysqli("localhost","root","","task_manager");
if ($con->connect_error) {
    die("Connection error". $con->connect_error);
}
?>
