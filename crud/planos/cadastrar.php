<?php
session_start();
include "../../conexao.php";

if($_SESSION['tipo_usuario']!="admin"){
header("Location: ../../index.php");
exit;
}

if(isset($_POST['salvar'])){

$nome=$_POST['nome_plano'];

$valor=$_POST['valor'];

$descricao=$_POST['descricao'];

mysqli_query($conn,"INSERT INTO planos(nome_plano,valor,descricao)
VALUES('$nome','$valor','$descricao')");

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

        <h1>Cadastrar Plano</h1>

        <form method="POST" class="form-crud">

        <input type="text" name="nome_plano" placeholder="Nome do plano" required>

        <input type="number" step="0.01" name="valor" placeholder="Valor" required>

        <textarea name="descricao" placeholder="Descrição"></textarea>

        <button name="salvar">Salvar</button>

        </form>

    </div>

</body>

</html>