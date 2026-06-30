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

$treinos = [];

if ($alunoRow) {
    $id_aluno = $alunoRow['id_aluno'];

    // Treinos do aluno, com o nome do instrutor responsável
    $sqlTreinos = mysqli_query($conn, "
        SELECT t.id_treino, t.nome AS nome_treino, t.objetivo, u.nome AS instrutor
        FROM treinos t
        INNER JOIN instrutores i ON t.id_instrutor = i.id_instrutor
        INNER JOIN usuarios u ON i.id_usuario = u.id_usuario
        WHERE t.id_aluno = $id_aluno
        ORDER BY t.id_treino DESC
    ");

    while ($treino = mysqli_fetch_assoc($sqlTreinos)) {
        // Exercícios de cada treino
        $sqlExercicios = mysqli_query($conn, "
            SELECT e.nome_exercicio, e.series, e.repeticoes, e.descricao
            FROM treino_exercicios te
            INNER JOIN exercicios e ON te.id_exercicio = e.id_exercicio
            WHERE te.id_treino = " . $treino['id_treino']
        );

        $exercicios = [];
        while ($ex = mysqli_fetch_assoc($sqlExercicios)) {
            $exercicios[] = $ex;
        }

        $treino['exercicios'] = $exercicios;
        $treinos[] = $treino;
    }
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
        <p>Confira os treinos montados pelo seu instrutor.</p>
    </section>

    <?php if (!$alunoRow): ?>

        <section class="relatorio">
            <p>Essa página é exclusiva para alunos. Nenhum cadastro de aluno foi encontrado para o seu usuário.</p>
        </section>

    <?php elseif (count($treinos) === 0): ?>

        <section class="relatorio">
            <p>Você ainda não possui nenhum treino cadastrado. Fale com um instrutor!</p>
        </section>

    <?php else: ?>

        <?php foreach ($treinos as $treino): ?>

        <section class="relatorio">

            <h2><?= htmlspecialchars($treino['nome_treino']) ?></h2>
            <p style="text-align:center; margin-bottom:15px; color:#555;">
                <strong>Objetivo:</strong> <?= htmlspecialchars($treino['objetivo']) ?>
                &nbsp;|&nbsp;
                <strong>Instrutor:</strong> <?= htmlspecialchars($treino['instrutor']) ?>
            </p>

            <table>
                <tr>
                    <th>Exercício</th>
                    <th>Séries</th>
                    <th>Repetições</th>
                    <th>Observações</th>
                </tr>

                <?php if (count($treino['exercicios']) === 0): ?>
                    <tr>
                        <td colspan="4">Nenhum exercício adicionado a este treino ainda.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($treino['exercicios'] as $ex): ?>
                        <tr>
                            <td><?= htmlspecialchars($ex['nome_exercicio']) ?></td>
                            <td><?= htmlspecialchars($ex['series']) ?></td>
                            <td><?= htmlspecialchars($ex['repeticoes']) ?></td>
                            <td><?= htmlspecialchars($ex['descricao']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </table>

        </section>

        <?php endforeach; ?>

    <?php endif; ?>

</main>

</body>
</html>
<?php mysqli_close($conn); ?>