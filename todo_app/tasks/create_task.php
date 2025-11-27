<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth_check.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);

    if ($titulo !== '') {
        $stmt = $pdo->prepare("INSERT INTO tarefas (usuario_id, titulo, descricao, concluida, data_criacao) 
                               VALUES (?, ?, ?, 0, NOW())");
        $stmt->execute([$user_id, $titulo, $descricao]);
    }

    header("Location: /todo_app/index.php");
    exit;
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-4">
    <h3>Criar nova tarefa</h3>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control"></textarea>
        </div>

        <button class="btn btn-success" type="submit">Salvar</button>
        <a href="/todo_app/index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
