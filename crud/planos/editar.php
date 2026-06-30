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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id=$_GET['id'];

$sql=mysqli_query($conn,"SELECT * FROM planos WHERE id_plano=$id");

$plano=mysqli_fetch_assoc($sql);

if(isset($_POST['editar'])){

$nome=$_POST['nome_plano'];

$valor=$_POST['valor'];

$descricao=$_POST['descricao'];

mysqli_query($conn,"UPDATE planos
SET nome_plano='$nome',
valor='$valor',
descricao='$descricao'
WHERE id_plano=$id");

header("Location:listar.php");
}
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../../css/crud.css">
</head>
<body>

    <div class="container">

        <h1>Editar Plano</h1>

        <form method="POST" class="form-crud">

        <input type="text" name="nome_plano" value="<?=$plano['nome_plano']?>">

        <input type="number" step="0.01" name="valor" value="<?=$plano['valor']?>">

        <textarea name="descricao"><?=$plano['descricao']?></textarea>

        <button name="editar">Salvar Alterações</button>

        </form>

    </div>

</body>
</html>