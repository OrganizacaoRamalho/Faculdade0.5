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
        <div class="img-add"><img src="images/adicionar.png" ></div>
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
</body>

</html>