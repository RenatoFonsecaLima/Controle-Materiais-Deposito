<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Materiais</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Relatório de Materiais</h2>
        <?php
        include 'conexao.php';

        $sql = "
            SELECT 
                mat.id, 
                mat.nome, 
                mat.descricao, 
                mat.foto, 
                mat.disponivel,
                mov.retirado_por,
                mov.destino,
                mov.data_retirada,
                mov.data_devolucao
            FROM 
                materiais mat
            LEFT JOIN 
                movimentacoes mov 
            ON 
                mat.id = mov.material_id
            LEFT JOIN 
                (SELECT material_id, MAX(data_retirada) AS ultima_retirada
                FROM movimentacoes
                GROUP BY material_id) ultima_mov
            ON 
                mat.id = ultima_mov.material_id AND mov.data_retirada = ultima_mov.ultima_retirada
            ORDER BY 
                mat.id AND ultima_mov.material_id"
            ;


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='material-table'>";
            echo "<thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Foto</th>
                        <th>Disponível</th>
                        <th>Retirado Por</th>
                        <th>Destino</th>
                        <th>Data Retirada</th>
                        <th>Data Devolução</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $disponivel = $row['disponivel'] ? 'Sim' : 'Não';
                $retirado_por = $row['retirado_por'] ? $row['retirado_por'] : '-';
                $destino = $row['destino'] ? $row['destino'] : '-';
                $data_retirada = $row['data_retirada'] ? $row['data_retirada'] : '-';
                $data_devolucao = $row['data_devolucao'] ? $row['data_devolucao'] : '-';

                echo "<tr>";
                echo "<td data-label='Nome'>" . $row['nome'] . "</td>";
                echo "<td data-label='Descrição'>" . $row['descricao'] . "</td>";
                echo "<td data-label='Foto'><img src='uploads/" . $row['foto'] . "' alt='Foto' width='90'></td>";
                echo "<td data-label='Disponível'>" . $disponivel . "</td>";
                echo "<td data-label='Retirado Por'>" . $retirado_por . "</td>";
                echo "<td data-label='Destino'>" . $destino . "</td>";
                echo "<td data-label='Data Retirada'>" . $data_retirada . "</td>";
                echo "<td data-label='Data Devolução'>" . $data_devolucao . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='error'>Nenhum material encontrado.</p>";
        }

        $conn->close();
        ?>
        <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
