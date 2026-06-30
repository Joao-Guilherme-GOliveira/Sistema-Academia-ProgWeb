<?php
session_start();
include "conexao.php";

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Academia</title>
    <link rel="stylesheet" href="css/stylelogin.css">
    <link rel="stylesheet" href="css/stylecadastro.css">
</head>
<body class="login-body">

<div class="login-container">

    <img src="imagens/logoacad.png" class="logo-login" alt="Logo da Academia">

    <form method="POST" class="login-form">
        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit" name="entrar">Entrar</button>

        <p class="link-login">Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </form>

    <?php
    if (isset($erro)) {
        echo "<p class='erro'>$erro</p>";
    }
    ?>

</div>

</body>
</html>