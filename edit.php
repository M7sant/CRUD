<?php


require __DIR__ . "/connect.php";

/**
 * ALTERAÇÃO:
 * Validação do ID usando filter_input.
 * Garante que o valor seja um inteiro válido.
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * ALTERAÇÃO IMPORTANTE:
 * Remoção do die() e substituição por redirecionamento.
 * Isso melhora a experiência do usuário.
 */
if (!$id) {
    header("Location: index.php?error=1");
    exit;
}

try {

    /**
     * Conexão com o banco de dados.
     */
    $pdo = Connect::getInstance();

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

    /**
     * Execução da consulta.
     */
    $stmt->execute([":id" => $id]);

    /**
     * Busca do usuário.
     */
    $user = $stmt->fetch();

    /**
     * ALTERAÇÃO:
     * Caso o usuário não exista, redireciona ao invés de usar die().
     */
    if (!$user) {
        header("Location: index.php?error=2");
        exit;
    }

} catch (Exception $e) {

    
    header("Location: index.php?error=3");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar aluno</title>

    <!-- MELHORIA: Bootstrap para layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Editar aluno</h1>

    <!--
        Formulário para envio ao update.php
    -->
    <form action="update.php" method="post" class="card p-4 shadow-sm">

        <!-- Campo oculto com ID -->
        <input type="hidden" name="id" value="<?= $user["id"] ?>">

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <!-- Segurança com htmlspecialchars -->
            <input type="text" name="name" 
                   value="<?= htmlspecialchars($user["name"]) ?>" 
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" 
                   value="<?= htmlspecialchars($user["email"]) ?>" 
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Curso:</label>
            <input type="text" name="document" 
                   value="<?= htmlspecialchars($user["document"]) ?>" 
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>

    </form>

</div>

</body>

</html>