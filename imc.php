<?php
session_start();

function calcularIMC($peso, $altura)
{
    return $peso / (($altura / 100) * ($altura / 100));
}

/* Resposta AJAX */
if (isset($_GET['ajax'])) {

    $peso = $_GET['peso'];
    $altura = $_GET['altura'];

    $imc = calcularIMC($peso, $altura);

    echo "Seu IMC é: " . number_format($imc, 2);

    exit;
}

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
        <a href="sair.php" class="sair">Sair</a>
    </nav>
</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Calcule o seu IMC e obtenha sua dieta personalizada.</p>
    </section>

    <div class="imc-container">
        <form class="imc-form">

            <input type="number" id="altura" name="altura" placeholder="Altura(cm)" required>

            <input type="number" id="peso" name="peso" placeholder="Peso(kg)" required>

            <button
                type="button"
                onclick="usaAjax(
                    'imc.php?ajax=1&peso=' + document.getElementById('peso').value +
                    '&altura=' + document.getElementById('altura').value,
                    'resultado'
                )">
                Calcular
            </button>

            <div id="resultado" class="resultado"></div>

        </form>
    </div>

</main>

<script src="ajax.js"></script>

</body>
</html>