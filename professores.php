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
        <p>Veja os instrutores de nossa academia.</p>
    </section>

    <section class="pesquisa">
        <input
            type="text"
            id="pesquisa"
            placeholder="Pesquisar instrutor">

        <button
            type="button"
            onclick="pesquisarInstrutor()">
            Pesquisar
        </button>
    </section>
    <br>

    <section id="resultadoPesquisa" class="cards">

    </section>

</main>

<script src="ajax.js"></script>

<script>

function pesquisarInstrutor(){

    usaAjax(
        "pesquisar_instrutores.php?nome=" +
        document.getElementById("pesquisa").value,
        "resultadoPesquisa"
    );

}

window.onload = function(){

    pesquisarInstrutor();

}

</script>

</body>
</html>