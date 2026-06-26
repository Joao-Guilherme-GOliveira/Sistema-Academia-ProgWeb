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
        <a href="sair.php" class="sair">Sair</a>
    </nav>
</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Veja os instrutores de nossa academia.</p>
    </section>

    <section class="cards">

        <a class="card">
            <h3>João Silva</h3>
            <p>CREF: 123456-G/ES</p>
            <p>Telefone: (27) 98765-4321</p>
            <p>Especialidade: Musculação</p>
        </a>

        <a class="card">
            <h3>Pedro Costa</h3>
            <p>CREF: 567890-G/ES</p>
            <p>Telefone: (27) 94321-0987</p>
            <p>Especialidade: Cross Training</p>
        </a>

        <a class="card">
            <h3>Ana Santos</h3>
            <p>CREF: 456789-G/ES</p>
            <p>Telefone: (27) 95432-1098</p>
            <p>Especialidade: Alongamento</p>
        </a>

        <a class="card">
            <h3>Maria Souza</h3>
            <p>CREF: 234567-G/ES</p>
            <p>Telefone: (27) 97654-3210</p>
            <p>Especialidade: Hipertrofia</p>
        </a>

        <a class="card">
            <h3>Carlos Oliveira</h3>
            <p>CREF: 345678-G/ES</p>
            <p>Telefone: (27) 96543-2109</p>
            <p>Especialidade: Cross Training</p>
        </a>

    </section>

</main>

</body>
</html>