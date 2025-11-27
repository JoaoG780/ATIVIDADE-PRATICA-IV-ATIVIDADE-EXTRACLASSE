<?php

if (session_status() === PHP_SESSION_NONE) session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container-fluid">
<a class="navbar-brand" href="/todo_app/index.php">To-Do</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">
<?php if (isset($_SESSION['user_id'])): ?>
<li class="nav-item"><a class="nav-link" href="/todo_app/index.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="/todo_app/tasks_list.php">Tarefas</a></li>
<li class="nav-item"><a class="nav-link" href="/todo_app/auth/logout.php">Sair</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="/todo_app/auth/login.php">Login</a></li>
<li class="nav-item"><a class="nav-link" href="/todo_app/auth/register.php">Cadastrar</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</nav>