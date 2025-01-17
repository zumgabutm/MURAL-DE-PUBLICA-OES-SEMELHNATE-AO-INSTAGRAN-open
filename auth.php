<?php
require 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pin_digitado = $_POST['pin'];

    // Verificar se o usuário e o PIN correspondem
    $stmt = $conn->prepare("SELECT id, name, pin FROM users WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_name, $user_pin);
    $stmt->fetch();
    $stmt->close();

    // Verificar se o PIN está correto
    if ($user_pin === $pin_digitado) {
        // PIN correto, redirecionar para a página principal (home.php)
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_id; // Armazenar o ID do usuário na sessão
        header("Location: home.php");
        exit();
    } else {
        // PIN incorreto, exibir mensagem de erro
        $login_error = "PIN incorreto. Tente novamente.";
    }
}
?>
