<?php


require __DIR__ . "/connect.php";

/**
 * ALTERAÇÃO:
 * Uso de filter_input para validar o ID como inteiro.
 * Isso é pra evita que valores inválidos sejam processados.
 */
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

/**
 * ALTERAÇÃO:
 * Uso de filter_input para capturar os dados com mais segurança.
 * - name e document são strings
 * - email é validado com FILTER_VALIDATE_EMAIL
 */
$name = trim(filter_input(INPUT_POST, "name"));
$email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
$document = trim(filter_input(INPUT_POST, "document"));

/**
 * ALTERAÇÃO IMPORTANTE:
 * Remoção do die() e substituição por redirecionamento.
 * Isso melhora a experiência do usuário e mantém o fluxo da aplicação.
 */
if (!$id || !$name || !$email || !$document) {
    header("Location: index.php?error=1");
    exit;
}

try {

    /**
     * Conexão com o banco utilizando a classe Connect.
     */
    $pdo = Connect::getInstance();

   
    $stmt = $pdo->prepare("
        UPDATE users
        SET name = :name,
            email = :email,
            document = :document
        WHERE id = :id
    ");

    /**
     * Execução da query com parâmetros nomeados.
     */
    $updated = $stmt->execute([
        ":id" => $id,
        ":name" => $name,
        ":email" => $email,
        ":document" => $document
    ]);

    /**
     * ALTERAÇÃO:
     * Adicionado feedback ao usuário.
     * success=2 indica atualização realizada com sucesso.
     */
    if ($updated) {
        header("Location: index.php?success=2");
    } else {
        header("Location: index.php?error=2");
    }

} catch (Exception $e) {

    /**
     * ALTERAÇÃO IMPORTANTE:
     * Tratamento de erro com try/catch.
     * Evita quebra do sistema e melhora robustez.
     */
    header("Location: index.php?error=3");
}


exit;