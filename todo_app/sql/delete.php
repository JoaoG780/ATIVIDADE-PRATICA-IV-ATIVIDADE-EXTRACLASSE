<?php
require_once "../config/auth.php";
require_once "../config/db.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);

header("Location: index.php");
exit();