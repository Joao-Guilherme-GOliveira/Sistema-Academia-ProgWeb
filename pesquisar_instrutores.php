<?php
session_start()
include "conexao.php";

if (!isset($_SESSION['id_usuario'])) {
    echo "<p>Sessão expirada. Faça login novamente.</p>";
    exit;
}


if (!isset($conn) || !$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}

$conexao = $conn;

$nome = "";

if (isset($_GET["nome"])) {
    $nome = mysqli_real_escape_string($conexao, $_GET["nome"]);
}

$sql = "SELECT
            u.nome,
            i.cref,
            i.telefone,
            i.especialidade
        FROM instrutores i
        INNER JOIN usuarios u
            ON i.id_usuario = u.id_usuario
        WHERE u.nome LIKE '%$nome%'
        ORDER BY u.nome";

$resultado = mysqli_query($conexao, $sql);

if (mysqli_num_rows($resultado) > 0) {

    while ($instrutor = mysqli_fetch_assoc($resultado)) {
        echo '
        <div class="card">
            <h3>'.$instrutor["nome"].'</h3>
            <p>CREF: '.$instrutor["cref"].'</p>
            <p>Telefone: '.$instrutor["telefone"].'</p>
            <p>Especialidade: '.$instrutor["especialidade"].'</p>
        </div>';
    }

} else {
    echo "<p>Nenhum instrutor encontrado.</p>";
}

mysqli_close($conexao);
?>