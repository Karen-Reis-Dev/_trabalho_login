<?php
require 'conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        // 1. CRIPTOGRAFIA: Gerar o Hash da senha
        // O algoritmo PASSWORD_DEFAULT gera um hash seguro e aleatório
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO user (email, senha) VALUES (:email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            // 2. Salvamos o HASH, não a senha real
            $stmt->bindParam(':senha', $senhaHash); 
            $stmt->execute();

            $mensagem = "<p style='color:green'>Usuário cadastrado com sucesso! <a href='login.php'>Fazer Login</a></p>";
        } catch (PDOException $e) {
            $mensagem = "<p style='color:red'>Erro: " . $e->getMessage() . "</p>";
        }
    } else {
        $mensagem = "<p style='color:orange'>Preencha todos os campos!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h2>Criar Conta</h2>
    <?= $mensagem ?>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        
        <button type="submit">Cadastrar</button>
    </form>
    <br>
    <a href="index.php">Voltar ao Menu</a>
</body>
</html>