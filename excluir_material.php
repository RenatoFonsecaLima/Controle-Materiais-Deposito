    <!DOCTYPE html>
<html>
<head>
    <title>Excluir Material</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Excluir Material</h2>
        <form action="excluir_material.php" method="post">
            <table class="material-table">
            <tbody>
                    <?php
                    include 'conexao.php';
                    $result = $conn->query("SELECT id, nome FROM materiais WHERE disponivel = 1");
                    if ($result->num_rows > 0) {
                        echo "<table class='material-table'>";
                        echo "<thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Selecionar</th>
                                </tr>
                              </thead>";
                        echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        if (empty($row)) {
                            echo "<tr><td colspan='2'>NÃO HÁ MATERIAL CADASTRADO</td></tr>";
                        } else {
                            echo "<tr>";
                            echo "<td>" . $row['nome'] . "</td>";
                            echo "<td><input type='radio' name='material_id' value='" . $row['id'] . "' required></td>";
                            echo "</tr>";
                        }
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p class='error'>Nenhum material encontrado.</p>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
            <div class="form-group">
                <label for="motivo">Motivo da Exclusão:</label>
                <textarea name="motivo" class="form-control" required></textarea>
            </div>
            <input type="submit" name="submit" value="Excluir" class="btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexao.php';
            $material_id = $_POST['material_id'];
            $motivo = $_POST['motivo'];
            $data_exclusao = date('Y-m-d H:i:s');

            // Adicionar o registro na tabela exclusoes
            $sql_exclusao = "INSERT INTO exclusoes (material_id, motivo, data_exclusao) VALUES ('$material_id', '$motivo', '$data_exclusao')";
            if ($conn->query($sql_exclusao) === TRUE) {
                // Desativar a verificação de chaves estrangeiras temporariamente
                $conn->query("SET foreign_key_checks = 0");

                // Excluir o material da tabela materiais
                $sql_excluir = "DELETE FROM materiais WHERE id='$material_id'";
                if ($conn->query($sql_excluir) === TRUE) {
                    echo "<p class='success'>Material excluído com sucesso!</p>";
                } else {
                    echo "<p class='error'>Erro: " . $sql_excluir . "<br>" . $conn->error . "</p>";
                }

                // Reativar a verificação de chaves estrangeiras
                $conn->query("SET foreign_key_checks = 1");
            } else {
                echo "<p class='error'>Erro: " . $sql_exclusao . "<br>" . $conn->error . "</p>";
            }
            $conn->close();
        }
        ?>
        <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
