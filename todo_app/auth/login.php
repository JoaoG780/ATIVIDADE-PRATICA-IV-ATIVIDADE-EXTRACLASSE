<?php

require_once __DIR__ . '/../includes/config.php';
session_start();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';


if (!$email) $errors[] = 'Email inválido.';
if (!$senha) $errors[] = 'Senha é obrigatória.';


if (empty($errors)) {
$stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();
if ($user && password_verify($senha, $user['senha'])) {
// login OK
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nome'];
header('Location: /todo_app/index.php');
exit;
} else {
$errors[] = 'Credenciais inválidas.';
}
}
}


include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container py-4">
<h2>Login</h2>
<?php if ($errors): ?>
<div class="alert alert-danger">
<ul>
<?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?>
</ul>
</div>
<?php endif; ?>
<form method="post">
<div class="mb-3">
<label class="form-label">Email</label>
<input class="form-control" type="email" name="email" value="<?=htmlspecialchars($email ?? '')?>">
</div>
<div class="mb-3">
<label class="form-label">Senha</label>
<input class="form-control" type="password" name="senha">
</div>
<button class="btn btn-primary">Entrar</button>
</form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>