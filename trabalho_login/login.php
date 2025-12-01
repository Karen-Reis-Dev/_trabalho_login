<?php
require 'conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha']; // A senha que o usuário digitou (ex: "123")

    if (!empty($email) && !empty($senha)) {
        // 1. Buscar o usuário pelo EMAIL
        $sql = "SELECT id, email, senha FROM user WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch();

        if ($usuario) {
            // 2. VERIFICAÇÃO: Comparar a senha digitada com o Hash do banco
            // A variável $usuario['senha'] contém o hash esquisito (ex: $2y$10$Km...)
            if (password_verify($senha, $usuario['senha'])) {
                $mensagem = "<h3 style='color:green'>Login realizado com sucesso! Bem-vindo, " . $usuario['email'] . "</h3>";
            } else {
                $mensagem = "<h3 style='color:red'>Senha incorreta!</h3>";
            }
        } else {
            $mensagem = "<h3 style='color:red'>Usuário não encontrado!</h3>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Acesso ao Sistema</h2>
    <?= $mensagem ?>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
    <br>
    <a href="index.php">Voltar ao Menu</a>
</body>
</html>