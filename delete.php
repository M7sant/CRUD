<?php


require __DIR__ . "/connect.php";

/**
 * ALTERAÇÃO:
 * Uso de filter_input para validar o ID recebido via GET.
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

    /**
     * Prepared statement para evitar SQL Injection.
     */
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");

    /**
     * Executa a exclusão.
     */
    $deleted = $stmt->execute([
        ":id" => $id
    ]);

    /**
     * ALTERAÇÃO:
     * Feedback ao usuário após a operação.
     * success=3 → exclusão realizada com sucesso
     */
    if ($deleted) {
        header("Location: index.php?success=3");
    } else {
        header("Location: index.php?error=2");
    }

} catch (Exception $e) {

   
    header("Location: index.php?error=3");
}


exit;