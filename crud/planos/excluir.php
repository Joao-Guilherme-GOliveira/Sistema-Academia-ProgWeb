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

mysqli_query($conn,"DELETE FROM planos WHERE id_plano=$id");

header("Location:listar.php");