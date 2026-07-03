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

$id = intval($_GET['id']);

$sql = "DELETE FROM assinaturas WHERE id_assinatura=$id";

if (!mysqli_query($conn, $sql)) {
    
    header("Location: listar.php?erro=" . urlencode("Não é possível excluir: existem pagamentos vinculados a esta assinatura."));
    exit;
}

header("Location: listar.php");
exit;
