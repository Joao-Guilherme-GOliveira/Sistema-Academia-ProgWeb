<?php
session_start();

include "conexao.php";
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['tipo_usuario'] != "admin") {
    header("Location: ../index.php");
    exit;
}

$nome = $_SESSION['nome'];



if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

$sql = "SELECT
            u.nome AS aluno,
            p.nome_plano AS plano,
            a.data_inicio,
            a.data_fim,
            a.status
        FROM assinaturas a
        INNER JOIN alunos al
            ON a.id_aluno = al.id_aluno
        INNER JOIN usuarios u
            ON al.id_usuario = u.id_usuario
        INNER JOIN planos p
            ON a.id_plano = p.id_plano
        ORDER BY u.nome";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Assinaturas</title>

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
        <?php if ($_SESSION['tipo_usuario'] == 'admin'): ?>
            <a href="relatorio.php" class="admin-link">Relatorios</a>
        <?php endif; ?>
        <a href="sair.php" class="sair">Sair</a>
    </nav>

</header>

<main>

    <section class="boas-vindas">
        <h1>Bem-vindo, <?php echo $nome; ?>!</h1>
        <p>Relatório de Assinaturas</p>
    </section>

    <section class="relatorio">

        <h2>Assinaturas Cadastradas</h2>

        <table>

            <tr>
                <th>Aluno</th>
                <th>Plano</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Status</th>
            </tr>

            <?php

            if(mysqli_num_rows($resultado)>0){

                while($linha = mysqli_fetch_assoc($resultado)){

                    echo "<tr>";

                    echo "<td>".$linha["aluno"]."</td>";

                    echo "<td>".$linha["plano"]."</td>";

                    echo "<td>".$linha["data_inicio"]."</td>";

                    echo "<td>".$linha["data_fim"]."</td>";

                    echo "<td>".$linha["status"]."</td>";

                    echo "</tr>";

                }

            }else{

                echo "<tr>";
                echo "<td colspan='5'>Nenhuma assinatura cadastrada.</td>";
                echo "</tr>";

            }

            ?>

        </table>

    </section>

</main>

</body>
</html>

<?php
mysqli_close($conn);
?>