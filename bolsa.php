<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/bolsa.css">
    <title>Simulação de Bolsas com Nota Total do ENEM</title>
</head>
<body>
    <div class="container">
        <h1>Simulação de Bolsas com Nota Total do ENEM</h1>
        <form id="form-enem">
            <label for="nota-total">Nota Total do ENEM:</label>
            <input type="number" id="nota-total" name="nota-total" max="1000" min="0" required>
            
            <label for="curso">Selecione o Curso:</label>
            <select id="curso" name="curso" required>
                <option value="">Selecione um curso</option>
                <?php
                // Incluir o arquivo de configuração
                require_once 'config.php';

                // Consulta SQL para selecionar os dados dos cursos
                $sql = "SELECT nome_curso, mensalidade FROM curso";
                $result = $mysqli->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Exibir os cursos como opções no menu suspenso
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['nome_curso'] . "' data-mensalidade='" . $row['mensalidade'] . "'>" . $row['nome_curso'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum curso encontrado</option>";
                }
                ?>
            </select>
            <button type="submit">Verificar Bolsa</button>
        </form>
        <div id="resultado"></div>
    </div>
    <script>
        document.getElementById('form-enem').addEventListener('submit', function(e) {
            e.preventDefault();

            const notaTotal = parseFloat(document.getElementById('nota-total').value);
            const curso = document.getElementById('curso');
            const mensalidade = parseFloat(curso.options[curso.selectedIndex].getAttribute('data-mensalidade'));

            let resultado = '';

            if (!curso.value) {
                resultado = 'Por favor, selecione um curso.';
            } else {
                const desconto = calcularDesconto(notaTotal);
                const valorDesconto = (mensalidade * desconto) / 100;
                if (desconto === 0) {
                    resultado = Infelizmente, você não tem direito a desconto. A mensalidade total é de R$ ${mensalidade.toFixed(2)}.;
                } else {
                    const valorFinal = mensalidade - valorDesconto;
                    resultado = Parabéns! Você tem direito a ${desconto}% de desconto, o que equivale a R$ ${valorDesconto.toFixed(2)} na mensalidade. A mensalidade com desconto é de R$ ${valorFinal.toFixed(2)}.;
                }
            }

            document.getElementById('resultado').innerText = resultado;
        });

        function calcularDesconto(notaTotal) {
            if (notaTotal === 1000) {
                return 100;
            } else if (notaTotal >= 799) {
                return 60;
            } else if (notaTotal >= 599) {
                return 30;
            } else if (notaTotal >= 499) {
                return 10;
            } else {
                return 0;
            }
        }
    </script>
</body>
</html>