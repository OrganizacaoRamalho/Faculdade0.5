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
            <img src="images/editar.png" alt="Editar" onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo $row['matricula']; ?>', '<?php echo htmlspecialchars($row['nome']); ?>', '<?php echo htmlspecialchars($row['curso']); ?>', '<?php echo htmlspecialchars($row['contato']); ?>', '<?php echo $row['data_vencimento']; ?>', '<?php echo htmlspecialchars($row['status_pagamento']); ?>', '<?php echo htmlspecialchars($row['usuario']); ?>', '<?php echo htmlspecialchars($row['senha']); ?>', '<?php echo htmlspecialchars($row['tipo']); ?>')">
                          <form action="" method="post">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <button type="submit" style="border: none; background: none; padding: 0;">
                      <img src="images/excluir.png" alt="Excluir">
                  </button>
              </form>
            </td>
        </tr>
    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
  </main>

  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('config.php');
  $action = $_POST['action'];

  if ($action == "add") {
      
      if (isset($_POST['matricula'], $_POST['nome'], $_POST['curso'], $_POST['contato'], $_POST['data_vencimento'], $_POST['status_pagamento'], $_POST['usuario'], $_POST['senha'], $_POST['tipo'])) {
          $matricula = $_POST['matricula'];
          $nome = $_POST['nome'];
          $curso = $_POST['curso'];
          $contato = $_POST['contato'];
          $data_vencimento = $_POST['data_vencimento'];
          $status_pagamento = $_POST['status_pagamento'];
          $usuario = $_POST['usuario'];
          $senha = $_POST['senha'];
          $tipo = $_POST['tipo'];

          $stmt = $mysqli->prepare("INSERT INTO usuarios (matricula, nome, curso, contato, data_vencimento, status_pagamento, usuario, senha, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("sssssssss", $matricula, $nome, $curso, $contato, $data_vencimento, $status_pagamento, $usuario, $senha, $tipo);
          $stmt->execute();

          if ($stmt->affected_rows > 0) {
              echo "<script>alert('Usuário adicionado com sucesso!'); window.location.href = 'tela_gestor.php';</script>";
          } else {
              echo "<script>alert('Erro ao adicionar usuário.'); window.location.href = 'tela_gestor.php';</script>";
          }
          $stmt->close();
      } else {
          echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href = 'tela_gestor.php';</script>";
      }
  }
  $mysqli->close();
}


// Deletar usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
  include('config.php');
  $action = $_POST['action'];

  if ($action == "delete") {
      $id = $_POST['id'];

      $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
          echo "<script>alert('Usuário deletado com sucesso!'); window.location.href = 'tela_gestor.php';</script>";
      } else {
          echo "<script>alert('Erro ao deletar usuário.'); window.location.href = 'tela_gestor.php';</script>";
      }

      $stmt->close();
      $mysqli->close();
  }  elseif ($action == "edit") {
    if (isset($_POST['id'], $_POST['matricula'], $_POST['nome'], $_POST['curso'], $_POST['contato'], $_POST['data_vencimento'], $_POST['status_pagamento'], $_POST['usuario'], $_POST['senha'], $_POST['tipo'])) {
        $id = $_POST['id'];
        $matricula = $_POST['matricula'];
        $nome = $_POST['nome'];
        $curso = $_POST['curso'];
        $contato = $_POST['contato'];
        $data_vencimento = $_POST['data_vencimento'];
        $status_pagamento = $_POST['status_pagamento'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo'];

        $stmt = $mysqli->prepare("UPDATE usuarios SET matricula=?, nome=?, curso=?, contato=?, data_vencimento=?, status_pagamento=?, usuario=?, senha=?, tipo=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $matricula, $nome, $curso, $contato, $data_vencimento, $status_pagamento, $usuario, $senha, $tipo, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href = 'tela_gestor.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar usuário ou nenhum dado foi alterado.'); window.location.href = 'tela_gestor.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href = 'tela_gestor.php';</script>";
    }
}
}




?>

  <!-- Modal de adicionar-->
<div id="modalForm" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Adicionar Novo Usuário</h2>
    <form action="" method="post">
    <input type="hidden" name="action" value="add">
    <input type="text" name="usuario" placeholder="Login Usuario" required>
    <input type="text" name="senha" placeholder="Senha Usuario" required>

    <select name="tipo" required>
        <option value="">Selecione o Tipo de Usuário</option>
        <option value="Admin">Admin</option>
        <option value="Professor">Professor</option>
        <option value="Aluno">Aluno</option>
    </select>

      <input type="text" name="matricula" placeholder="Matricula Completo" required>
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="text" name="curso" placeholder="Curso" required>
        <input type="text" name="contato" placeholder="Contato" required>
        <input type="date" name="data_vencimento" placeholder="Data de Vencimento" required>

    <select name="status_pagamento" required>
        <option value="">Selecione o Status do Pagamento</option>
        <option value="pago">Pago</option>
        <option value="pendente">Pendente</option>
    </select>

        <button type="submit" class="button-modals">Adicionar</button>
    </form>
  </div>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="closeEdit">&times;</span>
    <h2>Editar Usuário</h2>
    <form action="" method="post">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id" id="editId">
      <input type="text" id="editUsuario"name="usuario" placeholder="Login Usuario" required>
      <input type="text" id="editSenha"name="senha" placeholder="Senha Usuario" required>

    <select name="tipo" id="editTipo" required>
        <option value="">Selecione o Tipo de Usuário</option>
        <option value="Admin">Admin</option>
        <option value="Professor">Professor</option>
        <option value="Aluno">Aluno</option>
    </select>

      <input type="text" id="editMatricula" name="matricula" placeholder="Matricula" required>
      <input type="text" id="editNome" name="nome" placeholder="Nome Completo" required>
      <input type="text" id="editCurso" name="curso" placeholder="Curso" required>
      <input type="text" id="editContato" name="contato" placeholder="Contato" required>
      <input type="date" id="editDataVencimento" name="data_vencimento" placeholder="Data de Vencimento" required>

    <select name="status_pagamento" id="editStatusPagamento" required>
        <option value="">Selecione o Status do Pagamento</option>
        <option value="pago">Pago</option>
        <option value="pendente">Pendente</option>
    </select>

      <button type="submit"class="button-modals">Salvar Alterações</button>
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


function openEditModal(id, matricula, nome, curso, contato, dataVencimento, statusPagamento, usuario, senha, tipo) {
  // Preenche os campos do formulário com os dados atuais
  document.getElementById('editId').value = id;
  document.getElementById('editMatricula').value = matricula;
  document.getElementById('editNome').value = nome;
  document.getElementById('editCurso').value = curso;
  document.getElementById('editContato').value = contato;
  document.getElementById('editDataVencimento').value = dataVencimento;
  document.getElementById('editStatusPagamento').value = statusPagamento;
  document.getElementById('editUsuario').value = usuario;
  document.getElementById('editSenha').value = senha;
  document.getElementById('editTipo').value = tipo;
  // Mostra o modal
  document.getElementById('editModal').style.display = 'block';
}

// Adiciona o evento para fechar o modal de edição
var spanEdit = document.getElementsByClassName('closeEdit')[0];
spanEdit.onclick = function() {
  document.getElementById('editModal').style.display = 'none';
}



</script>


</html>