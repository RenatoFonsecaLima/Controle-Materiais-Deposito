<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Material</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <input type="submit" name="submit" value="Adicionar" class="btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexao.php';
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $foto = $_FILES['foto']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $sql = "INSERT INTO materiais (nome, descricao, foto) VALUES ('$nome', '$descricao', '$foto')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p class='success'>Material adicionado com sucesso!</p>";
                } else {
                    echo "<p class='error'>Erro: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                echo "<p class='error'>Erro ao fazer upload da foto.</p>";
            }
            $conn->close();
        }
        ?>
        <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
    </div>
</body>
</html>
