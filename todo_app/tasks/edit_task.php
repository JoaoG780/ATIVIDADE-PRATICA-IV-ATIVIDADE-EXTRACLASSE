<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth_check.php';

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: /todo_app/index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?");
$stmt->execute([$id, $user_id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    header("Location: /todo_app/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);

    if ($titulo !== '') {
        $stmt = $pdo->prepare("UPDATE tarefas SET titulo = ?, descricao = ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$titulo, $descricao, $id, $user_id]);
    }

    header("Location: /todo_app/index.php");
    exit;
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-4">
    <h3>Editar tarefa</h3>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Salvar alterações</button>
        <a href="/todo_app/index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
