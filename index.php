<?php

require __DIR__ . "/connect.php";

$pdo = Connect::getInstance();

$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD PHP</title>

    <!-- Bootstrap para melhorar layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="mb-4">Cadastro de Alunos</h1>

    <!-- MENSAGEM DE SUCESSO -->
    <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success">
            Usuário cadastrado com sucesso!
        </div>
    <?php endif; ?>

    <form action="store.php" method="post" class="card p-4 mb-4 shadow-sm">

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <!-- CORREÇÃO AQUI -->
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Curso:</label>
            <input type="text" name="document" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <h2 class="mb-3">Lista de alunos</h2>

    <table class="table table-striped table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Curso</th>
                <th>Cadastrado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user["id"] ?></td>

                    <!-- SEGURANÇA CONTRA XSS -->
                    <td><?= htmlspecialchars($user["name"]) ?></td>
                    <td><?= htmlspecialchars($user["email"]) ?></td>
                    <td><?= htmlspecialchars($user["document"]) ?></td>

                    <td><?= date("d/m/Y H:i", strtotime($user["created_at"])) ?></td>

                    <td>
                        <a href="edit.php?id=<?= $user["id"] ?>" class="btn btn-sm btn-warning">Editar</a>

                        <a href="delete.php?id=<?= $user["id"] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                           Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    Total de alunos: <?= count($users) ?>
                </td>
            </tr>
        </tfoot>
    </table>

</div>

</body>

</html>