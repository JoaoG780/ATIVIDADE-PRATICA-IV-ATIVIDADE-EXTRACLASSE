<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth_check.php';

$user_id = $_SESSION['user_id'];

$q = trim($_GET['q'] ?? '');
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($q !== '') {
    $sql = "SELECT id, titulo, descricao, concluida, data_criacao
            FROM tarefas
            WHERE usuario_id = :uid
              AND (titulo LIKE :buscar OR descricao LIKE :buscar)
            ORDER BY data_criacao DESC";
    $stmt = $pdo->prepare($sql);
    $like = '%' . $q . '%';
    $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':buscar', $like, PDO::PARAM_STR);
    $stmt->execute();
} elseif ($status === '0' || $status === '1') {
    $sql = "SELECT id, titulo, descricao, concluida, data_criacao
            FROM tarefas
            WHERE usuario_id = :uid
              AND concluida = :status
            ORDER BY data_criacao DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':status', $status, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $sql = "SELECT id, titulo, descricao, concluida, data_criacao
            FROM tarefas
            WHERE usuario_id = :uid
            ORDER BY data_criacao DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}


$tarefas = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="container py-4">
    <h3 class="mb-4">Lista de Tarefas</h3>

    <div class="mb-3 d-flex gap-2">
        <a href="/todo_app/tasks/create_task.php" class="btn btn-success">+ Nova Tarefa</a>

        <form class="d-flex" method="get" style="gap:.5rem;">
            <input type="text" name="q" class="form-control" placeholder="Buscar por título/descrição" value="<?= htmlspecialchars($q) ?>">
            <select name="status" class="form-select">
                <option value="" <?= $status === '' ? 'selected' : '' ?>>Todos</option>
                <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Pendentes</option>
                <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Concluídas</option>
            </select>
            <button class="btn btn-primary" type="submit">Filtrar</button>
            <a class="btn btn-outline-secondary" href="/todo_app/tasks_list.php">Limpar</a>
        </form>
    </div>

    <?php if (empty($tarefas)): ?>
        <div class="alert alert-info">Nenhuma tarefa encontrada.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Criada em</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['titulo']) ?></td>
                        <td><?= htmlspecialchars($t['descricao']) ?></td>
                        <td><?= htmlspecialchars($t['data_criacao']) ?></td>
                        <td>
                            <?php if ($t['concluida']): ?>
                                <span class="badge bg-success">Concluída</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/todo_app/tasks/edit_task.php?id=<?= $t['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="/todo_app/tasks/delete_task.php?id=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Remover tarefa?')">Excluir</a>
                            <a href="/todo_app/tasks/toggle_complete.php?id=<?= $t['id'] ?>" class="btn btn-sm <?= $t['concluida'] ? 'btn-warning' : 'btn-success' ?>">
                                <?= $t['concluida'] ? 'Reabrir' : 'Concluir' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
