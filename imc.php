<?php
session_start();

function calcularIMC($peso, $altura)
{
    return $peso / (($altura / 100) * ($altura / 100));
}

function calcularTMB($peso, $altura, $idade, $genero)
{
    if ($genero == "masculino") {
        return (10 * $peso) + (6.25 * $altura) - (5 * $idade) + 5;
    } else {
        return (10 * $peso) + (6.25 * $altura) - (5 * $idade) - 161;
    }
}

function fatorAtividade($atividade)
{
    if ($atividade == "sedentario") {
        return 1.2;
    } elseif ($atividade == "leve") {
        return 1.375;
    } elseif ($atividade == "moderado") {
        return 1.55;
    } elseif ($atividade == "intenso") {
        return 1.725;
    } else {
        return 1.9;
    }
}

function calcularGastoCalorico($tmb, $fator)
{
    return $tmb * $fator;
}

function calcularMetaCalorica($gastoCalorico, $objetivo)
{
    if ($objetivo == "emagrecer") {
        return $gastoCalorico - 500;
    } else {
        return $gastoCalorico + 300;
    }
}

if (isset($_GET['ajax'])) {

    $peso = $_GET['peso'];
    $altura = $_GET['altura'];
    $idade = $_GET['idade'];
    $genero = $_GET['genero'];
    $atividade = $_GET['atividade'];
    $objetivo = $_GET['objetivo'];

    if ($peso == "" || $altura == "" || $idade == "" || $genero == "" || $atividade == "" || $objetivo == "") {
        echo "Preencha todos os campos.";
        exit;
    }

    $imc = calcularIMC($peso, $altura);
    $tmb = calcularTMB($peso, $altura, $idade, $genero);
    $fator = fatorAtividade($atividade);
    $gastoCalorico = calcularGastoCalorico($tmb, $fator);
    $metaCalorica = calcularMetaCalorica($gastoCalorico, $objetivo);
    $proteina = $peso * 1.8;
    $gordura = $peso * 0.9;

    $caloriasProteina = $proteina * 4;
    $caloriasGordura = $gordura * 9;

    $caloriasCarboidrato = $metaCalorica - ($caloriasProteina + $caloriasGordura);
    $carboidrato = $caloriasCarboidrato / 4;

    if ($objetivo == "emagrecer") {
        $textoObjetivo = "Emagrecer";
    } else {
        $textoObjetivo = "Ganhar peso";
    }

    echo "<div class='resultado-dieta'>";

    echo "<h3>Resultados da Avaliação</h3>";

    echo "<strong>IMC:</strong> " . number_format($imc, 2) . "<br>";
    echo "<strong>Taxa Metabólica Basal:</strong> " . number_format($tmb, 0) . " kcal<br>";
    echo "<strong>Gasto Calórico Diário:</strong> " . number_format($gastoCalorico, 0) . " kcal<br>";
    echo "<strong>Objetivo:</strong> " . $textoObjetivo . "<br>";
    echo "<strong>Meta Calórica:</strong> " . number_format($metaCalorica, 0) . " kcal";

    echo "</div>";

    echo "<div class='plano-alimentar'>";

    echo "<h3>Plano Alimentar Recomendado</h3>";

    echo "<p>
    Com base nas informações fornecidas, o sistema calculou uma distribuição diária de macronutrientes para auxiliar no alcance do seu objetivo.
    </p>";

    echo "<div class='macro-item'>";
    echo "<strong>Proteínas:</strong> " . number_format($proteina, 0) . " g<br>";
    echo "<small>Essenciais para saciedade, recuperação e manutenção muscular.</small>";
    echo "</div>";

    echo "<div class='macro-item'>";
    echo "<strong>Gorduras:</strong> " . number_format($gordura, 0) . " g<br>";
    echo "<small>Importantes para produção hormonal e funcionamento adequado do organismo.</small>";
    echo "</div>";

    echo "<div class='macro-item'>";
    echo "<strong>Carboidratos:</strong> " . number_format($carboidrato, 0) . " g<br>";
    echo "<small>Principal fonte de energia para atividades diárias e exercícios físicos.</small>";
    echo "</div>";

    echo "</div>";
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
        <a href="planos.php">Planos</a>
        <a href="relatorio.php">Relatórios</a>
        <a href="sair.php" class="sair">Sair</a>
    </nav>
</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Calcule o seu IMC e obtenha sua dieta personalizada.</p>
    </section>

    <div class="imc-container">
        <h2>Dieta Personalizada</h2>

        <form class="imc-form">

            <input type="number" id="altura" name="altura" placeholder="Altura(cm)" required>

            <input type="number" id="peso" name="peso" placeholder="Peso(kg)" required>

            <input type="number" id="idade" name="idade" placeholder="Idade" required>

            <select id="genero" name="genero" required>
                <option value="">Selecione o gênero</option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
            </select>

            <select id="atividade" name="atividade" required>
                <option value="">Nível de atividade</option>
                <option value="sedentario">Sedentário</option>
                <option value="leve">Leve</option>
                <option value="moderado">Moderado</option>
                <option value="intenso">Intenso</option>
                <option value="muito_intenso">Muito intenso</option>
            </select>

            <select id="objetivo" name="objetivo" required>
                <option value="">Objetivo da Dieta</option>
                <option value="emagrecer">Emagrecer</option>
                <option value="ganhar_peso">Ganhar Peso</option>
            </select>

            <button
                type="button"
                onclick="usaAjax(
                    'imc.php?ajax=1&peso=' + document.getElementById('peso').value +
                    '&altura=' + document.getElementById('altura').value +
                    '&idade=' + document.getElementById('idade').value +
                    '&genero=' + document.getElementById('genero').value +
                    '&atividade=' + document.getElementById('atividade').value +
                    '&objetivo=' + document.getElementById('objetivo').value,
                    'resultado'
                )">
                Calcular Dieta
            </button>

            <div id="resultado" class="resultado"></div>

        </form>
    </div>

</main>

<script src="ajax.js"></script>

</body>
</html>