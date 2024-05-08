<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Aluno por ID</title>
    <style>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Aluno por ID</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            padding: 8px;
            margin: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 8px 20px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .results {
            margin-top: 20px;
        }
        .results h2 {
            margin-bottom: 10px;
        }
        .results h3 {
            color: #333;
        }
        .results p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
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
        echo "<input type='submit' value='Pesquisar'>";
        echo "</form>";
    }
    ?>
</div>

</body>
</html>