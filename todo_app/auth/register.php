<?php

require_once __DIR__ . '/../includes/config.php';
session_start();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$nome = trim($_POST['nome'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';


if (!$nome) $errors[] = 'Nome é obrigatório.';
if (!$email) $errors[] = 'Email inválido.';
if (strlen($senha) < 6) $errors[] = 'Senha deve ter ao menos 6 caracteres.';


if (empty($errors)) {

$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
$errors[] = 'Email já cadastrado.';
} else {
$hash = password_hash($senha, PASSWORD_DEFAULT);
$ins = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
$ins->execute([$nome, $email, $hash]);

$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['user_name'] = $nome;
header('Location: /todo_app/index.php');
exit;
}
}
}


include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container py-4">
<h2>Cadastro</h2>
<?php if ($errors): ?>
<div class="alert alert-danger">
<ul>
<?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?>
</ul>
</div>
<?php endif; ?>
<form method="post" novalidate>
<div class="mb-3">
<label class="form-label">Nome</label>
<input class="form-control" name="nome" value="<?=htmlspecialchars($nome ?? '')?>">
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input class="form-control" type="email" name="email" value="<?=htmlspecialchars($email ?? '')?>">
</div>
<div class="mb-3">
<label class="form-label">Senha</label>
<input class="form-control" type="password" name="senha">
</div>
<button class="btn btn-primary">Cadastrar</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>