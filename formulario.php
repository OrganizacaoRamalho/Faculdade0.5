<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmação de Inscrição</title>
</head>
<body>

<?php
// Verifica se os dados do formulário foram recebidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário foram preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['data_nascimento']) && !empty($_POST['email']) && !empty($_POST['telefone'])) {
        // Recupera os dados do formulário
        $nome = $_POST['nome'];
        $data_nascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        // Exibe os dados recebidos como confirmação
        echo "<h2>Confirmação de Inscrição</h2>";
        echo "<p><strong>Nome Completo:</strong> $nome</p>";
        echo "<p><strong>Data de Nascimento:</strong> $data_nascimento</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Telefone:</strong> $telefone</p>";
    } else {
        // Se algum campo estiver vazio, exibe uma mensagem de erro
        echo "<p>Por favor, preencha todos os campos do formulário.</p>";
    }
} else {
    // Se o método de requisição não for POST, exibe uma mensagem de erro
    echo "<p>Ocorreu um erro ao processar o formulário. Tente novamente mais tarde.</p>";
}
?>

</body>
</html>