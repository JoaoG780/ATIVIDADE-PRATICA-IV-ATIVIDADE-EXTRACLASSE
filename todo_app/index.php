<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth_check.php';
$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare('SELECT COUNT(*) AS total_pendentes FROM tarefas WHERE usuario_id = ? AND concluida = 0');
$stmt->execute([$user_id]);
$pendentes = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) AS total_concluidas FROM tarefas WHERE usuario_id = ? AND concluida = 1');
$stmt->execute([$user_id]);
$concluidas = $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT id, titulo, descricao, data_criacao FROM tarefas WHERE usuario_id = ? AND concluida = 0 ORDER BY data_criacao ASC');
$stmt->execute([$user_id]);
$lista_pendentes = $stmt->fetchAll();


include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="container py-4">
<h2>Bem-vindo, <?=htmlspecialchars($_SESSION['user_name'])?></h2>


<div class="row">
<div class="col-lg-6">
<div class="card mb-4">
<div class="card-body">
<h5 class="card-title">Progresso</h5>
<canvas 
    id="statusChart"
    data-pendentes="<?= $pendentes ?>"
    data-concluidas="<?= $concluidas ?>"
    width="400"
    height="200">
</canvas>

</div>
</div>
</div>


<div class="col-lg-6">
<div class="card mb-4">
<div class="card-body">
<h5 class="card-title">Ações</h5>
<a href="/todo_app/tasks/create_task.php" class="btn btn-success mb-2">Nova Tarefa</a>
<a href="/todo_app/tasks_list.php" class="btn btn-secondary mb-2">Ver todas as tarefas</a>
</div>
</div>
</div>
</div>


<h4>Tarefas pendentes</h4>

<?php if (empty($lista_pendentes)): ?>
    <div class="alert alert-info">Nenhuma tarefa pendente.</div>
<?php else: ?>
    <ul class="list-group mb-4">
        <?php foreach ($lista_pendentes as $tarefa): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($tarefa['titulo']) ?></strong><br>
                <small><?= htmlspecialchars($tarefa['descricao'] ?? '') ?></small><br>
                <small>Criada em: <?= htmlspecialchars($tarefa['data_criacao']) ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/main.js"></script>