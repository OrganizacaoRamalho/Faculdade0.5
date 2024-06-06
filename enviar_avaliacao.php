<?php
include_once("config.php"); 

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $satisfacao = $_POST['satisfacao'];
    $comentarios = $_POST['comentarios'];

    // Insere os dados na table de avaliações
    $sql = "INSERT INTO avaliacoes (nome, email, satisfacao, comentarios) VALUES ('$nome', '$email', '$satisfacao', '$comentarios')";

    if ($mysqli->query($sql)) {
        echo "Avaliação enviada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Avaliação</title>
    <link rel="stylesheet" href="CSS/enviarav.css">
</head>
<body>
<div class="container">
        <div class="logo-title">
            <a href="#"><img src="images/logo.png" alt="Logo da faculdade"></a>
            <div class="title">
                <h1>ACADEMIA DE DESENVOLVIMENTO E LIDERANÇA VITORIOSA - GO</h1>
            </div>
        </div>
        <div class="links">
            <a href="tela_home.html">Home</a>
            <a href="#" onclick="history.back();">Voltar</a>
        </div>
    </div>
    <div class="container-info">
    <h2>Avaliação Institucional</h2>
    <h2>Enviar Avaliação</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="satisfacao">Nível de Satisfação:</label><br>
        <select id="satisfacao" name="satisfacao" required>
            <option value="1">1 - Muito Insatisfeito</option>
            <option value="2">2 - Insatisfeito</option>
            <option value="3">3 - Neutro</option>
            <option value="4">4 - Satisfeito</option>
            <option value="5">5 - Muito Satisfeito</option>
        </select><br><br>

        <label for="comentarios">Comentários:</label><br>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Enviar Avaliação">
    </form>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 GRUPO ADVLG. Todos os direitos reservados.</p>
            <p>Entre em contato: unibrasil@unibrasil.com</p>
            <p>Telefone:(41)3515-1448</p>
        </div>
    </footer>
</body>
</html>


