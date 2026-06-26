<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['tipo_usuario'] != "admin") {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
<header>
<div class="logo-area">
        <img src="../imagens/logobranco.png" alt="Logo">
        <h2>Sistema Academia</h2>
    </div>
<nav class="navbar">
        <a href="../index.php">Início</a>
        <a href="../sair.php" class="sair">Sair</a>
    </nav>
</header>
<div class="container">

<h1>Painel de Admins</h1>

<div class="admin-grid">

    <a href="planos/listar.php" class="admin-card">
        <h2>Planos</h2>
        <p>Gerenciar planos da academia.</p>
    </a>

</div>

</div>

</body>
</html>