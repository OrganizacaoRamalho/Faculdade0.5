<?php
include('config.php'); // Inclui o arquivo de configuração do banco de dados

// Consulta ao banco de dados para obter as informações do aluno (notas, médias, faltas)
// Aqui você precisará adaptar a consulta de acordo com a estrutura do seu banco de dados
// Supondo que você tenha uma tabela 'alunos' com as colunas 'notatrabalho', 'notaprova', 'faltas', etc.
// Você precisará ajustar os nomes das colunas e a lógica da consulta conforme necessário

// Exemplo de consulta
$sql = "SELECT notatrabalho, notaprova, notabimestre, notatrabalho2, notaprova2, notabimestre2, faltas FROM alunos WHERE id = '$id_do_aluno'";
$result = $mysqli->query($sql);

// Verifica se a consulta retornou algum resultado
if ($result->num_rows > 0) {
    // Obtém os dados do aluno
    $dados_aluno = $result->fetch_assoc();
    
    // Extrai as informações do aluno
    $notatrabalho = $dados_aluno['notatrabalho'];
    $notaprova = $dados_aluno['notaprova'];
    $notabimestre = $dados_aluno['notabimestre'];
    $faltas = $dados_aluno['faltas'];
  $notatrabalho2 = $dados_aluno['notatrabalho'];
    $notaprova2 = $dados_aluno['notaprova'];
    $notabimestre2 = $dados_aluno['notabimestre'];

} else {
    // Se não houver resultados, exibe uma mensagem de erro ou redireciona o usuário
    echo "Nenhum aluno encontrado.";
    exit; // Encerra a execução do script
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
    <!-- Adicione aqui suas folhas de estilo CSS -->
</head>
<body>
    <h1>Painel do Aluno</h1>
    <h2>Notas e Faltas</h2>
    <p>Nota Trabalho: <?php echo $notatrabalho; ?></p>
    <p>Nota Prova: <?php echo $notaprova; ?></p>
    <p>Média do Bimestre: <?php echo $notabimestre; ?></p>
    <p>Faltas: <?php echo $faltas; ?></p>
    <!-- Adicione aqui mais informações se necessário -->
</body>
</html>
