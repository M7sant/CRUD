<?php

require_once __DIR__ . "/connect.php";

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connect::getInstance();
    }

    public function all(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM users ORDER BY id ASC");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function findById(int $id): array|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([":id" => $id]);

            $user = $stmt->fetch();
            return $user ?: null;

        } catch (Exception $e) {
            return null;
        }
    }

    public function create(string $name, string $email, string $document): bool
    {
        if (empty($name) || empty($email) || empty($document)) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, document)
                VALUES (:name, :email, :document)
            ");

            return $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":document" => $document
            ]);

        } catch (Exception $e) {
            return false;
        }
    }

    public function update(int $id, string $name, string $email, string $document): bool
    {
        if ($id <= 0 || empty($name) || empty($email) || empty($document)) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("
                UPDATE users
                SET name = :name,
                    email = :email,
                    document = :document
                WHERE id = :id
            ");

            return $stmt->execute([
                ":id" => $id,
                ":name" => $name,
                ":email" => $email,
                ":document" => $document
            ]);

        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");

            return $stmt->execute([
                ":id" => $id
            ]);

        } catch (Exception $e) {
            return false;
        }
    }
}