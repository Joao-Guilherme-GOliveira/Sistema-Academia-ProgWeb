<?php
session_start();
include "conexao.php";

$erro = "";
$sucesso = "";

if (isset($_POST['cadastrar'])) {
    $nome     = trim($_POST['nome']);
    $email    = trim($_POST['email']);
    $senha    = $_POST['senha'];
    $confirma = $_POST['confirma_senha'];
    $cpf      = trim($_POST['cpf']);
    $telefone = trim($_POST['telefone']);
    $data_nasc = $_POST['data_nasc'];
    $endereco = trim($_POST['endereco']);

    if ($nome === "" || $email === "" || $senha === "") {
        $erro = "Preencha os campos obrigatórios!";
    } elseif ($senha !== $confirma) {
        $erro = "As senhas não conferem!";
    } else {
        // Verifica se o email já está cadastrado
        $sqlVerifica = "SELECT id_usuario FROM usuarios WHERE email='$email'";
        $resVerifica = mysqli_query($conn, $sqlVerifica);

        if (mysqli_num_rows($resVerifica) > 0) {
            $erro = "Este email já está cadastrado!";
        } else {
            $senhaHash = md5($senha);

            $sqlUsuario = "INSERT INTO usuarios (nome, email, senha, tipo_usuario)
                            VALUES ('$nome', '$email', '$senhaHash', 'aluno')";

            if (mysqli_query($conn, $sqlUsuario)) {
                $id_usuario = mysqli_insert_id($conn);

                $sqlAluno = "INSERT INTO alunos (id_usuario, cpf, telefone, data_nasc, endereco)
                             VALUES ($id_usuario, '$cpf', '$telefone', '$data_nasc', '$endereco')";

                if (mysqli_query($conn, $sqlAluno)) {
                    $sucesso = "Cadastro realizado com sucesso! Você já pode fazer login.";
                } else {
                    $erro = "Erro ao salvar dados do aluno: " . mysqli_error($conn);
                }
            } else {
                $erro = "Erro ao cadastrar usuário: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Academia</title>
    <link rel="stylesheet" href="css/stylelogin.css">
    <link rel="stylesheet" href="css/stylecadastro.css">
</head>
<body class="login-body">

<div class="login-container">

    <img src="imagens/logoacad.png" class="logo-login" alt="Logo da Academia">

    <form method="POST" class="login-form cadastro-form">
        <h2 class="form-titulo">Criar conta</h2>

        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" placeholder="Nome completo" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required>

        <div class="campo-duplo">
            <div>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
            </div>
            <div>
                <label for="confirma_senha">Confirmar senha</label>
                <input type="password" id="confirma_senha" name="confirma_senha" placeholder="Confirmar senha" required>
            </div>
        </div>

        <div class="campo-duplo">
            <div>
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14">
            </div>
            <div>
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="(00)00000-0000" maxlength="20">
            </div>
        </div>

        <div class="campo-duplo">
            <div>
                <label for="data_nasc">Data de nascimento</label>
                <input type="date" id="data_nasc" name="data_nasc">
            </div>
            <div>
                <label for="endereco">Endereço</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, número, bairro">
            </div>
        </div>

        <button type="submit" name="cadastrar">Cadastrar</button>

        <p class="link-login">Já tem conta? <a href="login.php">Entrar</a></p>
    </form>

    <?php if ($erro): ?>
        <p class="erro"><?php echo $erro; ?></p>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <p class="sucesso"><?php echo $sucesso; ?></p>
    <?php endif; ?>

</div>

</body>
</html>
