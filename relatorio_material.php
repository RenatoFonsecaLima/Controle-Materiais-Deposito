<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Materiais</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Relatório de Materiais</h2>
        <table class="material-table">
            <thead>
                <tr>
                    <th>Nome do Material</th>
                    <th>Descrição</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexao.php';
                $sql = "SELECT m.nome, m.descricao, 
                               IF(m.disponivel = 1, 'Disponível', 'Retirado') as status
                        FROM materiais m";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['descricao'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
