<!DOCTYPE html>
<html>
<head>
    <title>Retirar Material</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Retirar Material</h2>
        <form action="retirar_material.php" method="post">
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
                <label for="quem_retirou">Quem Retirou:</label>
                <input type="text" name="quem_retirou" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="para_onde">Para Onde:</label>
                <input type="text" name="para_onde" class="form-control" required>
            </div>
            <input type="submit" name="submit" value="Retirar" class="btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexao.php';
            $material_id = $_POST['material_id'];
            $quem_retirou = $_POST['quem_retirou'];
            $para_onde = $_POST['para_onde'];
            $data_retirada = date('Y-m-d');

            $sql = "INSERT INTO movimentacoes (material_id, data_retirada, retirado_por, destino) VALUES ('$material_id', '$data_retirada', '$quem_retirou', '$para_onde')";
            if ($conn->query($sql) === TRUE) {
                $sql_update = "UPDATE materiais SET disponivel = 0 WHERE id='$material_id'";
                $conn->query($sql_update);
                echo "<p class='success'>Material retirado com sucesso!</p>";
            } else {
                echo "<p class='error'>Erro: " . $sql . "<br>" . $conn->error . "</p>";
            }
            $conn->close();
        }
        ?>
        <button onclick="window.location.href='../index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
