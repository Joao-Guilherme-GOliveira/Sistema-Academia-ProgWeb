<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema Academia</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>

<header>
    <div class="logo-area">
        <img src="imagens/logobranco.png" alt="Logo">
        <h2>Sistema Academia</h2>
    </div>

     <nav class="navbar">
        <a href="index.php">Início</a>
        <a href="professores.php">Instrutores</a>
        <a href="imc.php">Dieta Personalizada</a>
        <a href="planos.php">Planos</a>
        <?php if ($_SESSION['tipo_usuario'] == 'admin'): ?>
            <a href="crud/admin.php" class="admin-link">Admin</a>
            <a href="relatorio.php" class="admin-link">Relatorios</a>
        <?php endif; ?>
        <a href="sair.php" class="sair">Sair</a>
    </nav>
</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Acesse as funcionalidades da sua academia.</p>
    </section>

    <section class="cards">

        <a href="treinos.php" class="card">
            <h3>Ver Treinos</h3>
            <p>Visualize opções de treinos.</p>
        </a>

        <a href="professores.php" class="card">
            <h3>Instrutores</h3>
            <p>Consulte os instrututores da nossa academia.</p>
        </a>

        <a href="planos.php" class="card">
            <h3>Planos</h3>
            <p>Consulte nossos planos.</p>
        </a>

        <a href="pagamentos.php" class="card">
            <h3>Pagamentos</h3>
            <p>Consulte mensalidades e histórico.</p>
        </a>

        <a href="imc.php" class="card">
            <h3>Avaliação Física</h3>
            <p>Calcule seu IMC e veja sua dieta.</p>
        </a>

    </section>

</main>

</body>
</html>