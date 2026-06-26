<?php
session_start();
include "../../conexao.php";

if ($_SESSION['tipo_usuario'] != "admin") {
    header("Location: ../../index.php");
    exit;
}

$sql = "SELECT * FROM planos";
$resultado = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../../css/crud.css">
<title>Planos</title>

</head>

<body>

    <div class="container">

        <h1>Gerenciamento de Planos</h1>

        <a href="cadastrar.php" class="btn btn-add">Novo Plano</a>

        <br><br>

        <table>

        <tr>

        <th>ID</th>
        <th>Plano</th>
        <th>Valor</th>
        <th>Descrição</th>
        <th>Ações</th>

        </tr>

        <?php while($plano=mysqli_fetch_assoc($resultado)){ ?>

        <tr>

        <td><?= $plano['id_plano']?></td>

        <td><?= $plano['nome_plano']?></td>

        <td>R$ <?= number_format($plano['valor'],2,",",".")?></td>

        <td><?= $plano['descricao']?></td>

        <td>

        <a class="btn btn-edit" href="editar.php?id=<?=$plano['id_plano']?>">Editar</a>

        <a class="btn btn-delete" href="excluir.php?id=<?=$plano['id_plano']?>">Excluir</a>

        </td>

        </tr>

        <?php } ?>

        </table>

        <br>

        <a href="../admin.php" class="btn btn-back">Voltar</a>

    </div>

</body>

</html>