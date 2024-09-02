<!DOCTYPE html>
<html>

<head>
    <title>Adicionar Material</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
    <div class="container">
        <h2>Adicionar Material</h2>
        <form action="add_material.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descrcao" class="form-control" required>
            </div>
            <div class="form-group">
                 <label for="categoria">Categoria:</label>
                 <select name="categoria" class="form-cat" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="Automóvel">Automóvel</option>
                    <option value="Ferramentas">Ferramentas</option>
                    <option value="Construcao">Construção</option>
                    <option value="Diversos">Diversos</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" name="foto" class="form-cat">
                <input type="submit" name="submit" value="Adicionar" class="btn">
            </div>

        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexao.php';

            $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
            $descricao = htmlspecialchars($_POST['descricao'], ENT_QUOTES, 'UTF-8');
            $categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
            $foto = $_FILES['foto']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto);

            // Verifica o tipo e o tamanho do arquivo
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5 MB
            if (($_FILES['foto']['size'])>0){
                if (in_array($_FILES['foto']['type'], $allowed_types) && $_FILES['foto']['size'] <= $max_size) {
                 if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                    // Usa uma consulta preparada
                            $stmt = $conn->prepare("INSERT INTO materiais (nome, descricao, categoria, foto) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $nome, $descricao, $categoria, $foto);

                    if ($stmt->execute()) {
                        echo "<p class='success'>Material adicionado com sucesso!</p>";
                    } else {
                        echo "<p class='error'>Erro: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p class='error'>Erro ao fazer upload da foto.</p>";
                }
                } else {
                echo "<p class='error'>Tipo de arquivo inválido ou arquivo muito grande.</p>";
                }
           }

           if (($_FILES['foto']['size'])<=0){
               $stmt = $conn->prepare("INSERT INTO materiais (nome, descricao, categoria, foto) VALUES (?, ?, ?, ?)");
               $stmt->bind_param("ssss", $nome, $descricao, $categoria, $foto);
               if ($stmt->execute()) {
                echo "<p class='success'>Material adicionado com sucesso!</p>";
               } else {
                 echo "<p class='error'>Erro: " . $stmt->error . "</p>";
               }
            }   
            $conn->close();
        }
        ?>
        <button onclick="window.location.href='../index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>

</html>