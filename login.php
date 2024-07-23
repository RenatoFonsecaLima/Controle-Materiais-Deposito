<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        session_start(); // Inicia a sessão

        // Mostra a mensagem de erro, se houver
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // Remove a mensagem de erro após exibi-la
        }
        ?>
        <form method="POST" action="login_process.php">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <button type="submit" class="btn" id="logar" name="logar">Login</button>
            <button onclick="window.location.href='index.php';" class="btn-back">Voltar para a página principal</button>
        </form>
    </div>
</body>
</html>
