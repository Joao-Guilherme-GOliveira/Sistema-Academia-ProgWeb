<?php
include "conexao.php";

$sql = "SELECT * FROM planos";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Academia</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/planos.css">
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
<section class="planos-container">
    <h1>Planos da Academia</h1>
    <p>Escolha o plano ideal para o seu objetivo.</p>

    <div class="planos-cards">

<?php while ($plano = mysqli_fetch_assoc($result)) { ?>

    <div class="plano-card">
        
        <h2><?php echo $plano['nome_plano']; ?></h2>

        <h3>
            R$ <?php echo number_format($plano['valor'], 2, ',', '.'); ?>/mês
        </h3>

        <ul>
            <?php 
            $itens = explode(".", $plano['descricao']); 
            foreach ($itens as $item) {
                if (trim($item) != "") {
                    echo "<li>" . trim($item) . "</li>";
                }
            }
            ?>
        </ul>

        <button>Assinar Plano</button>

    </div>

<?php } ?>

</div>
</section>
</body>
</html>