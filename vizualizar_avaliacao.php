<?php
include_once("config.php"); 

// Seleciona todas as avaliações na tabela de avaliações
$sql = "SELECT nome, email, satisfacao, comentarios, data_envio FROM avaliacoes";
$resultado = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/enviarav.css">
    <title>Visualizar Avaliações</title>
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
            <a href="tela_login.php">Login</a>
            <a href="tela_contato.html">Contatos</a>
            <a href="tela_cursos.html">Cursos</a>
        </div>
    </div>
<div class="container-info">
<h2>Avaliação Institucional</h2>
    <h2>Visualizar Avaliações</h2>
    <?php
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            echo "<div>";
            echo "<p><strong>Nome:</strong> " . $row["nome"] . "</p>";
            echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
            echo "<p><strong>Nível de Satisfação:</strong> " . $row["satisfacao"] . "</p>";
            echo "<p><strong>Comentários:</strong> " . $row["comentarios"] . "</p>";
            echo "<p><strong>Data de Envio:</strong> " . $row["data_envio"] . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Nenhuma avaliação encontrada.</p>";
    }

    // Fecha a conexão
    $mysqli->close();
    ?>
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
