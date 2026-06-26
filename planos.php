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

        <div class="plano-card bronze">
            <h2>Plano Bronze</h2>
            <h3>R$ 69,90/mês</h3>
            <ul>
                <li>Acesso à musculação</li>
                <li>Avaliação física inicial</li>
                <li>Treino personalizado</li>
                <li>Uso dos equipamentos</li>
            </ul>
            <button>Assinar Plano</button>
        </div>

        <div class="plano-card prata">
            <h2>Plano Prata</h2>
            <h3>R$ 99,90/mês</h3>
            <ul>
                <li>Tudo do Plano Bronze</li>
                <li>Aulas coletivas</li>
                <li>Reavaliação mensal</li>
                <li>Suporte com instrutores</li>
            </ul>
            <button>Assinar Plano</button>
        </div>

        <div class="plano-card ouro">
            <h2>Plano Ouro</h2>
            <h3>R$ 149,90/mês</h3>
            <ul>
                <li>Tudo do Plano Prata</li>
                <li>Dieta personalizada</li>
                <li>Acesso ilimitado</li>
                <li>Prioridade no atendimento</li>
            </ul>
            <button>Assinar Plano</button>
        </div>

    </div>
</section>
</body>
</html>