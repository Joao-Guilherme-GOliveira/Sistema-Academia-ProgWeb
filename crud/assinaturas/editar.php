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

$id=$_GET['id'];
$erro = "";

$sql = mysqli_query($conn, "SELECT * FROM assinaturas WHERE id_assinatura=$id");
$assinatura = mysqli_fetch_assoc($sql);

if (!$assinatura) {
    header("Location: listar.php");
    exit;
}

if (isset($_POST['editar'])) {

    $id_aluno    = $_POST['id_aluno'];
    $id_plano    = $_POST['id_plano'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim    = $_POST['data_fim'];
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    if ($id_aluno === 0 || $id_plano === 0 || $data_inicio === "" || $data_fim === "") {
        $erro = "Preencha todos os campos!";
    } elseif ($data_fim < $data_inicio) {
        $erro = "A data fim não pode ser anterior à data de início!";
    } else {
        $sqlUpdate = "UPDATE assinaturas SET
                        id_aluno='$id_aluno',
                        id_plano='$id_plano',
                        data_inicio='$data_inicio',
                        data_fim='$data_fim',
                        status='$status'
                      WHERE id_assinatura=$id";

        if (mysqli_query($conn, $sqlUpdate)) {
            header("Location: listar.php");
            exit;
        } else {
            $erro = "Erro ao atualizar: " . mysqli_error($conn);
        }
    }

    // mantém os dados digitados na tela em caso de erro
    $assinatura['id_aluno']    = $id_aluno;
    $assinatura['id_plano']    = $id_plano;
    $assinatura['data_inicio'] = $data_inicio;
    $assinatura['data_fim']    = $data_fim;
    $assinatura['status']      = $status;
}

$alunos = mysqli_query($conn, "
    SELECT al.id_aluno, u.nome
    FROM alunos al
    INNER JOIN usuarios u ON al.id_usuario = u.id_usuario
    ORDER BY u.nome
");

$planos = mysqli_query($conn, "SELECT id_plano, nome_plano FROM planos ORDER BY nome_plano");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Assinatura</title>
<link rel="stylesheet" href="../../css/crud.css">
</head>
<body>

    <div class="container">

        <h1>Editar Assinatura</h1>

        <form method="POST" class="form-crud">

            <select name="id_aluno" required>
                <option value="">Selecione o aluno</option>
                <?php while ($a = mysqli_fetch_assoc($alunos)): ?>
                    <option value="<?= $a['id_aluno'] ?>" <?= $a['id_aluno'] == $assinatura['id_aluno'] ? "selected" : "" ?>>
                        <?= htmlspecialchars($a['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="id_plano" required>
                <option value="">Selecione o plano</option>
                <?php while ($p = mysqli_fetch_assoc($planos)): ?>
                    <option value="<?= $p['id_plano'] ?>" <?= $p['id_plano'] == $assinatura['id_plano'] ? "selected" : "" ?>>
                        <?= htmlspecialchars($p['nome_plano']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="date" name="data_inicio" value="<?= $assinatura['data_inicio'] ?>" required>

            <input type="date" name="data_fim" value="<?= $assinatura['data_fim'] ?>" required>

            <select name="status" required>
                <?php foreach (["Ativa", "Cancelada", "Expirada"] as $opcao): ?>
                    <option value="<?= $opcao ?>" <?= $opcao == $assinatura['status'] ? "selected" : "" ?>><?= $opcao ?></option>
                <?php endforeach; ?>
            </select>

            <button name="editar">Salvar Alterações</button>

        </form>

        <?php if ($erro): ?>
            <p style="color:red; text-align:center; margin-top:15px;"><?= $erro ?></p>
        <?php endif; ?>

        <br>

        <a href="listar.php" class="btn btn-back">Voltar</a>

    </div>

</body>
</html>
<?php mysqli_close($conn); ?>
