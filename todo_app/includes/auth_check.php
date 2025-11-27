<?php

session_start();
if (!isset($_SESSION['user_id'])) {
header('Location: /todo_app/auth/login.php');
exit;
}