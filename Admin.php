<?php
include('config.php');

class Admin {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function cadastrarProfessor($nome, $salario, $materias) {
        $sql = "INSERT INTO professores (nome, salario, materias) VALUES ('$nome', '$salario', '$materias')";
        $result = $this->mysqli->query($sql);
        if ($result) {
            return "Professor cadastrado com sucesso.";
        } else {
            return "Erro ao cadastrar professor: " . $this->mysqli->error;
        }
    }

    public function cadastrarAluno($nome, $bolsa, $porcentagemBolsa, $pagamento, $curso) {
        $sql = "INSERT INTO alunos (nome, bolsa, porcentagem_bolsa, pagamento, curso) 
                VALUES ('$nome', '$bolsa', '$porcentagemBolsa', '$pagamento', '$curso')";
        $result = $this->mysqli->query($sql);
        if ($result) {
            return "Aluno cadastrado com sucesso.";
        } else {
            return "Erro ao cadastrar aluno: " . $this->mysqli->error;
        }
    }
}

// Exemplo de uso da classe Admin
$admin = new Admin($mysqli);

// Exemplo de como cadastrar um professor
echo $admin->cadastrarProfessor('Nome do Professor', 2000, 'Matemática, Física');

// Exemplo de como cadastrar um aluno
echo $admin->cadastrarAluno('Nome do Aluno', 'Sim', 50, 1500, 'Engenharia');
?>
