<?php
include('config.php'); // Inclui o arquivo de configuração do banco de dados

$show_search_form = true; // Variável para controlar a exibição do formulário de pesquisa

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o formulário de pesquisa foi submetido
    if (isset($_POST['id_aluno'])) {
        // Processar o formulário de pesquisa do professor
        $id_aluno = $_POST['id_aluno']; // ID do aluno a ser pesquisado
    
        // Consulta ao banco de dados para obter informações do aluno com base no ID
        $sql = "SELECT * FROM alunos WHERE id = '$id_aluno'";
        $result = $mysqli->query($sql);

        // Verifica se a consulta retornou algum resultado
        if ($result->num_rows > 0) {
            // Exibe os resultados da pesquisa
            echo "<div class='container-info'>"; // Adiciona o container para centralizar
            echo "<h2>Resultados da Pesquisa:</h2>";
            while ($row = $result->fetch_assoc()) {
                // Exibe as informações do aluno encontrado
                echo "<h3>Aluno: " . $row['nome'] . "</h3>";
                echo "<p>ID: " . $row['id'] . "</p>";
                echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
                echo "<input type='hidden' name='id_aluno' value='" . $row['id'] . "'>";
                echo "<label for='notatrabalho'>Nota Trabalho:</label>";
                echo "<input type='text' name='notatrabalho' value='" . $row['notatrabalho'] . "'><br>";
                echo "<label for='notaprova'>Nota Prova:</label>";
                echo "<input type='text' name='notaprova' value='" . $row['notaprova'] . "'><br>";
                echo "<label for='notabimestre'>Nota Bimestre:</label>";
                echo "<input type='text' name='notabimestre' value='" . $row['notabimestre'] . "'><br>";
                echo "<label for='faltas'>Faltas:</label>";
                echo "<input type='text' name='faltas' value='" . $row['faltas'] . "'><br>";
                echo "<label for='notatrabalho2'>Nota Trabalho 2:</label>";
                echo "<input type='text' name='notatrabalho2' value='" . $row['notatrabalho2'] . "'><br>";
                echo "<label for='notaprova2'>Nota Prova 2:</label>";
                echo "<input type='text' name='notaprova2' value='" . $row['notaprova2'] . "'><br>";
                echo "<label for='notabimestre2'>Nota Bimestre 2:</label>";
                echo "<input type='text' name='notabimestre2' value='" . $row['notabimestre2'] . "'><br>";
                echo "<input type='submit' value='Atualizar'>";
                echo "</form>";
            }
            echo "</div>"; // Fecha o container
            $show_search_form = false; // Oculta o formulário de pesquisa
        } else {
            // Se não houver resultados, exibe uma mensagem de erro
            echo "Nenhum aluno encontrado com o ID informado.";
        }
    } else {
        echo "Por favor, preencha o campo de ID.";
    }

    // Verifica se o formulário de atualização foi submetido
    if (isset($_POST['id_aluno'], $_POST['notatrabalho'], $_POST['notaprova'], $_POST['notabimestre'], $_POST['faltas'],
        $_POST['notatrabalho2'], $_POST['notaprova2'], $_POST['notabimestre2'])) {
        
        // Obtém os dados do formulário de atualização
        $id_aluno = $_POST['id_aluno'];
        $notatrabalho = $_POST['notatrabalho'];
        $notaprova = $_POST['notaprova'];
        $notabimestre = $_POST['notabimestre'];
        $faltas = $_POST['faltas'];
        $notatrabalho2 = $_POST['notatrabalho2'];
        $notaprova2 = $_POST['notaprova2'];
        $notabimestre2 = $_POST['notabimestre2'];

        // Atualiza os dados do aluno no banco de dados
        $update_sql = "UPDATE alunos SET notatrabalho = '$notatrabalho', notaprova = '$notaprova', 
                       notabimestre = '$notabimestre', faltas = '$faltas', notatrabalho2 = '$notatrabalho2', 
                       notaprova2 = '$notaprova2', notabimestre2 = '$notabimestre2' WHERE id = '$id_aluno'";
        
        if ($mysqli->query($update_sql) === TRUE) {
            echo "<script>window.location.href = 'tela_login.php';</script>"; // Redireciona para a página de login
            exit(); // Termina a execução do script
        } else {
            echo "Erro ao atualizar dados do aluno: " . $mysqli->error;
        }
    }
}
?>

 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/professor.css">
    <title>Painel do Professor</title>
</head>
<body>
<div class="container">
        <div class="logo-title">
            <a href="tela_home.html"><img src="images/logo.png" alt="Logo da faculdade"></a>
            <div class="title">
                <h1>ACADEMIA DE DESENVOLVIMENTO E LIDERANÇA VITORIOSA - GO</h1>
            </div>
        </div>
        <div class="links">
            <a href="tela_login.php">Login</a>
            <a href="tela_contato.html">Contatos</a>
            <a href="tela_cursos.html">Cursos</a>
        </div>
    <?php if ($show_search_form): ?> <!-- Adiciona esta linha -->
    <div class="container-busca">
    <h2>Pesquisar Aluno</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="id_aluno">Insira o ID do aluno</label>
        <input type="text" placeholder="ID do aluno"name="id_aluno" required>
        <input type="submit" value="Pesquisar">
    </form>
    </div>
    <?php endif; ?> <!-- Adiciona esta linha -->
</body>
</html>
