<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura o parâmetro "id" enviado pela URL
 * e valida se ele é um número inteiro válido.
 *
 * Exemplo:
 * delete.php?id=3
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * Se o ID não for válido, interrompe a execução.
 */
if (!$id) {
    die("ID inválido.");
}