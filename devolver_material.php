<!DOCTYPE html>
<html>
<head>
    <title>Devolver Material</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
            <h2>Devolver Material</h2>
            <form action="devolver_material.php" method="post">
                <div class="form-group">
                    <label for="movimentacao_id">Movimentação:</label>
                    <select name="movimentacao_id" class="form-control">
                    <?php
                    include 'conexao.php';
                    $result = $conn->query("SELECT m.id, mat.nome FROM movimentacoes m JOIN materiais mat ON m.material_id = mat.id WHERE m.data_devolucao IS NULL");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <input type="submit" name="submit" value="Devolver" class="btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexao.php';
            $movimentacao_id = $_POST['movimentacao_id'];
            $data_devolucao = date('Y-m-d');

            // Atualizar a data de devolução na tabela movimentacoes
            $sql = "UPDATE movimentacoes SET data_devolucao='$data_devolucao' WHERE id='$movimentacao_id'";
            if ($conn->query($sql) === TRUE) {
                // Atualizar o status de disponibilidade do material
                $sql_update = "UPDATE materiais SET disponivel = 1 WHERE id = (SELECT material_id FROM movimentacoes WHERE id = '$movimentacao_id')";
                $conn->query($sql_update);
                echo "<p class='success'>Material devolvido com sucesso!</p>";
            } else {
                echo "<p class='error'>Erro: " . $sql . "<br>" . $conn->error . "</p>";
            }
            $conn->close();
        }
        ?>
        <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
