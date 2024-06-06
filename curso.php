<?php
include('config.php'); // Inclui a configuração do banco de dados

// Array associativo com endereços de imagem baseados no ID do curso
$imagemCursos = [
    1 => 'images/eng-software.png',
    2 => 'images/ads.jpg',
    3 => 'images/admin.jpg',
    4 => 'images/piiii.png',
    5 => 'images/bio.png',
    6 => 'images/direito2.jpeg',
    7 => 'images/edf.png',
    8 => 'images/fisio.png'
];

// Pega o ID do curso selecionado da URL
$id_curso_selecionado = isset($_GET['id_curso']) ? (int)$_GET['id_curso'] : 0;

// Consulta SQL para recuperar o curso selecionado
$sql_curso = "SELECT * FROM curso WHERE ID = $id_curso_selecionado";

// Consulta SQL para recuperar as matérias associadas ao curso
$sql_materias = "SELECT m.* 
    FROM materia m
    JOIN curso_materia cm ON m.ID = cm.fk_materia_ID 
    WHERE cm.fk_curso_ID = $id_curso_selecionado";

$result_curso = $mysqli->query($sql_curso);
$result_materias = $mysqli->query($sql_materias);

if ($result_curso === false) {
    echo "Erro na consulta SQL: " . $mysqli->error;
    exit;
}

if ($result_curso->num_rows > 0) {
    $row = $result_curso->fetch_assoc();
    // Obtém o endereço da imagem com base no ID do curso
    $imagemCurso = isset($imagemCursos[$id_curso_selecionado]) ? $imagemCursos[$id_curso_selecionado] : 'images/default.png';
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $row['nome_curso']; ?></title>
        <link rel="stylesheet" href="./CSS/informativo.css">
    </head>
    <body>
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close-button" onclick="closePopup()">X</span>
                <h2>Formulário de Inscrição</h2>
                <form id="registrationForm" action="formulario.php" method="post">
                    <input type="hidden" name="id_curso" value="<?php echo $id_curso_selecionado; ?>">
                    <label for="nome">Nome Completo:</label><br>
                    <input type="text" id="nome" name="nome" required><br>
                    <label for="data_nascimento">Data de Nascimento:</label><br>
                    <input type="date" id="data_nascimento" name="data_nascimento" required><br>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br>
                    <label for="telefone">Telefone:</label><br>
                    <input type="tel" id="telefone" name="telefone" placeholder="(xx) xxxxx-xxxx" maxlength="15">
                    <input type="submit" value="Inscreva-se">
                </form>
            </div>
        </div>
        <div class="container">
            <div class="logo-title">
                <a href="./tela_home.html"><img src="./images/logo.png" alt="Logo da faculdade"></a>
                <div class="title">
                    <h1>ACADEMIA DE DESENVOLVIMENTO E LIDERANÇA VITORIOSA - GO</h1>
                </div>
            </div>
            <div class="links">
                <a href="./tela_login.php">Login</a>
                <a href="./tela_contato.html">Contatos</a>
                <a href="./tela_cursos.html">Cursos</a>
            </div>
        </div>
        <main>
            <div class="square">
                <div class="text-curso">
                    <div class="title-text">
                        <h2><?php echo $row['nome_curso']; ?></h2>
                    </div>
                </div>
                <div class="container2">
                    <div class="card-curso">
                        <img src="<?php echo $imagemCurso; ?>" alt="Imagem do curso" />
                    </div>
                    <div class="white-square">
                        <button class="btn" onclick="openPopup()">Quero me Inscrever</button>
                        <div class="horario">
                            <h2><img src="./images/ampulheta.png"> Carga Horária <span><?php echo $row['carga_horaria']; ?></span></h2>
                            <h2><img src="./images/calendario.png"> Tempo de curso <span><?php echo $row['tempo_curso']; ?></span></h2>
                            <h2><img src="./images/modalidade.png"> Modalidade <span><?php echo $row['modalidade']; ?></span></h2>
                            <h2><img src="./images/relogio.png"> Turno <span> Noturno</span></h2>
                        </div>
                        <div class="quadrado-pequeno">
                            <h2>Mensalidade</h2>
                            <h3>R$ <?php echo number_format($row['mensalidade'], 2, ',', '.'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="black-square">
                    <h2>Matérias</h2>
                    <?php
                    if ($result_materias === false) {
                        echo "Erro na consulta SQL: " . $mysqlii->error;
                    } else {
                        if ($result_materias->num_rows > 0) {
                            while ($row_materia = $result_materias->fetch_assoc()) {
                                echo "<h3> - " . $row_materia['nome_materia'] . "</h3>";
                            }
                        } else {
                            echo "Nenhuma matéria encontrada.";
                        }
                    }
                    ?>
                </div>
                <div class="container2">
                    <div class="two-square">
                        <div class="infos">
                            <h2>Perfil profissional</h2>
                            <h3><?php echo $row['perfil_profissional']; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="three-square">
                    <div class="infos">
                        <h2>Mercado de Trabalho</h2>
                        <h3><?php echo $row['mercado_trabalho']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="container-footer">
                <div class="footer-content">
                    <p>&copy; 2024 GRUPO ADVLG. Todos os direitos reservados.</p>
                    <p>Entre em contato: unibrasil@unibrasil.com</p>
                    <p>Telefone:(41)3515-1448</p>
                </div>
            </div>
        </main>
        <script>
            function openPopup() {
                document.getElementById("popup").style.display = "block";
            }

            function closePopup() {
                document.getElementById("popup").style.display = "none";
                document.getElementById("registrationForm").reset();
            }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "Nenhum curso encontrado.";
}

$mysqlii->close();
?>