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

$erro = "";

if (isset($_POST['salvar'])) {

    $id_aluno    = intval($_POST['id_aluno']);
    $id_plano    = intval($_POST['id_plano']);
    $data_inicio = $_POST['data_inicio'];
    $data_fim    = $_POST['data_fim'];
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    if ($id_aluno === 0 || $id_plano === 0 || $data_inicio === "" || $data_fim === "") {
        $erro = "Preencha todos os campos!";
    } elseif ($data_fim < $data_inicio) {
        $erro = "A data fim não pode ser anterior à data de início!";
    } else {
        $sql = "INSERT INTO assinaturas (id_aluno, id_plano, data_inicio, data_fim, status)
                VALUES ($id_aluno, $id_plano, '$data_inicio', '$data_fim', '$status')";

        if (mysqli_query($conn, $sql)) {
            header("Location: listar.php");
            exit;
        } else {
            $erro = "Erro ao salvar: " . mysqli_error($conn);
        }
    }
}

// Lista de alunos (junção usuarios + alunos) para o select
$alunos = mysqli_query($conn, "
    SELECT al.id_aluno, u.nome
    FROM alunos al
    INNER JOIN usuarios u ON al.id_usuario = u.id_usuario
    ORDER BY u.nome
");

// Lista de planos para o select
$planos = mysqli_query($conn, "SELECT id_plano, nome_plano FROM planos ORDER BY nome_plano");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Nova Assinatura</title>
<link rel="stylesheet" href="../../css/crud.css">
</head>
<body>

    <div class="container">

        <h1>Cadastrar Assinatura</h1>

        <form method="POST" class="form-crud">

            <select name="id_aluno" required>
                <option value="">Selecione o aluno</option>
                <?php while ($a = mysqli_fetch_assoc($alunos)): ?>
                    <option value="<?= $a['id_aluno'] ?>"><?= htmlspecialchars($a['nome']) ?></option>
                <?php endwhile; ?>
            </select>

            <select name="id_plano" required>
                <option value="">Selecione o plano</option>
                <?php while ($p = mysqli_fetch_assoc($planos)): ?>
                    <option value="<?= $p['id_plano'] ?>"><?= htmlspecialchars($p['nome_plano']) ?></option>
                <?php endwhile; ?>
            </select>

            <input type="date" name="data_inicio" required>

            <input type="date" name="data_fim" required>

            <select name="status" required>
                <option value="">Selecione o status</option>
                <option value="Ativa">Ativa</option>
                <option value="Cancelada">Cancelada</option>
                <option value="Expirada">Expirada</option>
            </select>

            <button name="salvar">Salvar</button>

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
