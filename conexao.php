<?php
$servidor = "localhost";
$usuario = "root";
$senha = "usbw";
$banco = "academia";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar: " . mysqli_connect_error());
}
?>