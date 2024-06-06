<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Aluno por ID</title>
    <link rel="stylesheet" href="CSS/tela_aluno.css">
</head>
<body>
<div class="container-title">
    <div class="logo-title">
        <a href="tela_home.html"><img src="images/logo.png" alt="Logo da faculdade"></a>
        <div class="title">
            <h1>ACADEMIA DE DESENVOLVIMENTO E LIDERANÇA VITORIOSA - GO</h1>
        </div>
    </div>
    <div class="links">
        <a href="tela_home.html">Home</a>
        <a href="tela_contato.html">Contatos</a>
        <a href="enviar_avaliacao.php">Avaliação Institucional</a>

    </div>
</div>
<div class="container-info">
    <?php
    include('config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id_aluno'])) {
            $id_aluno = $_POST['id_aluno'];
            $sql = "SELECT * FROM alunos WHERE id = '$id_aluno'";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='results'>";
                echo "<h2>Resultados da Pesquisa:</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<h3>Aluno: " . $row['nome'] . "</h3>";
                    echo "<p>ID: " . $row['id'] . "</p>";
                    echo "<p>Nota Trabalho: " . $row['notatrabalho'] . "</p>";
                    echo "<p>Nota Prova: " . $row['notaprova'] . "</p>";
                    echo "<p>Nota Bimestre: " . $row['notabimestre'] . "</p>";
                    echo "<p>Faltas: " . $row['faltas'] . "</p>";
                    echo "<h3>Segundo Bimestre</h3>";
                    echo "<p>Nota Trabalho 2: " . $row['notatrabalho2'] . "</p>";
                    echo "<p>Nota Prova 2: " . $row['notaprova2'] . "</p>";
                    echo "<p>Nota Bimestre 2: " . $row['notabimestre2'] . "</p>";
                }
                echo "</div>";
            } else {
                echo "<p>Nenhum aluno encontrado com o ID informado.</p>";
            }
        }
    } else {
        echo "<h1>Insira o RA do Aluno:</h1>";
        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
        echo "<label for='id_aluno'>RA do Aluno:</label>";
        echo "<input type='text' name='id_aluno' required>";
        echo "<br>";
        echo "<input type='submit' value='Pesquisar'>";
        echo "</form>";
    }
    ?>
</div>
</body>
</html>
