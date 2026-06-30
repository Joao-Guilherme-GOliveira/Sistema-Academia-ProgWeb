<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'];
$id_usuario = $_SESSION['id_usuario'];

// Descobre o id_aluno do usuário logado
$sqlAluno = mysqli_query($conn, "SELECT id_aluno FROM alunos WHERE id_usuario=$id_usuario");
$alunoRow = mysqli_fetch_assoc($sqlAluno);

$pagamentos = null;

if ($alunoRow) {
    $id_aluno = $alunoRow['id_aluno'];

    // Pagamentos das assinaturas do aluno, com o nome do plano
    $pagamentos = mysqli_query($conn, "
        SELECT p.valor, p.data_pagamento, p.forma_pagamento, p.status, pl.nome_plano
        FROM pagamentos p
        INNER JOIN assinaturas a ON p.id_assinatura = a.id_assinatura
        INNER JOIN planos pl ON a.id_plano = pl.id_plano
        WHERE a.id_aluno = $id_aluno
        ORDER BY p.data_pagamento DESC
    ");
}

// Formata AAAA-MM-DD para DD/MM/AAAA sem usar date()/strtotime()
function formatarData($data) {
    $partes = explode("-", $data);
    return $partes[2] . "/" . $partes[1] . "/" . $partes[0];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema Academia</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/relatorio.css">
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
        <?php endif; ?>
        <a href="relatorio.php">Relatórios</a>
        <a href="sair.php" class="sair">Sair</a>
    </nav>
</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Confira o histórico de pagamentos da sua assinatura.</p>
    </section>

    <section class="relatorio">

        <h2>Meus Pagamentos</h2>

        <table>
            <tr>
                <th>Plano</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Forma de Pagamento</th>
                <th>Status</th>
            </tr>

            <?php if (!$alunoRow): ?>

                <tr>
                    <td colspan="5">Essa página é exclusiva para alunos. Nenhum cadastro de aluno foi encontrado para o seu usuário.</td>
                </tr>

            <?php elseif (mysqli_num_rows($pagamentos) === 0): ?>

                <tr>
                    <td colspan="5">Nenhum pagamento encontrado para sua assinatura.</td>
                </tr>

            <?php else: ?>

                <?php while ($pg = mysqli_fetch_assoc($pagamentos)): ?>
                    <tr>
                        <td><?= htmlspecialchars($pg['nome_plano']) ?></td>
                        <td>R$ <?= number_format($pg['valor'], 2, ',', '.') ?></td>
                        <td><?= formatarData($pg['data_pagamento']) ?></td>
                        <td><?= htmlspecialchars($pg['forma_pagamento']) ?></td>
                        <td><?= htmlspecialchars($pg['status']) ?></td>
                    </tr>
                <?php endwhile; ?>

            <?php endif; ?>

        </table>

    </section>

</main>

</body>
</html>
<?php mysqli_close($conn); ?>