<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar usuário e senha fixos
    if ($username === "admin" && $password === "admin") {
        // Login correto, redirecionar para a página principal (home.php)
        $_SESSION['loggedin'] = true;
        header("Location: home.php");
        exit();
    } else {
        // Login incorreto, exibir mensagem de erro
        $login_error = "Usuário ou senha incorretos. Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Registro de Produtos</title>
    <link rel="stylesheet" href="login.css">
    <style>
        /* Estilo personalizado para a logo */
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 250px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="logo-container">
                <img src="https://i.ibb.co/XWssqGr/9d199cac-6751-4eca-9676-187f7409e4d5.jpg" alt="Logo" class="logo">
            </div>
            <h2>Sistema</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Login:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Entrar</button>
            </form>
            <?php if(isset($login_error)) { ?>
                <p class="error-message"><?php echo $login_error; ?></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
