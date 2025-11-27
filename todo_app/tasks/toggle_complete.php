<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth_check.php';

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: /todo_app/index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("UPDATE tarefas 
                       SET concluida = NOT concluida 
                       WHERE id = ? AND usuario_id = ?");
$stmt->execute([$id, $user_id]);

header("Location: /todo_app/index.php");
exit;
