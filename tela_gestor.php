<?php

include('config.php');

// Inicializa a variável que irá armazenar os resultados da pesquisa
$search_results = [];

// Verifica se o termo de pesquisa foi enviado
if(isset($_GET['search']) && trim($_GET['search']) != '') {
    // Termo de pesquisa inserido pelo usuário
    $search_term = $_GET['search'];
    
    // Prepara a declaração SQL para buscar usuários pelo nome
    $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE nome LIKE ?");
    
    // Adiciona caracteres coringa para a pesquisa parcial
    $search_term = "%" . $search_term . "%";
    
    // Vincula o termo de pesquisa ao parâmetro e executa a consulta
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    
    // Obtém o resultado da consulta
    $result = $stmt->get_result();
    
    // Armazena os resultados em uma variável
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Se não houver termo de pesquisa, busca todos os usuários
    $stmt = $mysqli->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $result = $stmt->get_result();
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="css/style_gestor.css" />
</head>

<body>
  <div class="container">
    <a href="tela_home.html"><img src="images/logo.png" alt="Logo da faculdade" /></a>
    <div class="title">
      <h1>ACADEMIA DE DESENVOLVIMENTO E LIDERANÇA VITORIOSA - GO</h1>
    </div>
  </div>

  <main>
    <div class="body-content">
      <div class="title">
        <h2>Gerenciador</h2>
      </div>

      <div>
      <div class="search-container">
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="show-all">Mostrar Todos</a>
        <div class="img-add" id="openModal"><img src="images/adicionar.png" ></div>
        <form action="tela_gestor.php" method="get">
            <input type="text" placeholder="Buscar..." name="search">
            <button type="submit">Pesquisar</button>
        </form>
    </div>


      </div>
      
    <div class="table-container">
      <table id="alunos">
                <thead>
                    <tr>
                        <th>Matricula</th>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Contato</th>
                        <th>Data de Vencimento</th>
                        <th>Status do Pagamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($search_results as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['matricula']); ?></td>
            <td><?php echo htmlspecialchars($row['nome']); ?></td>
            <td><?php echo htmlspecialchars($row['curso']); ?></td>
            <td><?php echo htmlspecialchars($row['contato']); ?></td>
            <td><?php echo htmlspecialchars($row['data_vencimento']); ?></td>
            <td><?php echo htmlspecialchars($row['status_pagamento']); ?></td>
            <td class="btn-action-column">
                <img src="images/editar.png" alt="editar.png">
                <img src="images/excluir.png" alt="excluir.png">
            </td>
        </tr>
    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
  </main>

  <?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];
    $curso = $_POST['curso'];
    $contato = $_POST['contato'];
    $data_vencimento = $_POST['data_vencimento'];
    $status_pagamento = $_POST['status_pagamento'];

    $stmt = $mysqli->prepare("INSERT INTO usuarios (matricula, nome, curso, contato, data_vencimento, status_pagamento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $matricula, $nome, $curso, $contato, $data_vencimento, $status_pagamento);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo "Usuário adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar usuário.";
    }

    $stmt->close();
    $mysqli->close();
}
?>




  <!-- Modal -->
<div id="modalForm" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Adicionar Novo Usuário</h2>
    <form action="" method="post">
      <input type="text" name="matricula" placeholder="Matricula Completo" required>
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="text" name="curso" placeholder="Curso" required>
        <input type="text" name="contato" placeholder="Contato" required>
        <input type="date" name="data_vencimento" placeholder="Data de Vencimento" required>
        <input type="text" name="status_pagamento" placeholder="Status do Pagamento" required>
        <button type="submit">Adicionar</button>
    </form>
  </div>
</div>
</body>


<script>
// Get the modal
var modal = document.getElementById('modalForm');

// Get the button that opens the modal
var btn = document.getElementById('openModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


</html>