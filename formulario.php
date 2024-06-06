<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário foram preenchidos

    if (!empty($_POST['nome']) && !empty($_POST['data_nascimento']) && !empty($_POST['email']) && !empty($_POST['telefone']) && !empty($_POST['id_curso'])) {
        // Recupera os dados do formulário
        $nome = $_POST['nome'];
        $data_nascimento = $_POST['data_nascimento'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $id_curso = $_POST['id_curso']; 
        
        // Verifica se o e-mail já está cadastrado para o curso específico
        $sql_verificar_email = "SELECT COUNT(*) as total FROM inscricao WHERE email = ? AND id_curso = ?";
        $stmt_verificar_email = $mysqli->prepare($sql_verificar_email);
        $stmt_verificar_email->bind_param("si", $email, $id_curso);
        $stmt_verificar_email->execute();
        $result_verificar_email = $stmt_verificar_email->get_result();
        $row_verificar_email = $result_verificar_email->fetch_assoc();
        $total_email_curso = $row_verificar_email['total'];


        // Verifica quantos cursos a pessoa já está inscrita
        $sql_count_cursos = "SELECT COUNT(*) as total_cursos FROM inscricao WHERE email = ?";
        $stmt_count_cursos = $mysqli->prepare($sql_count_cursos);
        $stmt_count_cursos->bind_param("s", $email);
        $stmt_count_cursos->execute();
        $result_count_cursos = $stmt_count_cursos->get_result();
        $row_count_cursos = $result_count_cursos->fetch_assoc();
        $total_cursos = $row_count_cursos['total_cursos'];

        // Verifica se a pessoa já está inscrita em dois cursos
       
        // Verifica se o e-mail já está cadastrado para o curso específico
        if ($total_email_curso > 0) {
            echo "<script>alert('Este e-mail já está cadastrado para este curso.');</script>";
            echo "<script>window.location.href = './tela_home.html'</script>";
        } 
        elseif ($total_cursos >= 1) {
            echo "<script>alert('Você já está inscrito em um curso. Não é possível se inscrever em mais cursos.');</script>";
            echo "<script>window.location.href = './tela_home.html'</script>";
        }
        else {
            // Insere o novo registro na tabela
            $sql_insert = "INSERT INTO inscricao (nome, data_nascimento, email, telefone, id_curso) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql_insert);
            $stmt->bind_param("ssssi", $nome, $data_nascimento, $email, $telefone, $id_curso);

            if ($stmt->execute()) {
                // Se a execução for bem-sucedida, exibe um pop-up de sucesso usando JavaScript
                echo "<script>alert('Dados inseridos com sucesso!');</script>";
                echo "<script>window.location.href = './tela_home.html'</script>";
            } else {
                // Se ocorrer um erro, exibe um pop-up de erro usando JavaScript
                echo "<script>alert('Erro ao inserir dados: " . $stmt->error . "');</script>";
            }

            // Fecha a instrução
            $stmt->close();
        }

        // Fecha a instrução de verificação de e-mail
        $stmt_verificar_email->close();
    } else {
        // Se algum campo estiver vazio, exibe uma mensagem de erro
        echo "Por favor, preencha todos os campos do formulário.";
    }
}
?>