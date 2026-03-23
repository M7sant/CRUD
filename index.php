<?php
require __DIR__ . "/connect.php";

$pdo = Connect::getInstance();

$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();

$totalAlunos = count($users);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP - Painel Administrativo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f5f6fa; }
        .card-header { background-color: #4a69bd; color: #fff; }
        .stat-card { border-left: 5px solid #4a69bd; }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- Painel de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Total de Alunos</h5>
                        <h3><?= $totalAlunos ?></h3>
                    </div>
                    <i class="bi bi-people-fill display-4 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <!-- Formulário de Cadastro -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    Cadastrar Novo Aluno
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success'])) : ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>Usuário cadastrado com sucesso!</div>
                        </div>
                    <?php endif; ?>

                    <form action="store.php" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome:</label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Digite o nome" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail:</label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Digite o e-mail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Curso:</label>
                            <input type="text" name="document" class="form-control form-control-lg" placeholder="Digite o curso" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-person-plus-fill me-1"></i> Cadastrar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Alunos -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    Lista de Alunos
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Cadastrado</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                            <tr>
                                <td class="text-center"><?= $user["id"] ?></td>
                                <td><?= htmlspecialchars($user["name"]) ?></td>
                                <td><?= htmlspecialchars($user["email"]) ?></td>
                                <td><?= htmlspecialchars($user["document"]) ?></td>
                                <td class="text-center"><?= date("d/m/Y H:i", strtotime($user["created_at"])) ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $user["id"] ?>" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $user["id"] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <td colspan="6">Total de alunos: <?= $totalAlunos ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>