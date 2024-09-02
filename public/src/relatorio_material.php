    <!DOCTYPE html>
    <html>

    <head>
        <title>Relatório de Materiais</title>
        <link rel="stylesheet" type="text/css" href="../styles.css">
    </head>

    <body>

        <div class="container">
            <h2>Relatório de Materiais</h2>
            <form method="post" action="">
                <div class="select-wrapper">
                    <label class="categoriaName" for="categoria">Categoria:</label>
                    <select class="categoriaOp" name="categoria" id="categoria" class="form-control" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="Todas">Todas</option>
                        <option value="Automóvel">Automóvel</option>
                        <option value="Ferramentas">Ferramentas</option>
                        <option value="Construcao">Construção</option>
                        <option value="Diversos">Diversos</option>
                    </select>
                    <label class="categoriaName" for="format">Tipo de Relatório:</label>
                    <select class="categoriaOp" name="format" id="format" class="form-control" required>
                        <option value="">Tipo de Relatório</option>
                        <option value="emPdf">PDF</option>
                        <option value="screen">Tela</option>
                    </select>
                    <button type="submit" class="categoriaOp">Gerar Relatório</button>
                </div>
            </form>

            <?php
require_once 'C:\Users\renato\vendor\autoload.php'; // Inclua o autoload do Composer
ob_start(); // Inicia o buffer de saída
include 'conexao.php';

// Recupera e sanitiza os dados do formulário
$categoria = isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8') : '';
$format = isset($_POST['format']) ? htmlspecialchars($_POST['format'], ENT_QUOTES, 'UTF-8') : '';
// Prepara a consulta com base na categoria selecionada
if ($categoria === 'Todas' || empty($categoria)) {
    $sql = "
        SELECT 
            mat.id, 
            mat.nome, 
            mat.categoria,
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
            mat.id
    ";
} else {
    $sql = "
        SELECT 
            mat.id, 
            mat.nome, 
            mat.categoria,
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
        WHERE 
            mat.categoria = ?
        ORDER BY 
            mat.id
    ";

    // Prepara e executa a consulta com filtro por categoria
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoria);
}

if (!isset($stmt)) {
    // Se a consulta não usa prepared statements
    $result = $conn->query($sql);
} else {
    // Se a consulta usa prepared statements
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($format === 'emPdf') {
    if ($result->num_rows > 0) {
        //Limpa buffer 
        ob_end_clean();
        // Cria um novo documento PDF
        $pdf = new TCPDF();
        
        // Configura o documento PDF
        $pdf->SetCreator('PDF_CREATOR');
        $pdf->SetAuthor('Renato Fonseca');
        $pdf->SetTitle('Relatório de Materiais');
        $pdf->SetSubject('Relatório de Materiais');
        $pdf->SetKeywords('TCPDF, PDF, relatório');

        // Adiciona uma página
        $pdf->AddPage();

        // Define o título
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Relatório de Materiais', 0, 1, 'C');

        // Define o cabeçalho da tabela
        $header = array('Nome', 'Categoria', 'Descrição', 'Disponível', 'Retirado Por', 'Destino', 'Data Retirada', 'Data Devolução');
        $w = array(30, 30, 50, 20, 30, 30, 30, 30); // Largura das colunas

        $pdf->SetFillColor(200, 220, 255);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('helvetica', 'B', 12);

        // Cabeçalho da tabela
        foreach ($header as $i => $title) {
            $pdf->Cell($w[$i], 10, $title, 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // Define a fonte para o corpo da tabela
        $pdf->SetFont('helvetica', '', 12);

        // Adiciona os dados da tabela
        while ($row = $result->fetch_assoc()) {
            $disponivel = $row['disponivel'] ? 'Sim' : 'Não';
            $retirado_por = $row['retirado_por'] ? $row['retirado_por'] : '-';
            $destino = $row['destino'] ? $row['destino'] : '-';
            $data_retirada = $row['data_retirada'] ? $row['data_retirada'] : '-';
            $data_devolucao = $row['data_devolucao'] ? $row['data_devolucao'] : '-';

            $pdf->Cell($w[0], 10, htmlspecialchars($row['nome']), 1);
            $pdf->Cell($w[1], 10, htmlspecialchars($row['categoria']), 1);
            $pdf->Cell($w[2], 10, htmlspecialchars($row['descricao']), 1);
            $pdf->Cell($w[3], 10, $disponivel, 1);
            $pdf->Cell($w[4], 10, $retirado_por, 1);
            $pdf->Cell($w[5], 10, $destino, 1);
            $pdf->Cell($w[6], 10, $data_retirada, 1);
            $pdf->Cell($w[7], 10, $data_devolucao, 1);
            $pdf->Ln();
        }

        // Gera o PDF
        $pdf->Output('relatorio_materiais.pdf', 'D');
        // Limpa o buffer de saída e evita que dados sejam enviados ao navegador
        ob_clean();

    } else {
        echo "<p class='error'>Nenhum material encontrado para a categoria selecionada.</p>";
    }
} else if ($format === 'screen') {
    if ($result->num_rows > 0) {
        echo "<table class='material-table'>";
        echo "<thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
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
            echo "<td data-label='Nome'>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td data-label='Categoria'>" . htmlspecialchars($row['categoria']) . "</td>";
            echo "<td data-label='Descrição'>" . htmlspecialchars($row['descricao']) . "</td>";
            echo "<td data-label='Foto'><img src='uploads/" . htmlspecialchars($row['foto'])
                . "' alt='Foto' width='90'></td>";
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
        echo "<p class='error'>Nenhum material encontrado para a categoria selecionada.</p>";
    }
}

// Fecha a conexão
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();

ob_end_flush(); // Envia o buffer de saída e desativa o buffering
?>
            <button onclick="window.location.href='../index.php';" class="btn-back">Voltar para a página
                principal</button>
        </div>
    </body>

    </html>