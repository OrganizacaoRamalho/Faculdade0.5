<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tipo'])) {
        $tipo = $_POST['tipo'];
        if ($tipo == 'Professor' || $tipo == 'Aluno') {
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];
            $confirmarSenha = $_POST['confirmar_senha'];

            if ($senha === $confirmarSenha) {
                // Não criptografa a senha, insere no banco de dados em texto plano
                $sql = "INSERT INTO usuarios (usuario, senha, tipo) VALUES ('$nome', '$senha', '$tipo')";
                $result = $mysqli->query($sql);

                if ($result) {
                    $mensagem = "Usuário $tipo cadastrado com sucesso.";
                } else {
                    $erro = "Erro ao cadastrar $tipo: " . $mysqli->error;
                }
            } else {
                $erro = "As senhas não coincidem.";
            }
        } else {
            $erro = "Tipo de usuário inválido.";
        }
    } else {
        $erro = "Tipo de usuário não especificado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Criar Usuário</h2>
    </div>

    <div class="container-login">
        <form action="" method="post">
            <label for="tipo">Tipo de Usuário:</label>
            <select name="tipo" id="tipo">
                <option value="Professor">Professor</option>
                <option value="Aluno">Aluno</option>
            </select><br><br>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required><br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required><br><br>
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" name="confirmar_senha" required><br><br>
            <input type="submit" value="Cadastrar">
        </form>

        <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
        <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    </div>
</body>
</html>