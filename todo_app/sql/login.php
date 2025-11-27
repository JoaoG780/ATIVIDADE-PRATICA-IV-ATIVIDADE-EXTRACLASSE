<?php
require_once "../config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: index.php");
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}

include "../includes/header.php";
?>

<div class="container mt-4">
    <h2>Login</h2>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" class="form-control mb-2" placeholder="Email">
        <input type="password" name="password" class="form-control mb-2" placeholder="Senha">
        <button class="btn btn-primary">Entrar</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>