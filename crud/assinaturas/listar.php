<?php
session_start();
include "../../conexao.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SESSION['tipo_usuario'] != "admin") {
    header("Location: ../../index.php");
    exit;
}

$sql = "SELECT
            a.id_assinatura,
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
        ORDER BY a.id_assinatura DESC";

$resultado = mysqli_query($conn, $sql);


function formatarData($data) {
    $partes = explode("-", $data);
    return $partes[2] . "/" . $partes[1] . "/" . $partes[0];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Assinaturas</title>
<link rel="stylesheet" href="../../css/crud.css">
</head>
<body>

    <div class="container">

        <h1>Gerenciamento de Assinaturas</h1>

        <a href="cadastrar.php" class="btn btn-add">Nova Assinatura</a>

        <?php if (isset($_GET['erro'])): ?>
            <p style="color:red; text-align:center; margin-top:15px;"><?= htmlspecialchars($_GET['erro']) ?></p>
        <?php endif; ?>

        <br><br>

        <table>

        <tr>
            <th>ID</th>
            <th>Aluno</th>
            <th>Plano</th>
            <th>Início</th>
            <th>Fim</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php if (mysqli_num_rows($resultado) > 0): ?>

            <?php while ($assinatura = mysqli_fetch_assoc($resultado)) { ?>

            <tr>
                <td><?= $assinatura['id_assinatura'] ?></td>
                <td><?= htmlspecialchars($assinatura['aluno']) ?></td>
                <td><?= htmlspecialchars($assinatura['plano']) ?></td>
                <td><?= formatarData($assinatura['data_inicio']) ?></td>
                <td><?= formatarData($assinatura['data_fim']) ?></td>
                <td><?= htmlspecialchars($assinatura['status']) ?></td>
                <td>
                    <a class="btn btn-edit" href="editar.php?id=<?= $assinatura['id_assinatura'] ?>">Editar</a>
                    <a class="btn btn-delete" href="excluir.php?id=<?= $assinatura['id_assinatura'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta assinatura?');">Excluir</a>
                </td>
            </tr>

            <?php } ?>

        <?php else: ?>

            <tr>
                <td colspan="7">Nenhuma assinatura cadastrada.</td>
            </tr>

        <?php endif; ?>

        </table>

        <br>

        <a href="../admin.php" class="btn btn-back">Voltar</a>

    </div>

</body>
</html>
<?php mysqli_close($conn); ?>