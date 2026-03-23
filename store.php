<?php

require __DIR__ . "/connect.php";

/**
 * Captura e filtra os dados corretamente
 */
$name = trim(filter_input(INPUT_POST, "name"));
$email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
$document = trim(filter_input(INPUT_POST, "document"));

/**
 * Validação
 */
if (!$name || !$email || !$document) {
    header("Location: index.php?error=1");
    exit;
}

try {

    $pdo = Connect::getInstance();

    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, document)
        VALUES (:name, :email, :document)
    ");

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":document" => $document
    ]);

    /**
     * Redireciona com sucesso
     */
    header("Location: index.php?success=1");
    exit;

} catch (Exception $e) {

    /**
     * Tratamento de erro
     */
    header("Location: index.php?error=2");
    exit;
}
